<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the homepage.
     */
    public function home()
    {
        return view('app'); // 'welcome' - це назва вашого головного blade-файлу
    }
}
