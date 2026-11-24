# Деплой Helamin

## Требования

- PHP >= 8.3 (`intl`, `pdo`, `mbstring`, `openssl`, `ctype`)
- Composer
- MySQL (или SQLite для локальной разработки)
- Apache с `mod_rewrite`; `DocumentRoot` указывает на `public/`

На хостинге приложение живёт в `/home/helamin/helamin.ru/temp-laravel` —
этот же путь указан в `helamin-ru-laravel.conf` и `htaccess-laravel-redirect`
(оба лежат в корне репозитория, на уровень выше `helamin-laravel/`).

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
php artisan media:sync
```

`media:sync` разово регистрирует в медиатеке файлы, загруженные до обновления
(им раздаются стабильные `/media/{id}`). Команда идемпотентна и уже встроена
в `deploy.sh`.

> Файлы менеджеры загружают **только через `/admin`**. Загрузка по FTP минует БД:
> файл не появится ни в галерее, ни в медиатеке, а переименование на хостинге
> (кириллица, пробелы, регистр) снова даст битые ссылки. Если файл всё же
> переименовали — откройте `/admin/media`, найдите файл и поправьте
> «Фактический путь файла» (якорь `path` не трогайте), тексты править не надо.

`PageSeeder` идемпотентен (`updateOrCreate`), поэтому его можно запускать
повторно. Он деактивирует slug удалённых разделов, но не удаляет данные.

### 4. Ассеты и публичная папка

```bash
php artisan filament:assets
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

Картинки менеджеров лежат в `storage/app/public/images`, PDF — в
`storage/app/public/documents`, фон сайта — в `storage/app/public/backgrounds`.
Все три папки доступны по URL `/storage/...`. URL публичного диска задан в
`config/filesystems.php` как относительный `/storage`, поэтому превью в админке
и ссылки на медиа не зависят от `APP_URL` и работают на любом хосте.
Без `storage:link` ссылки на документы, галерея и фон не откроются.

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
- в админке на странице «Новости» видна «Лента новостей» с кнопкой
  «Добавить новость», а на остальных страницах её нет; добавленный блок
  выводится карточкой на `/news`;
- `/admin/login` доступен, гость редиректится, менеджер видит только поля контента;
- PDF открывается/скачивается по ссылке из текста; картинка, вставленная кнопкой,
  отображается на месте ссылки;
- автоматических блоков со списками файлов нет ни на публичных страницах,
  ни в «Просмотре» админки (`/admin/pages/{id}` открывается без ошибок);
- PDF удаляется из формы без «залипания», имя с пробелом даёт рабочую ссылку;
- ссылка `/media/1` открывает загруженный файл (200, не редирект), битых
  картинок в тексте нет; кнопка «Вставить файл в текст» видна в форме
  редактирования, а в «Медиатеке» у всех файлов стоит `✓`;
  `php artisan media:check` не показывает `⚠ НЕ НАЙДЕН`;
- мини-превью появляется у PDF,
  вставленного в текст, и при наведении/клике раскрывается на весь экран
  (в консоли браузера нет ошибок CSP/X-Frame-Options);
- фон приглушён равномерно на всю страницу: нет ни белого прямоугольника под
  текстом, ни полосы яркой картинки перед футером; заголовки и ссылки в
  контенте оформлены в едином стиле;
- на вкладке браузера красная H;
- заголовок `Content-Security-Policy` приходит на публичных страницах.

> Деплой в репозиторий сам по себе ничего не меняет на сайте: изменения
> вступают в силу только после выполнения шагов на хостинге.
