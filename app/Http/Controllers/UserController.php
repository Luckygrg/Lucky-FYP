<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Show the role selection page
     */
    public function showRoleSelection()
    {
        return view('role-selection');
    }

    /**
     * Show the login form
     */
    public function showlogin()
    {
        return view('login');
    }

    /**
     * Show the signup form
     */
    public function showsignup(Request $request)
    {
        $role = $request->query('role', 'customer');
        
        // Validate role
        if (!in_array($role, ['customer', 'spa_owner'])) {
            return redirect()->route('role.selection');
        }
        
        return view('signup', ['selectedRole' => $role]);
    }

    /**
     * Handle user registration
     * NOW REDIRECTS TO LOGIN PAGE INSTEAD OF AUTO-LOGIN
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:customer,spa_owner',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // CHANGED: Redirect to LOGIN page with success message
        // (User has to login manually)
        return redirect()->route('userlogin')->with('success', 'Account created successfully! Please login.');
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirect based on role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.admin')->with('success', 'Welcome Admin, ' . $user->name . '!');
                case 'spa_owner':
                    return redirect()->route('spa_owner.dashboard')->with('success', 'Welcome, ' . $user->name . '!');
                case 'customer':
                    return redirect()->route('customer.dashboard')->with('success', 'Welcome, ' . $user->name . '!');
                default:
                    return redirect('/')->with('success', 'Welcome back, ' . $user->name . '!');
            }
        }

        // Authentication failed
        return back()->with('error', 'Invalid email or password. Please try again.')->withInput($request->only('email'));
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}