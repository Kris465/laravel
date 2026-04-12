# Скрипт для очистки HTML от web.archive.org и конвертации в Blade шаблоны

$sourcePath = "D:\repos\laravel\helamin-site\web.archive.org\web\20240426092330\http%3A\www.helamin.ru"
$destPath = "D:\repos\laravel\helamin-laravel\resources\views\archive"

# Создаём папку назначения
New-Item -ItemType Directory -Path $destPath -Force | Out-Null

# Получаем все HTML файлы
$htmlFiles = Get-ChildItem -Path $sourcePath -Recurse -Filter "*.html"

foreach ($file in $htmlFiles) {
    # Читаем содержимое
    $content = Get-Content $file.FullName -Raw -Encoding UTF8
    
    # Удаляем скрипты web.archive.org
    $content = $content -replace '(?s)<script[^>]*src=["\']https://web-static\.archive\.org[^>]*</script>', ''
    $content = $content -replace '(?s)<link[^>]*href=["\']https://web-static\.archive\.org[^>]*>', ''
    $content = $content -replace '(?s)<script[^>]*__wm\.init[^>]*</script>', ''
    
    # Удаляем meta теги archive.org
    $content = $content -replace '(?s)<!-- End Wayback Rewrite JS Include -->.*?<!-- End Wayback Rewrite JS Include -->', ''
    
    # Исправляем пути к CSS
    $content = $content -replace '/web/\d+cs_/http://www\.helamin\.ru/bitrix/', '/css/'
    $content = $content -replace '/web/\d+js_/http://www\.helamin\.ru/bitrix/', '/js/'
    $content = $content -replace '/web/\d+im_/http://www\.helamin\.ru/upload/', '/images/upload/'
    
    # Исправляем ссылки (убираем archive.org префиксы)
    $content = $content -replace 'href="/web/\d+/http://www\.helamin\.ru/', 'href="'
    $content = $content -replace 'href="/web/\d+/https://helamin\.ru/', 'href="'
    
    # Сохраняем очищенный HTML
    $relativePath = $file.FullName.Replace($sourcePath, '').TrimStart('\')
    $newPath = Join-Path $destPath $relativePath
    
    # Создаём директорию если нужно
    $dir = Split-Path $newPath -Parent
    if (!(Test-Path $dir)) {
        New-Item -ItemType Directory -Path $dir -Force | Out-Null
    }
    
    # Сохраняем файл
    $content | Out-File -FilePath $newPath -Encoding UTF8
    Write-Host "Обработан: $relativePath"
}

Write-Host "Готово! Файлы сохранены в $destPath"
