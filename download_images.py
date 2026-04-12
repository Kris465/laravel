import os
import requests
from pathlib import Path

# Базовый URL
base_url = "https://web.archive.org/web/20221007001201im_/http://www.helamin.ru"

# Изображения для скачивания
images = [
    "/bitrix/templates/furniture_blue/images/fon.png",
    "/bitrix/templates/furniture_blue/images/fon_hapka.png",
    "/bitrix/templates/furniture_blue/images/line.png",
    "/bitrix/templates/furniture_blue/images/tel.png",
    "/bitrix/templates/furniture_blue/images/mail.png",
    "/bitrix/templates/furniture_blue/images/loupe.gif",
    "/bitrix/templates/furniture_blue/images/water.png",
    "/bitrix/templates/furniture_blue/images/fon_menus.png",
    "/bitrix/templates/furniture_blue/images/fon_menu_hover.png",
    "/bitrix/templates/furniture_blue/images/fon_menu3.png",
    "/bitrix/templates/furniture_blue/images/fon_menu4.png",
    "/bitrix/templates/furniture_blue/images/line1.png",
    "/bitrix/templates/furniture_blue/images/line2.png",
]

# Папка назначения
dest_path = Path(r"D:\repos\laravel\helamin-laravel\public\images\bitrix\templates\furniture_blue\images")
os.makedirs(dest_path, exist_ok=True)

for img in images:
    url = f"{base_url}{img}"
    file_name = img.split('/')[-1]
    full_path = dest_path / file_name
    
    try:
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
