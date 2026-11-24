#!/bin/bash
# ============================================
# Helamin Laravel — скрипт деплоя
# Запускать из директории проекта на сервере:
#   cd /home/helamin/helamin.ru/helamin-laravel
#   bash deploy.sh
# ============================================

set -e

echo ">>> Обновление кода из Git..."
git pull origin main

echo ">>> Установка зависимостей Composer..."
composer install --no-dev --optimize-autoloader

echo ">>> Очистка кешей..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo ">>> Запуск миграций..."
php artisan migrate --force

echo ">>> Регистрация уже загруженных файлов в медиатеке..."
php artisan media:sync

echo ">>> Публикация ассетов Filament..."
php artisan filament:assets

# Симлинк на хостинге уже существует: storage:link вернул бы код 1,
# а set -e оборвал бы деплой до кэшей и chmod. Проверяем заранее.
if [ ! -L public/storage ]; then
    echo ">>> Создание ссылки public/storage..."
    php artisan storage:link
else
    echo ">>> Ссылка public/storage уже существует, пропускаем."
fi

echo ">>> Кеширование конфигурации..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ">>> Установка прав..."
chmod -R 775 storage bootstrap/cache

echo ">>> Деплой завершён!"
