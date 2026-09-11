#!/bin/sh
set -e

# Render's free web services have an EPHEMERAL filesystem: every restart /
# redeploy / spin-down-after-15-min-idle wipes local files. That's exactly
# what we want for a public review/demo — it means the demo can never
# accumulate junk data from visitors, and always boots into the same
# clean, seeded state. If this ever becomes a real production deploy
# with real users, replace this with a persistent-disk MySQL/Postgres
# setup instead (see README "Production Setup" notes).

if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
fi

php artisan config:clear
php artisan migrate:fresh --seed --force
php artisan storage:link || true

php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"