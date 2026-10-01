<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Request $request)
    {
        // Получаем slug из URL
        $path = $request->path();
        $slug = urldecode($path);
        
        $page = Page::where('slug', $slug)->where('is_active', true)->first();
        
        if (!$page) {
            abort(404);
        }
        
        // Выбор шаблона в зависимости от типа страницы
        $templates = [
            'home' => 'pages.home_dynamic',
            'simple' => 'pages.dynamic',
        ];
        
        $template = $templates[$page->type] ?? 'pages.dynamic';
        
        return view($template, [
            'page' => $page,
            'meta_description' => $page->meta_description,
        ]);
    }
}
