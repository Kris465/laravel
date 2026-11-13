<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Структура и стартовый контент сайта. Повторный запуск безопасен.
     * Менеджеры правят контент в /admin, но не меняют slug, type и набор страниц.
     */
    public function run(): void
    {
        foreach ($this->pages() as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                $page + ['is_active' => true],
            );
        }

        // Разделы, удалённые по просьбе клиента, не должны остаться активными в старой БД.
        Page::query()
            ->where(
                fn ($query) => $query
                    ->where('slug', 'like', 'otrasli-promyshlennosti%')
                    ->orWhere('slug', 'referentsii')
            )
            ->update(['is_active' => false]);
    }

    /** @return array<int, array<string, string>> */
    private function pages(): array
    {
        return [
            [
                'slug' => '/',
                'title' => 'Главная',
                'type' => 'home',
                'meta_description' => 'HELAMIN — ингибиторы коррозии и отложений для водно-паровых систем.',
                'content' => "**HELAMIN®** — инновационные ингибиторы коррозии и отложений для водно-паровых систем. Разработаны Helamin Technology Holding SA (Швейцария).\n\nБезопасная альтернатива гидразину, аммиаку и фосфатам. Применяются в контурах воды и пара, теплофикационных сетях и системах горячего водоснабжения.",
            ],
            [
                'slug' => 'o-produkte',
                'title' => 'О продукте',
                'type' => 'simple',
                'meta_description' => 'О продукте HELAMIN — ингибиторы коррозии и отложений.',
                'content' => "# О продукте HELAMIN®\n\n**HELAMIN®** — инновационный ингибитор коррозии и отложений для водно-паровых систем. Разработан компанией Helamin Technology Holding SA (Швейцария).\n\nПродукт обеспечивает эффективную защиту от коррозии и отложений в контурах воды и пара, теплофикационных сетях, системах горячего водоснабжения. Является альтернативой традиционному кондиционированию гидразином, аммиаком и фосфатами.\n\nПодробнее: [Описание](/o-produkte/opisanie), [Нормативная документация](/o-produkte/normativnaya-dokumentatsiya), [Научные статьи](/o-produkte/nauchnye-stati), [Практика применения](/o-produkte/praktika-primeneniya-otzyvy), [Вопросы и ответы](/o-produkte/voprosy-i-otvety).",
            ],
            [
                'slug' => 'o-produkte/opisanie',
                'title' => 'Описание',
                'type' => 'simple',
                'meta_description' => 'Описание продукта HELAMIN — технология плёнкообразования.',
                'content' => "# Описание продукта\n\n**HELAMIN®** представляет собой смесь поликарбоксилатов и поверхностно-активных насыщенных алкилполиаминов в сочетании с другими аминами различной степени летучести.\n\n- Эффективная защита от коррозии и отложений в контурах воды и пара\n- Широкое применение для предпусковой отмывки и консервации\n- Альтернатива традиционному кондиционированию гидразином, аммиаком и фосфатами\n- Без гидразина, без фосфатов\n- 3-й класс опасности (малотоксичный)\n\n*Подробная информация появится в ближайшее время.* По вопросам обращайтесь в [контактный отдел](/contacts).",
            ],
            [
                'slug' => 'o-produkte/normativnaya-dokumentatsiya',
                'title' => 'Нормативная документация',
                'type' => 'simple',
                'meta_description' => 'Нормативная документация на продукцию HELAMIN.',
                'content' => "# Нормативная документация\n\nВ данном разделе представлена нормативная документация на продукцию HELAMIN®.\n\n- Паспорт безопасности (MSDS)\n- Технические условия\n- Сертификаты соответствия\n- Разрешения и допуски\n\n*Документы будут доступны для скачивания в ближайшее время.* Для получения документации обращайтесь в [контактный отдел](/contacts).",
            ],
            [
                'slug' => 'o-produkte/nauchnye-stati',
                'title' => 'Научные статьи',
                'type' => 'simple',
                'meta_description' => 'Научные публикации и исследования по применению HELAMIN.',
                'content' => "# Научные статьи\n\nВ данном разделе представлены научные публикации и исследования, посвящённые применению HELAMIN®.\n\n*Раздел находится в разработке. Скоро здесь будут доступны публикации.* По вопросам обращайтесь в [контактный отдел](/contacts).",
            ],
            [
                'slug' => 'o-produkte/praktika-primeneniya-otzyvy',
                'title' => 'Практика применения / Отзывы',
                'type' => 'simple',
                'meta_description' => 'Практика применения и отзывы о HELAMIN.',
                'content' => "# Практика применения / Отзывы\n\nHELAMIN® успешно применяется на объектах энергетики, промышленности и ЖКХ по всей России и странам СНГ.\n\n*Раздел находится в разработке. Скоро здесь будут опубликованы кейсы и отзывы.* По вопросам обращайтесь в [контактный отдел](/contacts).",
            ],
            [
                'slug' => 'o-produkte/voprosy-i-otvety',
                'title' => 'Вопросы и ответы',
                'type' => 'simple',
                'meta_description' => 'Вопросы и ответы о применении HELAMIN.',
                'content' => "# Вопросы и ответы\n\nСтраница в разработке. По вопросам обращайтесь в [контактный отдел](/contacts).",
            ],
            [
                'slug' => 'oblast-primeneniya',
                'title' => 'Области применения',
                'type' => 'simple',
                'meta_description' => 'Области применения ингибиторов коррозии HELAMIN.',
                'content' => "# Области применения\n\nHELAMIN® применяется в котлах, парогазовых установках, системах теплофикации и горячего водоснабжения, а также для предпусковой отмывки и консервации.\n\n- [Котлы низкого и среднего давления](/oblast-primeneniya/kotly-nizkogo-i-srednego-davleniya)\n- [Котлы высокого и сверхвысокого давления](/oblast-primeneniya/kotly-vysokogo-i-sverkhvysokogo-davleniya)\n- [Котлы-утилизаторы](/oblast-primeneniya/kotly-utilizatory)\n- [ПГУ](/oblast-primeneniya/pgu)\n- [Предпусковая отмывка и консервация](/oblast-primeneniya/predpuskovaya-otmyvka-i-konservatsiya)\n- [Системы теплофикации](/oblast-primeneniya/sistemy-teplofikatsii)\n- [Системы горячего водоснабжения](/oblast-primeneniya/sistemy-goryachego-vodosnabzheniya)",
            ],
            [
                'slug' => 'oblast-primeneniya/kotly-nizkogo-i-srednego-davleniya',
                'title' => 'Котлы низкого и среднего давления',
                'type' => 'simple',
                'meta_description' => 'Применение HELAMIN в котлах низкого и среднего давления.',
                'content' => "# Котлы низкого и среднего давления\n\nСтраница в разработке. По вопросам обращайтесь в [контактный отдел](/contacts).",
            ],
            [
                'slug' => 'oblast-primeneniya/kotly-vysokogo-i-sverkhvysokogo-davleniya',
                'title' => 'Котлы высокого и сверхвысокого давления',
                'type' => 'simple',
                'meta_description' => 'Применение HELAMIN в котлах высокого давления.',
                'content' => "# Котлы высокого и сверхвысокого давления\n\nСтраница в разработке. По вопросам обращайтесь в [контактный отдел](/contacts).",
            ],
            [
                'slug' => 'oblast-primeneniya/kotly-utilizatory',
                'title' => 'Котлы-утилизаторы',
                'type' => 'simple',
                'meta_description' => 'Применение HELAMIN в котлах-утилизаторах.',
                'content' => "# Котлы-утилизаторы\n\nСтраница в разработке. По вопросам обращайтесь в [контактный отдел](/contacts).",
            ],
            [
                'slug' => 'oblast-primeneniya/pgu',
                'title' => 'ПГУ',
                'type' => 'simple',
                'meta_description' => 'Применение HELAMIN в парогазовых установках.',
                'content' => "# ПГУ (парогазовые установки)\n\nСтраница в разработке. По вопросам обращайтесь в [контактный отдел](/contacts).",
            ],
            [
                'slug' => 'oblast-primeneniya/predpuskovaya-otmyvka-i-konservatsiya',
                'title' => 'Предпусковая отмывка и консервация',
                'type' => 'simple',
                'meta_description' => 'Предпусковая отмывка и консервация с HELAMIN.',
                'content' => "# Предпусковая отмывка и консервация\n\nСтраница в разработке. По вопросам обращайтесь в [контактный отдел](/contacts).",
            ],
            [
                'slug' => 'oblast-primeneniya/sistemy-teplofikatsii',
                'title' => 'Системы теплофикации',
                'type' => 'simple',
                'meta_description' => 'Применение HELAMIN в системах теплофикации.',
                'content' => "# Системы теплофикации\n\nСтраница в разработке. По вопросам обращайтесь в [контактный отдел](/contacts).",
            ],
            [
                'slug' => 'oblast-primeneniya/sistemy-goryachego-vodosnabzheniya',
                'title' => 'Системы горячего водоснабжения',
                'type' => 'simple',
                'meta_description' => 'Применение HELAMIN в системах ГВС.',
                'content' => "# Системы горячего водоснабжения\n\nСтраница в разработке. По вопросам обращайтесь в [контактный отдел](/contacts).",
            ],
            [
                'slug' => 'news',
                'title' => 'Новости',
                'type' => 'simple',
                'meta_description' => 'Новости компании HELAMIN.',
                'content' => "# Новости\n\nВ данном разделе представлены новости компании и информация о последних событиях.\n\n*Раздел находится в разработке. Скоро здесь появятся актуальные новости.* По вопросам сотрудничества обращайтесь в [контактный отдел](/contacts).",
            ],
            [
                'slug' => 'biblioteka',
                'title' => 'Библиотека',
                'type' => 'simple',
                'meta_description' => 'Библиотека технических документов HELAMIN.',
                'content' => "# Библиотека\n\nВ данном разделе представлены материалы о продукте HELAMIN®: научные статьи, нормативная документация, описания и практические рекомендации.\n\n*Раздел находится в разработке. Скоро здесь будут доступны материалы для скачивания.* По вопросам получения документации обращайтесь в [контактный отдел](/contacts).",
            ],
            [
                'slug' => 'oprosnyy-list',
                'title' => 'Опросный лист',
                'type' => 'simple',
                'meta_description' => 'Опросный лист для оценки параметров воды.',
                'content' => "# Опросный лист\n\nКонтактная форма для оценки воды. Страница в разработке — отправьте параметры воды на [info@helamin.ru](mailto:info@helamin.ru).",
            ],
            [
                'slug' => 'contacts',
                'title' => 'Контакты',
                'type' => 'simple',
                'meta_description' => 'Контактные данные компании HELAMIN.',
                'content' => "# Контакты\n\n**Разработчик и единственный патентодержатель марки Хеламин:** Helamin Technology Holding SA, Швейцария ([www.helamin.com](https://www.helamin.com/))\n\n**Производитель реагентов Хеламин:** Helamin France SaRL, Франция\n\n**Исключительный импортёр в страны таможенного союза:** ООО «Хеламин Проект», Россия ([www.helamin.ru](https://helamin.ru/))\n\nОГРН 1087746447249 · Серия 77 № 010261917 от 01.04.2008 · Выдано Межрайонной инспекцией ФНС № 46 по г. Москве · ИНН / КПП: 7719675703 / 771801001 · Адрес: 107023, г. Москва, Семёновский переулок, д. 15\n\n**Телефон:** [+7 (495) 795-36-05](tel:+74957953605) / [06](tel:+74957953606) / [07](tel:+74957953607)\n\n**Эл. почта:** [info@helamin.ru](mailto:info@helamin.ru)",
            ],
        ];
    }
}
