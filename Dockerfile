# Bonyaan — single-container demo image for Render.com
#
# This is a REVIEW/DEMO deployment, not a production one:
#   - Uses SQLite (a single file, re-seeded on every deploy — see start.sh).
#   - Uses `php artisan serve` directly (fine for low-traffic demo/portfolio
#     traffic; a real production deploy would use PHP-FPM + nginx instead).

FROM php:8.3-cli

# System dependencies + PHP extensions Laravel/Bonyaan needs.
# (mbstring, ctype, fileinfo, etc. already ship with the base php:8.3-cli image.)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install \
    pdo \
    pdo_sqlite \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Node (needed to build the Vite/Tailwind assets referenced by package.json)
COPY --from=node:20-slim /usr/local/bin/node /usr/local/bin/node
COPY --from=node:20-slim /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && npm install --no-audit --no-fund \
    && npm run build \
    && npm cache clean --force

RUN chmod +x start.sh

EXPOSE 10000

CMD ["./start.sh"]