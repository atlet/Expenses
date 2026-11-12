# Expenses

Za produkcijsko namestitev glejte spodnji razdelek **Produkcija: Docker Compose + FrankenPHP**.

## One-time Ledger history import

Run `php bin/import-ledger.php` to replace the local SQLite expense and payment history with all transactions from `/home/atlet/Nextcloud/Podjetje/stroski-pisarne.ledger`. You can pass another Ledger file path as the first argument. The command validates and reports counts before writing, creates a timestamped `db/*.bak` SQLite backup, and imports everything in one database transaction. Re-running it replaces the imported history rather than duplicating it. People, categories, and suppliers remain in place. Ledger's `Iztok` maps to the existing `Izak` person.

Use `php bin/import-ledger.php --dry-run` (optionally with a source path) to parse and validate the journal and database mappings without writing or creating a backup. `Expensesextra:` uses the same categories as `Expenses:`. Explicit `[Share]` and negative `[Share:Person:name]` amounts must balance the expense including fees and override the default date-based split (three people before August 2026, two afterwards). Unknown or invalid postings stop the import before any database changes.

Run importer regression tests with `python3 -m unittest discover -s tests/integration -v`.

An application for tracking personal and business expenses, built with the CakePHP 5.2 framework.

## Overview

"Expenses" enables accurate recording and analysis of financial outflows. It is designed for easy data entry and clear reporting.

### Key Features

*   **Expense Tracking**: Record one-time and recurring expenses.
*   **Categorization**: Organize expenses by categories for better transparency.
*   **Splits**: Ability to split expenses (e.g., between multiple people or departments).
*   **People Management**: Manage users and people associated with expenses.
*   **Attachments**: Store and manage proofs of purchase (invoices) with expenses.
*   **Statistics**: Comprehensive Dashboard and expense reports.

## Technologies

*   **PHP**: 8.1+
*   **Framework**: CakePHP 5.2
*   **Database**: SQLite (produkcijski Docker Compose)
*   **Authentication**: CakePHP Authentication plugin

## Installation

To run the project locally, follow these steps:

1.  **Clone the Repository**
    ```bash
    git clone <repository-url>
    cd expenses
    ```

2.  **Install Dependencies**
    Use Composer to install the required libraries:
    ```bash
    composer install
    ```

3.  **Configuration**
    Copy the configuration template and edit the database settings:
    ```bash
    cp config/app_local.example.php config/app_local.php
    ```
    In `config/app_local.php`, set your MySQL database access details (host, username, password, database).

4.  **Database**
    Run migrations to set up the database structure:
    ```bash
    bin/cake migrations migrate
    ```

5.  **Start Server**
    For development, you can use the built-in PHP server:
    ```bash
    bin/cake server
    ```
    The application will be accessible at `http://localhost:8765`.

## Project Structure

*   `src/Controller`: Controllers for managing logic (Expenses, Categories, Users, ...).
*   `src/Model`: Data models and validation.
*   `templates`: Views for the application's presentation layer.
*   `tests`: Application tests.

## License

This project is based on the CakePHP framework and is licensed under the MIT License.

## Automatic recurring expenses

Run `bin/cake recurring_expenses generate` daily. Active templates generate at most
one expense per calendar month in Europe/Ljubljana. Missed runs catch up only the
current month; days 29–31 fall on the last day in shorter months. Manual generation
also counts toward the monthly limit. Editing a template does not change history.
The monthly limit checks the actual linked expense: deleting it allows generation
again. Deleting a template preserves its expense history.

After updating, run the database migrations and clear the model cache before
serving requests (`make migrate` and `make cache-clear` for Docker installations).
Older expenses are linked when generation finds exactly one matching expense for
the current month's last-added/due date, title, amount, commission and payer.
Ambiguous matches are reported for manual review and do not create new expenses;
no matching expense allows generation even when the old last-added date is set.

Example crontab (server timezone Europe/Ljubljana; adjust PHP and project paths):

```cron
0 6 * * * cd /home/atlet/Projekti/stroski && /usr/bin/php bin/cake.php recurring_expenses generate >> logs/recurring-expenses.log 2>&1
```

The command reports added/skipped counts and errors, and exits nonzero on errors.
Install this entry on the application server under the application user.


## Produkcija: Docker Compose + FrankenPHP

Zahteve na gostitelju: Docker Engine z Compose v2, GNU Make in Python 3.
Slika uporablja FrankenPHP s PHP 8.4 in Composer 2. Koda in produkcijske
odvisnosti so v sliki; spremembe kode ali odvisnosti objavite z novo izdelavo.
Composer znotraj vsebnika je na voljo, vendar njegove spremembe niso trajne
ob zamenjavi vsebnika. `composer.lock` posodobite v razvojnem okolju in znova
izdelajte sliko. Produkcijska namestitev ne uporablja razvojnih paketov.

### Prvi zagon in obstoječi podatki

```sh
make init
# Uredi .env: APP_FULL_BASE_URL, TRUSTED_PROXIES, poti in vrata.
make build
make permissions
make backup
make migrate
make up
make ps
```

`make init` ohrani obstoječe nastavitve in ustvari manjkajoči salt. Pri prenosu
obstoječe namestitve uporabite njen dosedanji SECURITY_SALT, posebej če uporablja
šifrirane podatke. `.env` je zasebna datoteka in ni vključena v sliko ali Git.

Privzeti poti `./db` in `./storage` uporabljata obstoječo SQLite bazo
`db/app.sqlite` in priponke. Pri selitvi ju kopirajte iz ustavljene stare
namestitve na novi strežnik pred migracijami. `make permissions` nastavi
lastništvo podatkovnih map na uporabnika www-data v sliki; to vpliva tudi na
gostiteljske mape. Dnevniki so v `LOG_DIR`, seje in predpomnilnik v Docker volumnu.
`make down` podatkov ne izbriše. Ne uporabljajte `docker compose down -v`, če
želite ohraniti seje.

Migracije in seed ukazi se ob zagonu ne izvajajo samodejno. Obstoječi uporabniki
ostanejo nespremenjeni. Privzeti UsersSeed vsebuje znano geslo in ni primeren za
produkcijsko sejanje. Pred objavo obstoječemu privzetemu administratorju zamenjajte
geslo prek profila; prazna baza po migracijah še nima uporabnikov.

### Reverse proxy

Privzeti HTTP naslov je `127.0.0.1:8080`; TLS zaključi zunanji reverse proxy.
Nastavite `APP_FULL_BASE_URL=https://stroski.example.com` ter `TRUSTED_PROXIES`
na seznam točnih IP naslovov, ki jih aplikacija vidi kot neposredne proxyje
(v Docker omrežju je to lahko naslov prehoda). Aplikacija zaupa posredovanim
glavam samo pri teh IP naslovih. Proxy mora prepisati `X-Forwarded-Proto`,
`X-Forwarded-Host` in `X-Forwarded-For` ter ohraniti pravilen Host.
Če proxy teče v drugem vsebniku, nastavite dosegljiv HTTP_BIND_IP in omrežni
požarni zid tako, da do HTTP vrat dostopa le proxy. Caddy admin API in samodejni
HTTPS sta izključena; streže se samo `webroot`.

### Upravljanje in obnova

`make help` izpiše vse ukaze. Primeri:

```sh
make deploy
make logs
make shell
make composer ARGS="--version"
make cake ARGS="migrations status"
make cache-clear
make backup
make restore FILE=/absolute/path/stroski-backup.tar.gz
```

`deploy` izdela sliko, ustavi aplikacijo, ustvari kopijo baze in priponk, izvede
migracije in zažene aplikacijo s preverjanjem zdravja. Pri napaki po ustavitvi
ostane aplikacija ustavljena; preverite izpis in uporabite `make up` oziroma
obnovite kopijo. Varnostne kopije so v `BACKUP_DIR` in ne vključujejo `.env`;
njega varno hranite posebej. Kopije redno prenesite tudi na drug strežnik.
`backup` po koncu ponovno zažene aplikacijo, če je prej tekla. Obnova preveri
arhiv pred ustavitvijo, shrani trenutno stanje in zamenja vsebino baze ter
priponk; ob napaki ostane aplikacija ustavljena. Obnova ne izvaja migracij.
Med deploy/backup/restore ne zaganjajte drugih CLI zapisovalcev ali cron opravil.

Za dnevne ponavljajoče stroške dodajte cron na gostitelju (časovni pas
Europe/Ljubljana), s potjo do namestitve in uporabnikom z dostopom do Dockerja:

```cron
0 6 * * * cd /pot/do/stroski && /usr/bin/make recurring >> logs/recurring-expenses.log 2>&1
```

### Preverjanje

```sh
docker compose config --quiet
make build
make up
make composer ARGS="check-platform-reqs --no-dev"
make cake ARGS="--help"
curl -f http://127.0.0.1:8080/users/login
```

Po objavi preverite prijavo prek HTTPS, prikaz statičnih datotek, nalaganje
priponk in ohranitev podatkov po `make deploy`. PHPUnit izvajajte z razvojnimi
odvisnostmi in ločeno testno SQLite bazo, nikoli s produkcijskimi podatki.

### Automaticka priprava dovoljenj

`make up`, `restart`, `composer`, `cake`, `migrate`, `migration-status`,
`cache-clear` in `recurring` pred izvajanjem samodejno uredijo lastnistvo
podatkovnih map za uporabnika www-data (UID 33). Enako naredi `make deploy`
pred migracijami. Ukaz `make permissions` ostaja na voljo za rocni popravek.
To odpravi napako `Not writable: /app/db` tudi po prvem priklopu map.
