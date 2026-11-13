# Деплой Helamin

## Требования

- PHP >= 8.3 (`intl`, `pdo`, `mbstring`, `openssl`, `ctype`)
- Composer
- MySQL (или SQLite для локальной разработки)
- Apache с `mod_rewrite`; `DocumentRoot` указывает на `public/`

На хостинге приложение живёт в `/home/helamin/helamin.ru/temp-laravel` —
этот же путь указан в `helamin-ru-laravel.conf` и `htaccess-laravel-redirect`.

## Шаги

### 1. Код и зависимости

```bash
cd /home/helamin/helamin.ru/temp-laravel
git pull origin main
composer install --no-dev --optimize-autoloader
```

`filament/filament` находится в `require`, поэтому админка работает и без
dev-зависимостей.

### 2. `.env`

```env
APP_NAME=Helamin
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=https://helamin.ru

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=helamin
DB_USERNAME=helamin
DB_PASSWORD=...

ADMIN_EMAIL=...
ADMIN_PASSWORD=...
```

Пароль администратора задаётся только через `.env`; значения читаются через
`config/helamin.php`, поэтому `config:cache` не ломает сидер.

### 3. Миграции и контент

```bash
php artisan migrate --force
php artisan db:seed --class=AdminUserSeeder --force
php artisan db:seed --class=PageSeeder --force
```

`PageSeeder` идемпотентен (`updateOrCreate`), поэтому его можно запускать
повторно. Он деактивирует slug удалённых разделов, но не удаляет данные.

### 4. Ассеты и публичная папка

```bash
php artisan filament:assets
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

Картинки менеджеров лежат в `storage/app/public/images`, PDF — в
`storage/app/public/documents`, оба доступны по URL `/storage/...`.
Без `storage:link` ссылки на документы и галерея не откроются.

### 5. Кэш

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Готовый сценарий — `bash deploy.sh` из каталога приложения.

## Проверка после деплоя

- все пункты меню открываются (19 страниц);
- `/admin/login` доступен, гость редиректится, менеджер видит только поля контента;
- PDF скачивается по ссылке из текста и из списка документов;
- загруженная картинка отображается в галерее;
- заголовок `Content-Security-Policy` приходит на публичных страницах.

> Деплой в репозиторий сам по себе ничего не меняет на сайте: изменения
> вступают в силу только после выполнения шагов на хостинге.
