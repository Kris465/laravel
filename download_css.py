import os
import requests
from pathlib import Path

# Базовый URL для CSS
base_url = "https://web.archive.org/web/20240426092330cs_/http://www.helamin.ru"

# CSS файлы для скачивания
css_files = [
    "/bitrix/cache/css/s1/furniture_blue/template_7cce992feac66328e2871908d46b3bd0/template_7cce992feac66328e2871908d46b3bd0.css?169702788921902",
    "/bitrix/templates/furniture_blue/common.css",
    "/bitrix/templates/furniture_blue/colors.css",
    "/bitrix/templates/furniture_blue/flexslider/flexslider.css",
]

# Папка назначения
dest_path = Path(r"D:\repos\laravel\helamin-laravel\public\css")

os.makedirs(dest_path, exist_ok=True)

for css_file in css_files:
    url = f"{base_url}{css_file}"
    
    # Создаём путь для сохранения
    file_name = css_file.split('/')[-1].split('?')[0]
    dir_parts = css_file.strip('/').split('/')[:-1]
    
    # Создаём директорию
    file_dir = dest_path
    for part in dir_parts:
        if '?' in part:
            break
        file_dir = file_dir / part
    os.makedirs(file_dir, exist_ok=True)
    
    # Полный путь к файлу
    full_path = file_dir / file_name
    
    try:
        # Скачиваем
        response = requests.get(url, timeout=30)
        if response.status_code == 200:
            with open(full_path, 'wb') as f:
                f.write(response.content)
            print(f"Скачано: {file_name}")
        else:
            print(f"Ошибка {response.status_code}: {url}")
    except Exception as e:
        print(f"Ошибка загрузки {url}: {e}")

print("\nГотово!")
