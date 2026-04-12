import os
import shutil
from pathlib import Path

# Источник и назначение
source_path = r"D:\repos\laravel\helamin-site\web.archive.org\web\20240426092330im_\http%3A\www.helamin.ru\upload"
dest_path = r"D:\repos\laravel\helamin-laravel\public\images\upload"

# Создаём папку назначения
os.makedirs(dest_path, exist_ok=True)

# Копируем все файлы
if os.path.exists(source_path):
    for root, dirs, files in os.walk(source_path):
        for file in files:
            src_file = os.path.join(root, file)
            rel_path = os.path.relpath(src_file, source_path)
            dst_file = os.path.join(dest_path, rel_path)
            
            # Создаём директорию
            os.makedirs(os.path.dirname(dst_file), exist_ok=True)
            
            # Копируем файл
            shutil.copy2(src_file, dst_file)
            print(f"Скопировано: {rel_path}")
    
    print(f"\nГотово! Изображения скопированы в {dest_path}")
else:
    print(f"Папка источника не найдена: {source_path}")

# Также копируем изображения из bitrix шаблонов
source_bitrix = r"D:\repos\laravel\helamin-site\web.archive.org\web\20240426092330im_\http%3A\www.helamin.ru\bitrix"
dest_bitrix = r"D:\repos\laravel\helamin-laravel\public\images\bitrix"

if os.path.exists(source_bitrix):
    os.makedirs(dest_bitrix, exist_ok=True)
    for root, dirs, files in os.walk(source_bitrix):
        for file in files:
            src_file = os.path.join(root, file)
            rel_path = os.path.relpath(src_file, source_bitrix)
            dst_file = os.path.join(dest_bitrix, rel_path)
            
            os.makedirs(os.path.dirname(dst_file), exist_ok=True)
            shutil.copy2(src_file, dst_file)
            print(f"Скопировано: {rel_path}")
    
    print(f"\nГотово! Изображения Bitrix скопированы в {dest_bitrix}")
else:
    print(f"Папка Bitrix не найдена: {source_bitrix}")
