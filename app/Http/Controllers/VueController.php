<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VueController extends Controller
{
    public function index()
    {
        return view('vue',[
            'auth_user' => Auth::user()
        ]);
    }
}
