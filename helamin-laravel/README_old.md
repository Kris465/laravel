# Helamin — Восстановление сайта

## Задача
Восстановить сайт компании Helamin после JS-инъекции. Сайт скачан из веб-архива.
Цель — не воссоздать дизайн точь-в-точь, а **сохранить информацию** и сделать:
- адаптивную верстку (mobile-first)
- современный, чистый интерфейс
- защиту от будущих инъекций (чистый код, без внешних скриптов)

## Стек
- **Backend:** Laravel 13 + PHP
- **Frontend:** Blade-шаблоны, чистый CSS (без фреймворков), минимум JS
- **Шрифт:** Roboto (Google Fonts)
- **Адаптивность:** mobile-first, чистый CSS Grid / Flexbox

## Структура страниц и URL

| # | Страница | URL | Статус |
|---|----------|-----|--------|
| 1 | **Главная** | `/` | ✅ Готова |
| 2 | **О продукте** | `/o-produkte` | ⬜ |
| 2.1 | — Описание | `/o-produkte/opisanie` | ⬜ |
| 2.2 | — Нормативная документация | `/o-produkte/normativnaya-dokumentatsiya` | ⬜ |
| 2.3 | — Научные статьи | `/o-produkte/nauchnye-stati` | ⬜ |
| 2.4 | — Практика применения / Отзывы | `/o-produkte/praktika-primeneniya-otzyvy` | ⬜ |
| 2.5 | — Вопросы и ответы | `/o-produkte/voprosy-i-otvety` | ⬜ |
| 3 | **Области применения** | `/oblast-primeneniya` | ⬜ |
| 3.1 | — Котлы низкого и среднего давления | `/oblast-primeneniya/kotly-nizkogo-i-srednego-davleniya` | ⬜ |
| 3.2 | — Котлы высокого и сверхвысокого давления | `/oblast-primeneniya/kotly-vysokogo-i-sverkhvysokogo-davleniya` | ⬜ |
| 3.3 | — Котлы-утилизаторы | `/oblast-primeneniya/kotly-utilizatory` | ⬜ |
| 3.4 | — ПГУ | `/oblast-primeneniya/pgu` | ⬜ |
| 3.5 | — Предпусковая отмывка и консервация | `/oblast-primeneniya/predpuskovaya-otmyvka-i-konservatsiya` | ⬜ |
| 3.6 | — Системы теплофикации | `/oblast-primeneniya/sistemy-teplofikatsii` | ⬜ |
| 3.7 | — Системы горячего водоснабжения | `/oblast-primeneniya/sistemy-goryachego-vodosnabzheniya` | ⬜ |
| 4 | **Отрасли промышленности** | `/otrasli-promyshlennosti` | ⬜ |
| 4.1 | — Азотная промышленность | `/otrasli-promyshlennosti/azotnaya-promyshlennost-i-proizvodstvo-udobreniy` | ⬜ |
| 4.2 | — Металлургия | `/otrasli-promyshlennosti/chernaya-i-tsvetnaya-metallurgiya` | ⬜ |
| 4.3 | — Нефтехимия | `/otrasli-promyshlennosti/neftekhimicheskaya-promyshlennost` | ⬜ |
| 4.4 | — Нефтепереработка | `/otrasli-promyshlennosti/neftepererabatyvayushchaya-promyshlennost` | ⬜ |
| 4.5 | — Пищевая промышленность / ЖКХ | `/otrasli-promyshlennosti/pishchevaya-promyshlennost-zhkkh-munitsipalnye-obrazovaniya` | ⬜ |
| 4.6 | — Тепло- и электроэнергетика | `/otrasli-promyshlennosti/teplo-i-elektroenergetika` | ⬜ |
| 4.7 | — Целлюлозно-бумажная | `/otrasli-promyshlennosti/tsellyulozno-bumazhnaya-promyshlennost` | ⬜ |
| 4.8 | — Другие виды | `/otrasli-promyshlennosti/drugie-vidy-promyshlennosti` | ⬜ |
| 5 | **Новости** | `/news` | ⬜ |
| 6 | **Библиотека** | `/biblioteka` | ⬜ |
| 7 | **Опросный лист** | `/oprosnyy-list` | ⬜ |
| 8 | **Референции** | `/referentsii` | ⬜ |
| 9 | **Контакты** | `/contacts` | ⬜ |

## Структура файлов

```
helamin-laravel/
├── public/
│   ├── css/app.css           # Основные стили (все стили сайта)
│   ├── js/app.js             # Минимум JS (бургер-меню)
│   └── images/               # Картинки: логотипы, фото, иконки
│       ├── package-main.png
│       └── package-close.png
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php     # Основной layout (nav + footer)
│   └── pages/
│       ├── home.blade.php                # Главная ✅
│       ├── o-produkte.blade.php          # О продукте
│       ├── o-produkte/
│       │   ├── opisanie.blade.php
│       │   ├── normativnaya-dokumentatsiya.blade.php
│       │   ├── nauchnye-stati.blade.php
│       │   ├── praktika-primeneniya-otzyvy.blade.php
│       │   └── voprosy-i-otvety.blade.php
│       ├── oblast-primeneniya.blade.php
│       ├── oblast-primeneniya/            # подстраницы...
│       ├── otrasli-promyshlennosti.blade.php
│       ├── otrasli-promyshlennosti/      # подстраницы...
│       ├── news.blade.php
│       ├── biblioteka.blade.php
│       ├── referentsii.blade.php
│       └── contacts.blade.php
├── routes/
│   └── web.php               # Все маршруты (именованные)
└── README.md                 # Этот файл
```

## Дизайн-принципы
- **Минимум зависимостей** — никаких jQuery, Bootstrap, внешних JS
- **Безопасность** — весь вывод через `{{ }}` (экранирование), CSP-заголовки
- **Скорость** — минимум запросов, ленивая загрузка изображений
- **Доступность** — семантический HTML, aria-labels, контрастность

## Цветовая палитра
| Переменная | Значение | Назначение |
|------------|----------|------------|
| `--c-primary` | `#0055a4` | Основной синий (nav, акценты) |
| `--c-primary-dark` | `#003d75` | Тёмно-синий (hero фон) |
| `--c-primary-light` | `#e6f0fa` | Светло-синий (sidebar, hover) |
| `--c-accent` | `#e87722` | Оранжевый (CTA кнопки) |
| `--c-text` | `#1a1a2e` | Основной текст |
| `--c-text-muted` | `#5a5a72` | Приглушённый текст |

## Как создать новую страницу

1. Создай blade-файл в `resources/views/pages/` (или подпапке)
2. Добавь маршрут в `routes/web.php` с `->name('...')`
3. Шаблон страницы:
```blade
@extends('layouts.app')

@section('title', 'Заголовок страницы')

@section('content')
  <section class="main-content">
      <div class="container">
          <h1>Заголовок</h1>
          <p>Контент...</p>
      </div>
  </section>
@endsection
```

## Куда класть файлы

| Тип файла | Путь |
|-----------|------|
| **Картинки** | `public/images/` |
| **CSS** | `public/css/app.css` (один файл на весь сайт) |
| **JS** | `public/js/app.js` |
| **Blade-шаблоны** | `resources/views/pages/` |
| **Стили страниц** | Дописывать в конец `public/css/app.css` |

## План работ

### Этап 1 — Главная страница ✅
- [x] Базовый layout с навигацией и footer
- [x] Hero-блок с 3-колоночной сеткой
- [x] Контентная область с сайдбаром
- [x] Адаптивная навигация (sticky)
- [x] Цветовая палитра и типографика

### Этап 2 — Контентные страницы
- [ ] О  produkte + подстраницы (5 страниц)
- [ ] Области применения + подстраницы (7 страниц)
- [ ] Отрасли промышленности + подстраницы (8 страниц)

### Этап 3 — Остальные страницы
- [ ] Новости
- [ ] Библиотека
- [ ] Опросный лист
- [ ] Референции
- [ ] Контакты

### Этап 4 — Финализация
- [ ] Перенести контент из оригинального сайта
- [ ] Проверка адаптивности на всех страницах
- [ ] Базовая SEO-разметка (title, meta description)
- [ ] Защита: CSP-заголовки, экранирование вывода
