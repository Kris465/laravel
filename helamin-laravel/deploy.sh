#!/bin/bash
# ============================================
# Helamin Laravel — скрипт деплоя
# Запускать из директории проекта на сервере:
#   cd /home/helamin/helamin.ru/temp-laravel
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

echo ">>> Публикация ассетов Filament и ссылки на storage..."
php artisan filament:assets
php artisan storage:link

echo ">>> Кеширование конфигурации..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ">>> Установка прав..."
chmod -R 775 storage bootstrap/cache

echo ">>> Деплой завершён!"
