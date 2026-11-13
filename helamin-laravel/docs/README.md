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
- несколько картинок за раз (JPG, PNG, WebP, GIF, AVIF; SVG запрещён);
- несколько PDF за раз — складываются в `storage/app/public/documents`;
- в тексте можно вставить ссылку на документ: `[Скачать паспорт](/storage/documents/passport.pdf)`.
  Готовые ссылки видны в разделе «Просмотр» страницы, а все загруженные PDF
  автоматически выводятся списком под текстом.

Менеджеры **не меняют структуру**: поля `slug`, `type`, `is_active` убраны из формы,
создание и удаление страниц отключены. Новую страницу добавляет разработчик:
строка в `PageSeeder` + именованный роут в `routes/web.php`.

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
