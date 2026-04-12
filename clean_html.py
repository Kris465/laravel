import re
import os
from pathlib import Path

source_path = r"D:\repos\laravel\helamin-site\web.archive.org\web\20240426092330\http%3A\www.helamin.ru"
dest_path = r"D:\repos\laravel\helamin-laravel\resources\views\archive"

# Создаём папку назначения
os.makedirs(dest_path, exist_ok=True)

# Паттерны для замены
patterns = [
    # Удалить скрипты archive.org
    (r'<script[^>]*src="https://web-static\.archive\.org[^"]*"[^>]*></script>', ''),
    (r'<script[^>]*__wm\.init[^>]*</script>', ''),
    # Удалить CSS archive.org
    (r'<link[^>]*href="https://web-static\.archive\.org[^"]*"[^>]*>', ''),
    # Удалить комментарии
    (r'<!-- End Wayback Rewrite JS Include -->.*?<!-- End Wayback Rewrite JS Include -->', '', re.DOTALL),
    # Исправить пути к CSS (разные варианты)
    (r'/web/\d+cs_/https?://(?:www\.)?helamin\.ru/bitrix/', '/css/bitrix/'),
    (r'/web/\d+cs_/https?://helamin\.ru/bitrix/', '/css/bitrix/'),
    # Исправить пути к JS
    (r'/web/\d+js_/https?://(?:www\.)?helamin\.ru/bitrix/', '/js/bitrix/'),
    (r'/web/\d+js_/https?://helamin\.ru/bitrix/', '/js/bitrix/'),
    # Исправить пути к изображениям (разные варианты)
    (r'/web/\d+im_/https?://(?:www\.)?helamin\.ru/upload/', '/images/upload/'),
    (r'/web/\d+im_/https?://helamin\.ru/upload/', '/images/upload/'),
    (r'src="/upload/', 'src="/images/upload/'),
    # Исправить ссылки
    (r'href="/web/\d+/https?://(?:www\.)?helamin\.ru/', 'href="'),
    (r'href="/web/\d+/https?://helamin\.ru/', 'href="'),
]

# Обрабатываем все HTML файлы
for root, dirs, files in os.walk(source_path):
    for file in files:
        if file.endswith('.html'):
            src_file = os.path.join(root, file)
            rel_path = os.path.relpath(src_file, source_path)
            dst_file = os.path.join(dest_path, rel_path)
            
            # Создаём директорию
            os.makedirs(os.path.dirname(dst_file), exist_ok=True)
            
            # Читаем и обрабатываем (пробуем разные кодировки)
            content = None
            for encoding in ['windows-1251', 'utf-8', 'cp1251']:
                try:
                    with open(src_file, 'r', encoding=encoding) as f:
                        content = f.read()
                    break
                except UnicodeDecodeError:
                    continue
            
            if content is None:
                print(f"Ошибка чтения: {rel_path}")
                continue
            
            # Применяем паттерны
            for pattern in patterns:
                if len(pattern) == 3:
                    content = re.sub(pattern[0], pattern[1], content, flags=pattern[2])
                else:
                    content = re.sub(pattern[0], pattern[1], content)
            
            # Сохраняем
            with open(dst_file, 'w', encoding='utf-8') as f:
                f.write(content)
            
            print(f"Обработан: {rel_path}")

print(f"\nГотово! Файлы сохранены в {dest_path}")
