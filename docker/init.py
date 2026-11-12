from pathlib import Path
import secrets

path = Path('.env')
if not path.exists():
    path.write_text(Path('.env.example').read_text())
text = path.read_text()
lines = text.splitlines()
if not any(line.startswith('SECURITY_SALT=') and line.split('=', 1)[1].strip() for line in lines):
    lines = [line for line in lines if not line.startswith('SECURITY_SALT=')]
    lines.append('SECURITY_SALT=' + secrets.token_hex(32))
    path.write_text('\n'.join(lines) + '\n')
path.chmod(0o600)
print('.env ready; review paths, URL and proxy IPs before starting.')
