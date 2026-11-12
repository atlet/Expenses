"""Run with: python3 -m unittest discover -s tests/integration -v."""
import hashlib
from pathlib import Path
import shutil
import sqlite3
import subprocess
import tempfile
import unittest

ROOT = Path(__file__).resolve().parents[2]
NORMAL = '''2026/09/30 * Rent
    Expenses:Najemnina 100.00 €
    Expenses:StroškiBanke 0.50 €
    Person:Andraž

2026/09/30 * Payment
    Person:Andraž 20.00 €
    Person:Borut
'''
EXPLICIT = '''2026/09/30 * MM-Biro d.o.o. Jul 2026
    Expensesextra:Najemnina 130.32 €
    Expensesextra:StroškiBanke 0.56 €
    [Share] 130.88 €
    [Share:Person:Andraž] -43.63 €
    [Share:Person:Iztok] -43.63 €
    [Share:Person:Borut] -43.62 €
    Person:Andraž
'''


class LedgerImportTest(unittest.TestCase):
    def setUp(self):
        self.temp = tempfile.TemporaryDirectory()
        self.addCleanup(self.temp.cleanup)
        self.root = Path(self.temp.name)
        (self.root / 'bin').mkdir()
        (self.root / 'db').mkdir()
        shutil.copyfile(ROOT / 'bin/import-ledger.php', self.root / 'bin/import-ledger.php')
        self.database = self.root / 'db/app.sqlite'
        self.source = self.root / 'input.ledger'
        with sqlite3.connect(self.database) as db:
            db.executescript('''
                CREATE TABLE people (id INTEGER PRIMARY KEY, name TEXT);
                INSERT INTO people VALUES (1, 'Andraž'), (2, 'Izak'), (3, 'Borut');
                CREATE TABLE expense_categories (id INTEGER PRIMARY KEY, name TEXT);
                INSERT INTO expense_categories VALUES (1, 'Internet'), (2, 'Najem'), (3, 'Ostalo');
                CREATE TABLE expenses (id INTEGER PRIMARY KEY, title, amount, commission,
                    expense_date, paid_by_id, notes, created, modified, expense_category_id,
                    supplier_id, is_paid, paid_date);
                CREATE TABLE expense_splits (expense_id, person_id, share_ratio NUMERIC, created);
                CREATE TABLE payments (from_person_id, to_person_id, amount, payment_date, notes, created, modified);
                CREATE TABLE expense_attachments (expense_id);
            ''')

    def run_import(self, content, dry=False):
        self.source.write_text(content)
        return subprocess.run(['php', str(self.root / 'bin/import-ledger.php'),
                               str(self.source)] + (['--dry-run'] if dry else []),
                              capture_output=True, text=True)

    def digest(self):
        return hashlib.sha256(self.database.read_bytes()).hexdigest()

    def test_regular_and_explicit_import(self):
        result = self.run_import(NORMAL + '\n' + EXPLICIT)
        self.assertEqual(result.returncode, 0, result.stderr)
        with sqlite3.connect(self.database) as db:
            self.assertEqual(db.execute('SELECT count(*) FROM expenses').fetchone()[0], 2)
            self.assertEqual(db.execute('SELECT from_person_id, to_person_id, amount FROM payments').fetchone(), (3, 1, '20.00'))
            shares = db.execute('''SELECT p.name, round(s.share_ratio * (e.amount + e.commission), 2)
                FROM expense_splits s JOIN expenses e ON e.id = s.expense_id
                JOIN people p ON p.id = s.person_id WHERE e.title LIKE 'MM-Biro%' ORDER BY p.id''').fetchall()
            self.assertEqual(shares, [('Andraž', 43.63), ('Izak', 43.63), ('Borut', 43.62)])
            self.assertEqual(db.execute('SELECT share_ratio FROM expense_splits WHERE expense_id = 1').fetchall(), [(0.5,), (0.5,)])
        # Avoid timestamp collision with the backup while testing immediate repetition.
        for backup in (self.root / 'db').glob('*.bak'):
            backup.rename(backup.with_suffix('.first'))
        result = self.run_import(NORMAL + '\n' + EXPLICIT)
        self.assertEqual(result.returncode, 0, result.stderr)
        with sqlite3.connect(self.database) as db:
            self.assertEqual(db.execute('SELECT count(*) FROM expenses').fetchone()[0], 2)
            self.assertEqual(db.execute('SELECT count(*) FROM payments').fetchone()[0], 1)
            self.assertEqual(db.execute('SELECT count(*) FROM expense_splits').fetchone()[0], 5)

    def test_dry_run(self):
        before = self.digest()
        result = self.run_import(EXPLICIT, dry=True)
        self.assertEqual(result.returncode, 0, result.stderr)
        self.assertEqual(self.digest(), before)
        self.assertEqual(list((self.root / 'db').glob('*.bak')), [])

    def test_invalid_entries_leave_database_unchanged(self):
        for content in [EXPLICIT.replace('-43.62', '-43.61'),
                        EXPLICIT.replace('130.88 €', '130.89 €'),
                        EXPLICIT.replace('Person:Iztok]', 'Person:Unknown]'),
                        EXPLICIT.replace('[Share]', '[Unsupported]'),
                        EXPLICIT.replace('-43.62', '43.62'),
                        EXPLICIT.replace('    Person:Andraž', '    [Share:Person:Borut] -1.00 €\n    Person:Andraž'),
                        NORMAL + '    Assets:Bank 1.00 €\n', '']:
            with self.subTest(content=content):
                before = self.digest()
                result = self.run_import(content)
                self.assertNotEqual(result.returncode, 0)
                self.assertEqual(self.digest(), before)
                self.assertEqual(list((self.root / 'db').glob('*.bak')), [])

    def test_historical_three_person_default(self):
        result = self.run_import(NORMAL.replace('2026/09/30', '2026/07/30'))
        self.assertEqual(result.returncode, 0, result.stderr)
        with sqlite3.connect(self.database) as db:
            self.assertEqual(db.execute('SELECT share_ratio FROM expense_splits').fetchall(), [(0.3333,)] * 3)


if __name__ == '__main__':
    unittest.main()
