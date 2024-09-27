<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class InicioController extends Controller
{
    public function inicio()
    {   
        return view('dashboard.index');
    }
}
