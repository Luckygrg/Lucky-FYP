<?php

namespace App\Http\Controllers;

use App\Models\Spa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpaOwnerController extends Controller
{
    /**
     * Show spa owner dashboard
     */
    public function dashboard()
    {
        $spa = Spa::where('user_id', Auth::id())->first();

        return view('spa_owner.dashboard', compact('spa'));
    }
}
