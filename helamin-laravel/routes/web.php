<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;

Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/o-produkte', [SiteController::class, 'oProdukte'])->name('o-produkte');
Route::get('/oblast-primeneniya', [SiteController::class, 'oblastPrimeneniya'])->name('oblast-primeneniya');
Route::get('/otrasli-promyshlennosti', [SiteController::class, 'otrasliPromyshlennosti'])->name('otrasli-promyshlennosti');
Route::get('/biblioteka', [SiteController::class, 'biblioteka'])->name('biblioteka');
Route::get('/news', [SiteController::class, 'news'])->name('news');
Route::get('/referentsii', [SiteController::class, 'referentsii'])->name('referentsii');
Route::get('/contacts', [SiteController::class, 'contacts'])->name('contacts');
Route::get('/oprosnyy-list', [SiteController::class, 'oprosnyyList'])->name('oprosnyy-list');

// Дополнительные страницы
Route::get('/o-produkte/opisanie', function() { return view('archive.o-produkte.opisanie.index'); });
Route::get('/o-produkte/normativnaya-dokumentatsiya', function() { return view('archive.o-produkte.normativnaya-dokumentatsiya.index'); });
Route::get('/o-produkte/nauchnye-stati', function() { return view('archive.o-produkte.nauchnye-stati.index'); });
Route::get('/o-produkte/praktika-primeneniya-otzyvy', function() { return view('archive.o-produkte.praktika-primeneniya-otzyvy.index'); });
Route::get('/o-produkte/voprosy-i-otvety', function() { return view('archive.o-produkte.voprosy-i-otvety.index'); });

Route::get('/biblioteka/normativnaya-dokumentatsiya', function() { return view('archive.biblioteka.normativnaya-dokumentatsiya.index'); });

// Области применения
Route::get('/oblast-primeneniya/kotly-vysokogo-i-sverkhvysokogo-davleniya', function() { return view('archive.oblast-primeneniya.kotly-vysokogo-i-sverkhvysokogo-davleniya.index'); });
Route::get('/oblast-primeneniya/kotly-nizkogo-i-srednego-davleniya', function() { return view('archive.oblast-primeneniya.kotly-nizkogo-i-srednego-davleniya.index'); });
Route::get('/oblast-primeneniya/kotly-utilizatory', function() { return view('archive.oblast-primeneniya.kotly-utilizatory.index'); });
Route::get('/oblast-primeneniya/pgu', function() { return view('archive.oblast-primeneniya.pgu.index'); });
Route::get('/oblast-primeneniya/predpuskovaya-otmyvka-i-konservatsiya', function() { return view('archive.oblast-primeneniya.predpuskovaya-otmyvka-i-konservatsiya.index'); });
Route::get('/oblast-primeneniya/sistemy-teplofikatsii', function() { return view('archive.oblast-primeneniya.sistemy-teplofikatsii.index'); });
Route::get('/oblast-primeneniya/sistemy-goryachego-vodosnabzheniya', function() { return view('archive.oblast-primeneniya.sistemy-goryachego-vodosnabzheniya.index'); });

// Отрасли
Route::get('/otrasli-promyshlennosti/teplo-i-elektroenergetika', function() { return view('archive.otrasli-promyshlennosti.teplo-i-elektroenergetika.index'); });
Route::get('/otrasli-promyshlennosti/neftepererabatyvayushchaya-promyshlennost', function() { return view('archive.otrasli-promyshlennosti.neftepererabatyvayushchaya-promyshlennost.index'); });
Route::get('/otrasli-promyshlennosti/neftekhimicheskaya-promyshlennost', function() { return view('archive.otrasli-promyshlennosti.neftekhimicheskaya-promyshlennost.index'); });
Route::get('/otrasli-promyshlennosti/azotnaya-promyshlennost-i-proizvodstvo-udobreniy', function() { return view('archive.otrasli-promyshlennosti.azotnaya-promyshlennost-i-proizvodstvo-udobreniy.index'); });
Route::get('/otrasli-promyshlennosti/chernaya-i-tsvetnaya-metallurgiya', function() { return view('archive.otrasli-promyshlennosti.chernaya-i-tsvetnaya-metallurgiya.index'); });
Route::get('/otrasli-promyshlennosti/tsellyulozno-bumazhnaya-promyshlennost', function() { return view('archive.otrasli-promyshlennosti.tsellyulozno-bumazhnaya-promyshlennost.index'); });
Route::get('/otrasli-promyshlennosti/pishchevaya-promyshlennost-zhkkh-munitsipalnye-obrazovaniya', function() { return view('archive.otrasli-promyshlennosti.pishchevaya-promyshlennost-zhkkh-munitsipalnye-obrazovaniya.index'); });
Route::get('/otrasli-promyshlennosti/zhkkh-munitsipalnye-obrazovaniya', function() { return view('archive.otrasli-promyshlennosti.zhkkh-munitsipalnye-obrazovaniya.index'); });
Route::get('/otrasli-promyshlennosti/drugie-vidy-promyshlennosti', function() { return view('archive.otrasli-promyshlennosti.drugie-vidy-promyshlennosti.index'); });
