#!/bin/sh
set -eu
operation=${1:?Expected backup, restore or deploy}
backup_dir=$(docker compose config --format json | python3 -c 'import json,sys; print(json.load(sys.stdin)["services"]["app"]["environment"]["BACKUP_DIR"])')
mkdir -p "$backup_dir"
backup_dir=$(cd "$backup_dir" && pwd)
was_running=$(docker compose ps --status running -q app)
archive="stroski-$(date -u +%Y%m%dT%H%M%SZ)-$$.tar.gz"
backup() {
    docker compose run --rm --no-deps --user root --entrypoint sh \
        -v "$backup_dir:/backup" app -ec 'umask 077; tar -czf "/backup/$1" -C /app db storage; chown "$2:$3" "/backup/$1"' sh "$archive" "$(id -u)" "$(id -g)"
    echo "Backup: $backup_dir/$archive"
}
resume() {
    if [ -n "$was_running" ]; then docker compose up -d --wait; fi
}
case "$operation" in
    backup)
        docker compose stop app
        trap resume EXIT
        backup
        ;;
    deploy)
        docker compose build --pull
        docker compose stop app
        make permissions
        backup
        docker compose run --rm --no-deps app php bin/cake.php migrations migrate
        docker compose up -d --wait
        ;;
    restore)
        file=${2:?Set FILE to an archive path}
        test -f "$file" || { echo "Archive not found: $file" >&2; exit 1; }
        python3 - "$file" <<'PY'
import sys, tarfile
from pathlib import PurePosixPath
with tarfile.open(sys.argv[1]) as archive:
    members = archive.getmembers()
    if not members:
        raise SystemExit('Empty archive')
    database = archive.getmember('db/app.sqlite')
    if not database.isfile() or archive.extractfile(database).read(16) != b'SQLite format 3\x00':
        raise SystemExit('Archive must contain a SQLite db/app.sqlite')
    for member in members:
        path = PurePosixPath(member.name)
        if path.is_absolute() or '..' in path.parts or not path.parts or path.parts[0] not in ('db', 'storage') or not (member.isfile() or member.isdir()):
            raise SystemExit('Unsafe archive member: ' + member.name)
PY
        source_dir=$(cd "$(dirname "$file")" && pwd)
        source_name=$(basename "$file")
        docker compose stop app
        backup
        docker compose run --rm --no-deps --user root --entrypoint sh \
            -v "$source_dir:/restore:ro" app -ec '
                find /app/db /app/storage -mindepth 1 -delete
                tar -xzf "/restore/$1" -C /app --no-same-owner
                chown -R www-data:www-data /app/db /app/storage
            ' sh "$source_name"
        resume
        ;;
    *) echo "Unknown operation: $operation" >&2; exit 1 ;;
esac
