# Helamin — сайт компании

Восстановление сайта после JS-инъекции. Цель — сохранить информацию, сделать
адаптивный интерфейс и не допустить повторной инъекции: минимум зависимостей,
никаких внешних скриптов, контент проходит санитизацию перед выводом.

Вся документация лежит в `docs/`. Пути в таблицах ниже указаны от каталога
`helamin-laravel/` (само приложение), а не от корня репозитория.

## Стек

- Laravel 13 / PHP 8.3+
- Filament 5 — админка для менеджеров (в `require`, работает при `--no-dev`)
- Blade + чистый CSS (`public/css/app.css`, `public/css/media.css`) + минимальный свой JS
- Markdown для контента: `league/commonmark` уже входит в Laravel, новых пакетов нет
- SQLite локально, MySQL на хостинге

## Где что лежит

| Что | Путь |
|---|---|
| Структура страниц (URL) | `routes/web.php` |
| Стартовый контент страниц | `database/seeders/PageSeeder.php` |
| Публичные шаблоны | `resources/views/layouts/app.blade.php`, `resources/views/pages/dynamic.blade.php`, `home_dynamic.blade.php` |
| Галерея и PDF | `resources/views/partials/page-media.blade.php` |
| Стили | `public/css/app.css`, `public/css/media.css` |
| JS (бургер-меню) | `public/js/app.js` |
| Форма админки | `app/Filament/Resources/Pages/Schemas/PageForm.php` |
| Безопасный рендер | `App\Models\Page::renderedContent()` |
| URL медиа (экранирование) | `App\Models\Page::mediaUrl()` |
| Фон сайта | `app/Providers/AppServiceProvider.php`, правило `body` в `public/css/media.css` |
| Иконка вкладки | `public/favicon.svg` |
| Заголовки безопасности | `app/Http/Middleware/AddSecurityHeaders.php` |

**Один источник контента — таблица `pages`.** Статических Blade-страниц больше нет.

## Страницы (19)

`/`, `/o-produkte` (+ 5 подстраниц), `/oblast-primeneniya` (+ 7 подстраниц),
`/news`, `/biblioteka`, `/oprosnyy-list`, `/contacts`.

Разделы «Отрасли промышленности» и «Референции» удалены по просьбе клиента.

## Админка для менеджеров

Вход: `/admin/login`. Попасть может только пользователь с `is_admin = true`
(`User::canAccessPanel()` + `AdminMiddleware`).

Менеджеры редактируют **только контент**:

- заголовок, текст (Markdown), meta description;
- несколько картинок за раз (JPG, PNG, WebP, GIF, AVIF; SVG запрещён) — папка
  `storage/app/public/images`; они сразу видны галереей под текстом, так что
  несколько вариантов можно сравнить зрительно;
- несколько PDF за раз — папка `storage/app/public/documents`;
- ссылку на документ в тексте: `[Скачать паспорт](/storage/documents/passport.pdf)`;
- картинку в тексте: `![Описание картинки](/storage/images/photo.jpg)`.

Готовые, уже экранированные ссылки на **все** загруженные файлы показаны в разделе
«Просмотр» страницы. Пробелы и кириллица в именах допустимы: `Page::mediaUrl()`
кодирует каждый сегмент пути, поэтому ссылка не рвётся. При удалении файла из
формы он удаляется и с диска.

Менеджеры **не меняют структуру**: поля `slug`, `type`, `is_active` убраны из формы,
создание и удаление страниц запрещены на уровне `PageResource::canCreate()` /
`canDelete()`, кнопки удаления убраны из шапки редактирования. Главная страница
дополнительно защищена в `Page::booted()` — её нельзя удалить даже из консоли.
Новую страницу добавляет разработчик: строка в `PageSeeder` + именованный роут
в `routes/web.php`.

Форма свёрстана в две колонки: слева широкий редактор текста (2/3 ширины),
справа вертикальный стек маленьких блоков (картинки, PDF, фон, SEO). На
мобильном всё складывается в одну колонку.

> Локально `APP_URL` должен совпадать с адресом, на котором открыт сайт
> (`http://127.0.0.1:8000` для `php artisan serve`). URL самого публичного диска
> в `config/filesystems.php` сделан относительным (`/storage`), поэтому превью
> Filament и медиа работают на любом хосте.

## Фон сайта

В карточке **главной страницы** (`/admin`) есть секция «Фон сайта»: просто
загрузите картинку, и она ляжет плиткой на светлую область всех страниц.
Можно менять сколько угодно раз. Плитка не масштабируется, поэтому бесшовный
рисунок не ломается ни на десктопе, ни на мобильном; `.main-content` при этом
становится полупрозрачным, чтобы текст оставался читаемым.

Если хочется перебрать варианты вручную, без админки: положите файл в
`public/images/` и пропишите `background-image: url('../images/water.jpg');`
в правиле `body` файла `public/css/media.css`.

## Безопасность

- Контент рендерится через `Str::markdown` с `html_input => 'strip'` и
  `allow_unsafe_links => false`: сырой HTML и `javascript:`-ссылки не проходят.
- CSP и `X-Content-Type-Options` ставятся HTTP-заголовком, а не `<meta>`;
  админка и Livewire исключены, чтобы не ломать inline-скрипты Filament.
- Внешних шрифтов и скриптов нет, используется системный стек шрифтов.
- `.env`, `database/*.sqlite`, `storage/logs`, `vendor` не коммитятся.

## Локальный запуск

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --force
php artisan db:seed --class=PageSeeder --force
php artisan storage:link
php artisan serve
```

Администратора создаёт `AdminUserSeeder` — задайте `ADMIN_EMAIL` и
`ADMIN_PASSWORD` в `.env` (пароль минимум 12 символов).

## Проверки перед клиентскими правками

```bash
composer validate
php vendor/bin/pint --test
php artisan test
```

## Деплой

См. [DEPLOYMENT.md](DEPLOYMENT.md) и [CHANGELOG-admin.md](CHANGELOG-admin.md)
в этой же папке. Корень репозитория содержит файлы хостинга
(`helamin-ru-laravel.conf`, `htaccess-laravel-redirect`, `docs-index.html`),
само приложение лежит в `helamin-laravel/`.
