<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Главная страница
|--------------------------------------------------------------------------
*/
// Главная страница
Route::get('/', [PageController::class, 'show'])->name('home');


/*
|--------------------------------------------------------------------------
| Динамический роутинг для всех страниц
|--------------------------------------------------------------------------
*/
// Страницы с одной дирекцией
Route::get('/o-produkte', [PageController::class, 'show'])->name('o-produkte');
Route::get('/o-produkte/{slug}', [PageController::class, 'show'])->name('o-produkte.slug');
Route::get('/oblast-primeneniya', [PageController::class, 'show'])->name('oblast-primeneniya');
Route::get('/oblast-primeneniya/{slug}', [PageController::class, 'show'])->name('oblast-primeneniya.slug');
Route::get('/otrasli-promyshlennosti', [PageController::class, 'show'])->name('otrasli-promyshlennosti');
Route::get('/otrasli-promyshlennosti/{slug}', [PageController::class, 'show'])->name('otrasli-promyshlennosti.slug');

// Остальные страницы
Route::get('/news', [PageController::class, 'show'])->name('news');
Route::get('/biblioteka', [PageController::class, 'show'])->name('biblioteka');
Route::get('/referentsii', [PageController::class, 'show'])->name('referentsii');
Route::get('/oprosnyy-list', [PageController::class, 'show'])->name('oprosnyy-list');
Route::get('/contacts', [PageController::class, 'show'])->name('contacts');
