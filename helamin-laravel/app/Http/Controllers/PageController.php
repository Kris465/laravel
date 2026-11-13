<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Request $request): View
    {
        $page = Page::query()
            ->where('slug', $this->slugFromPath($request->path()))
            ->where('is_active', true)
            ->first();

        abort_unless($page, 404);

        return view(
            $page->type === 'home' ? 'pages.home_dynamic' : 'pages.dynamic',
            [
                'page' => $page,
                'meta_description' => $page->meta_description,
            ],
        );
    }

    private function slugFromPath(string $path): string
    {
        $slug = trim($path, '/');

        return $slug === '' ? '/' : $slug;
    }
}
