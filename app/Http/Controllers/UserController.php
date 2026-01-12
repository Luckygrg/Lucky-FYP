<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function showsignup()
    {
        return view('signup');
    }

    public function showlogin()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        // dd($request); 
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('userlogin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('/');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // logout user

        // invalidate session
        $request->session()->invalidate();

        // regenerate CSRF token
        $request->session()->regenerateToken();

        return redirect('/userlogin');
    }
}
