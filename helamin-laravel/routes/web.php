<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Главная
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('pages.home');
})->name('home');


/*
|--------------------------------------------------------------------------
| О продукте
|--------------------------------------------------------------------------
*/
Route::get('/o-produkte', function () {
    return view('pages.o-produkte');
})->name('o-produkte');

Route::get('/o-produkte/opisanie', function () {
    return view('pages.o-produkte.opisanie');
})->name('o-produkte.opisanie');

Route::get('/o-produkte/normativnaya-dokumentatsiya', function () {
    return view('pages.o-produkte.normativnaya-dokumentatsiya');
})->name('o-produkte.normativnaya-dokumentatsiya');

Route::get('/o-produkte/nauchnye-stati', function () {
    return view('pages.o-produkte.nauchnye-stati');
})->name('o-produkte.nauchnye-stati');

Route::get('/o-produkte/praktika-primeneniya-otzyvy', function () {
    return view('pages.o-produkte.praktika-primeneniya-otzyvy');
})->name('o-produkte.praktika-primeneniya-otzyvy');

Route::get('/o-produkte/voprosy-i-otvety', function () {
    return view('pages.o-produkte.voprosy-i-otvety');
})->name('o-produkte.voprosy-i-otvety');


/*
|--------------------------------------------------------------------------
| Области применения
|--------------------------------------------------------------------------
*/
Route::get('/oblast-primeneniya', function () {
    return view('pages.oblast-primeneniya');
})->name('oblast-primeneniya');

Route::get('/oblast-primeneniya/kotly-nizkogo-i-srednego-davleniya', function () {
    return view('pages.oblast-primeneniya.kotly-nizkogo-i-srednego-davleniya');
})->name('oblast-primeneniya.kotly-nizkogo-i-srednego-davleniya');

Route::get('/oblast-primeneniya/kotly-vysokogo-i-sverkhvysokogo-davleniya', function () {
    return view('pages.oblast-primeneniya.kotly-vysokogo-i-sverkhvysokogo-davleniya');
})->name('oblast-primeneniya.kotly-vysokogo-i-sverkhvysokogo-davleniya');

Route::get('/oblast-primeneniya/kotly-utilizatory', function () {
    return view('pages.oblast-primeneniya.kotly-utilizatory');
})->name('oblast-primeneniya.kotly-utilizatory');

Route::get('/oblast-primeneniya/pgu', function () {
    return view('pages.oblast-primeneniya.pgu');
})->name('oblast-primeneniya.pgu');

Route::get('/oblast-primeneniya/predpuskovaya-otmyvka-i-konservatsiya', function () {
    return view('pages.oblast-primeneniya.predpuskovaya-otmyvka-i-konservatsiya');
})->name('oblast-primeneniya.predpuskovaya-otmyvka-i-konservatsiya');

Route::get('/oblast-primeneniya/sistemy-teplofikatsii', function () {
    return view('pages.oblast-primeneniya.sistemy-teplofikatsii');
})->name('oblast-primeneniya.sistemy-teplofikatsii');

Route::get('/oblast-primeneniya/sistemy-goryachego-vodosnabzheniya', function () {
    return view('pages.oblast-primeneniya.sistemy-goryachego-vodosnabzheniya');
})->name('oblast-primeneniya.sistemy-goryachego-vodosnabzheniya');


/*
|--------------------------------------------------------------------------
| Отрасли промышленности
|--------------------------------------------------------------------------
*/
Route::get('/otrasli-promyshlennosti', function () {
    return view('pages.otrasli-promyshlennosti');
})->name('otrasli-promyshlennosti');

Route::get('/otrasli-promyshlennosti/azotnaya-promyshlennost-i-proizvodstvo-udobreniy', function () {
    return view('pages.otrasli-promyshlennosti.azotnaya-promyshlennost-i-proizvodstvo-udobreniy');
})->name('otrasli-promyshlennosti.azotnaya-promyshlennost-i-proizvodstvo-udobreniy');

Route::get('/otrasli-promyshlennost/chernaya-i-tsvetnaya-metallurgiya', function () {
    return view('pages.otrasli-promyshlennosti.chernaya-i-tsvetnaya-metallurgiya');
})->name('otrasli-promyshlennosti.chernaya-i-tsvetnaya-metallurgiya');

Route::get('/otrasli-promyshlennosti/neftekhimicheskaya-promyshlennost', function () {
    return view('pages.otrasli-promyshlennosti.neftekhimicheskaya-promyshlennost');
})->name('otrasli-promyshlennosti.neftekhimicheskaya-promyshlennost');

Route::get('/otrasli-promyshlennosti/neftepererabatyvayushchaya-promyshlennost', function () {
    return view('pages.otrasli-promyshlennosti.neftepererabatyvayushchaya-promyshlennost');
})->name('otrasli-promyshlennosti.neftepererabatyvayushchaya-promyshlennost');

Route::get('/otrasli-promyshlennosti/pishchevaya-promyshlennost-zhkkh-munitsipalnye-obrazovaniya', function () {
    return view('pages.otrasli-promyshlennosti.pishchevaya-promyshlennost-zhkkh-munitsipalnye-obrazovaniya');
})->name('otrasli-promyshlennosti.pishchevaya-promyshlennost-zhkkh-munitsipalnye-obrazovaniya');

Route::get('/otrasli-promyshlennosti/teplo-i-elektroenergetika', function () {
    return view('pages.otrasli-promyshlennosti.teplo-i-elektroenergetika');
})->name('otrasli-promyshlennosti.teplo-i-elektroenergetika');

Route::get('/otrasli-promyshlennosti/tsellyulozno-bumazhnaya-promyshlennost', function () {
    return view('pages.otrasli-promyshlennosti.tsellyulozno-bumazhnaya-promyshlennost');
})->name('otrasli-promyshlennosti.tsellyulozno-bumazhnaya-promyshlennost');

Route::get('/otrasli-promyshlennosti/drugie-vidy-promyshlennosti', function () {
    return view('pages.otrasli-promyshlennosti.drugie-vidy-promyshlennosti');
})->name('otrasli-promyshlennosti.drugie-vidy-promyshlennosti');


/*
|--------------------------------------------------------------------------
| Новости
|--------------------------------------------------------------------------
*/
Route::get('/news', function () {
    return view('pages.news');
})->name('news');


/*
|--------------------------------------------------------------------------
| Библиотека
|--------------------------------------------------------------------------
*/
Route::get('/biblioteka', function () {
    return view('pages.biblioteka');
})->name('biblioteka');


/*
|--------------------------------------------------------------------------
| Референции
|--------------------------------------------------------------------------
*/
Route::get('/referentsii', function () {
    return view('pages.referentsii');
})->name('referentsii');


/*
|--------------------------------------------------------------------------
| Контакты
|--------------------------------------------------------------------------
*/
Route::get('/contacts', function () {
    return view('pages.contacts');
})->name('contacts');
