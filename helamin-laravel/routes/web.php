<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Публичные страницы
|--------------------------------------------------------------------------
| Структура сайта задаётся здесь и в PageSeeder. Менеджеры редактируют
| только контент в админке, но не URL и не набор страниц.
*/

Route::get('/', [PageController::class, 'show'])->name('home');

Route::get('/o-produkte', [PageController::class, 'show'])->name('o-produkte');
Route::get('/o-produkte/opisanie', [PageController::class, 'show'])->name('o-produkte.opisanie');
Route::get('/o-produkte/normativnaya-dokumentatsiya', [PageController::class, 'show'])->name('o-produkte.normativnaya-dokumentatsiya');
Route::get('/o-produkte/nauchnye-stati', [PageController::class, 'show'])->name('o-produkte.nauchnye-stati');
Route::get('/o-produkte/praktika-primeneniya-otzyvy', [PageController::class, 'show'])->name('o-produkte.praktika-primeneniya-otzyvy');
Route::get('/o-produkte/voprosy-i-otvety', [PageController::class, 'show'])->name('o-produkte.voprosy-i-otvety');

Route::get('/oblast-primeneniya', [PageController::class, 'show'])->name('oblast-primeneniya');
Route::get('/oblast-primeneniya/kotly-nizkogo-i-srednego-davleniya', [PageController::class, 'show'])->name('oblast-primeneniya.kotly-nizkogo-i-srednego-davleniya');
Route::get('/oblast-primeneniya/kotly-vysokogo-i-sverkhvysokogo-davleniya', [PageController::class, 'show'])->name('oblast-primeneniya.kotly-vysokogo-i-sverkhvysokogo-davleniya');
Route::get('/oblast-primeneniya/kotly-utilizatory', [PageController::class, 'show'])->name('oblast-primeneniya.kotly-utilizatory');
Route::get('/oblast-primeneniya/pgu', [PageController::class, 'show'])->name('oblast-primeneniya.pgu');
Route::get('/oblast-primeneniya/predpuskovaya-otmyvka-i-konservatsiya', [PageController::class, 'show'])->name('oblast-primeneniya.predpuskovaya-otmyvka-i-konservatsiya');
Route::get('/oblast-primeneniya/sistemy-teplofikatsii', [PageController::class, 'show'])->name('oblast-primeneniya.sistemy-teplofikatsii');
Route::get('/oblast-primeneniya/sistemy-goryachego-vodosnabzheniya', [PageController::class, 'show'])->name('oblast-primeneniya.sistemy-goryachego-vodosnabzheniya');

Route::get('/news', [PageController::class, 'show'])->name('news');
Route::get('/biblioteka', [PageController::class, 'show'])->name('biblioteka');
Route::get('/oprosnyy-list', [PageController::class, 'show'])->name('oprosnyy-list');
Route::get('/contacts', [PageController::class, 'show'])->name('contacts');
