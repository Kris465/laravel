<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return view('archive.index');
    }

    public function oProdukte()
    {
        return view('archive.o-produkte.index');
    }

    public function oblastPrimeneniya()
    {
        return view('archive.oblast-primeneniya.index');
    }

    public function otrasliPromyshlennosti()
    {
        return view('archive.otrasli-promyshlennosti.index');
    }

    public function biblioteka()
    {
        return view('archive.biblioteka.index');
    }

    public function news()
    {
        return view('archive.news.index');
    }

    public function referentsii()
    {
        return view('archive.referentsii.index');
    }

    public function contacts()
    {
        return view('archive.contacts.index');
    }

    public function oprosnyyList()
    {
        return view('archive.oprosnyy-list.index');
    }
}
