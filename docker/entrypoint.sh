#!/bin/sh
set -eu
: "${SECURITY_SALT:?SECURITY_SALT must be configured}"
mkdir -p /app/tmp/cache/models /app/tmp/cache/persistent /app/tmp/cache/views /app/tmp/sessions
for dir in /app/db /app/storage /app/logs /app/tmp; do
    test -w "$dir" || { echo "Not writable: $dir (container UID $(id -u)); see README" >&2; exit 1; }
done
exec "$@"
