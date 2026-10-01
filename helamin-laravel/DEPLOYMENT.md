# Инструкция по деплою админки Helamin

## Требования
- PHP >= 8.3 с расширениями: intl, pdo, mbstring, openssl, ctype
- Composer
- База данных (MySQL/PostgreSQL/SQLite)

## Шаги для деплоя

### 1. Обновление зависимостей
```bash
composer install --no-dev --optimize-autoloader
```

### 2. Настройка .env
```env
APP_NAME=Helamin
APP_ENV=production
APP_KEY=base64:ваш_ключ
APP_DEBUG=false
APP_URL=https://helamin.ru

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=helamin
DB_USERNAME=helamin
DB_PASSWORD=ваш_пароль
```

### 3. Запуск миграций
```bash
php artisan migrate --force
```

### 4. Запуск сидеров (для создания администратора)
```bash
php artisan db:seed --class=AdminUserSeeder --force
php artisan db:seed --class=PageSeeder --force
```

### 5. Очистка кэша
```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
```

## Управление страницами
Через админку можно:
- Добавлять новые страницы
- Редактировать контент существующих страниц
- Менять SEO-описания
- Включать/выключать страницы

Для изменения контента:
1. Войдите в админку по /admin/login (учётные данные задаются в .env)
2. Перейдите в раздел "Pages"
3. Выберите страницу для редактирования
4. Внесите изменения и сохраните