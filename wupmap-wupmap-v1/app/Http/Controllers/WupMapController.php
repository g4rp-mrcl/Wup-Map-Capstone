<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WupMapController extends Controller
{
    public function index()
    {
        return view('wup-map');
    }
}
