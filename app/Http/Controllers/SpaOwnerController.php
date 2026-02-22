<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaOwnerController extends Controller
{
    /**
     * Show spa owner dashboard
     */
    public function dashboard()
    {
        return view('spa_owner.dashboard');
    }
}
