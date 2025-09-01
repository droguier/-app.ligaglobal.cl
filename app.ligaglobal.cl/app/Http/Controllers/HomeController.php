<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $pageTitle = 'Home | Liga Global';
        return view('LigaGlobal::Home.index', compact('pageTitle'));
    }
}
