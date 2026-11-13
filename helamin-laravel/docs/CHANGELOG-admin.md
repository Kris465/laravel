# Helamin — журнал изменений

## Ветка `chore/stabilize`

Приведено в порядок перед клиентскими правками.

### Исправлено

- `UserFactory` и `config/auth.php` восстановлены после фильтрации истории Git:
  слово `password` было заменено маркером цензуры прямо в коде.
- `filament/filament` перенесён из `require-dev` в `require`, `composer.lock`
  переклассифицирован: `composer install --no-dev` больше не ломает админку.
- `User` реализует `FilamentUser::canAccessPanel()` — в не-local окружении
  панель доступна только пользователям с `is_admin = true`.
- `AdminMiddleware` берёт пользователя из `$request->user()`, а не из глобального `Auth`.
- `AdminUserSeeder` читает креды через `config()`, поэтому работает при `config:cache`.
- `deploy.sh`: единый путь `temp-laravel`, `filament:assets`, `storage:link`, права `775`.

### Архитектура

- Один источник контента — таблица `pages`. `PageSeeder` содержит 19 страниц,
  весь текст перенесён из статических Blade-шаблонов в Markdown и работает
  через `updateOrCreate`.
- Удалены 29 мёртвых Blade-шаблонов, `web_old.php`, `README_old.md`,
  `welcome.blade.php` и неиспользуемый Vite/Tailwind-контур.
- Удалены разделы «Отрасли промышленности» и «Референции» из роутов, меню и сидера.
- Добавлены реальные feature/unit-тесты вместо заглушек: `php artisan test` — 13 passed.

### Безопасность

- Контент рендерится через `Str::markdown` (`html_input => 'strip'`,
  `allow_unsafe_links => false`); сырой HTML больше не выводится через `{!! !!}`.
- CSP вынесен из `<meta>` в HTTP-заголовок, добавлены `X-Content-Type-Options`,
  `X-Frame-Options`, `Referrer-Policy`; админка/Livewire исключены.
- Убран внешний Google Fonts, используется системный шрифт.

### Админка для менеджеров

- Форма содержит только заголовок, Markdown-текст, meta description,
  картинки и PDF. Поля `slug`, `type`, `is_active`, создание и удаление страниц убраны.
- Массовая загрузка картинок (JPG/PNG/WebP/GIF/AVIF, без SVG) с изменением порядка.
- Массовая загрузка PDF в `storage/app/public/documents`; готовые Markdown-ссылки
  показываются в «Просмотре», список документов выводится на странице автоматически.
- Галерея и список документов оформлены в `public/css/media.css`.

### Отложено

- Фоновая картинка с водой (плитка): ждём изображение от клиента. Вставляется
  одной правкой в `public/css/app.css`, без переделки адаптивности.
