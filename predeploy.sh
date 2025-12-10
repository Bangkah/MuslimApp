#!/bin/bash

# Buat folder database jika belum ada
mkdir -p /var/lib/render/data

# Buat file SQLite jika belum ada
if [ ! -f /var/lib/render/data/database.sqlite ]; then
    touch /var/lib/render/data/database.sqlite
fi

# Set permission
chmod 777 /var/lib/render/data/database.sqlite

# Jalankan migrate dan seed
php artisan migrate --seed --force
