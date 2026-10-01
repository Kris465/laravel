<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
                                                [
                'slug' => '/',
                'title' => 'Главная',
                'content' => '<p>HELAMIN — инновационные ингибиторы коррозии и отложений для водно-паровых систем. Безопасная альтернатива гидразину, аммиаку и фосфатам.</p>',
                'meta_description' => 'HELAMIN - инновационные ингибиторы коррозии и отложений для водно-паровых систем.',
                'type' => 'home',
                'is_active' => true,
            ],
            [
                'slug' => 'o-produkte',
                'title' => 'О продукте',
                'content' => '<h1>О продукте HELAMIN<sup>&reg;</sup></h1><p>Ингибиторы коррозии и отложений для водно-паровых систем.</p>',
                'meta_description' => 'О продукте HELAMIN - ингибиторы коррозии и отложений.',
                'is_active' => true,
            ],
            [
                'slug' => 'o-produkte/opisanie',
                'title' => 'Описание',
                'content' => '<h1>Описание продукта</h1><p>HELAMIN - смесь поликарбоксилатов и поверхностно-активных алкилполиаминов.</p>',
                'meta_description' => 'Описание продукта HELAMIN - технология пленкообразования.',
                'is_active' => true,
            ],
            [
                'slug' => 'contacts',
                'title' => 'Контакты',
                'content' => '<h1>Контакты</h1><p>Телефон: +7 (495) 795-36-05</p><p>Email: info@helamin.ru</p>',
                'meta_description' => 'Контактные данные компании HELAMIN.',
                'is_active' => true,
            ],
            [
                'slug' => 'news',
                'title' => 'Новости',
                'content' => '<h1>Новости</h1><p>Последние новости компании.</p>',
                'meta_description' => 'Новости компании HELAMIN.',
                'is_active' => true,
            ],
            [
                'slug' => 'biblioteka',
                'title' => 'Библиотека',
                'content' => '<h1>Библиотека</h1><p>Документы и статьи по водоподготовке.</p>',
                'meta_description' => 'Библиотека технических документов HELAMIN.',
                'is_active' => true,
            ],
            [
                'slug' => 'referentsii',
                'title' => 'Референции',
                'content' => '<h1>Референции</h1><p>Объекты, где применяется HELAMIN.</p>',
                'meta_description' => 'Референции компании HELAMIN по применению ингибиторов коррозии.',
                'is_active' => true,
            ],
            [
                'slug' => 'oblast-primeneniya',
                'title' => 'Области применения',
                'content' => '<h1>Области применения</h1><p>Применение HELAMIN в различных отраслях.</p>',
                'meta_description' => 'Области применения ингибиторов коррозии HELAMIN.',
                'is_active' => true,
            ],
            [
                'slug' => 'otrasli-promyshlennosti',
                'title' => 'Отрасли промышленности',
                'content' => '<h1>Отрасли промышленности</h1><p>Применение HELAMIN в промышленности.</p>',
                'meta_description' => 'Отрасли промышленности с применением HELAMIN.',
                'is_active' => true,
            ],
            [
                'slug' => 'oprosnyy-list',
                'title' => 'Опросный лист',
                'content' => '<h1>Опросный лист</h1><p>Контактная форма для оценки воды.</p>',
                'meta_description' => 'Опросный лист для оценки параметров воды.',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::create(array_merge($page, [
                'type' => $page['type'] ?? 'simple',
            ]));
        }
    }
}
