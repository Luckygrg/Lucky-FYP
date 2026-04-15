<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function showRoleSelection()
    {
        return view('role-selection');
    }

    public function showlogin()
    {
        return view('login');
    }

    public function showsignup(Request $request)
    {
        $role = $request->query('role', 'customer');
        if (!in_array($role, ['customer', 'spa_owner'])) {
            return redirect()->route('role.selection');
        }
        return view('signup', ['selectedRole' => $role]);
    }

    /**
     * Handle registration: store in session, send verification email
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/@gmail\.com$/i'],
            'password' => ['required', 'string', 'confirmed', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'regex:/[^A-Za-z0-9]/'],
            'role'     => 'required|in:customer,spa_owner',
        ], [
            'email.regex'       => 'Only Gmail addresses are allowed (must end with @gmail.com).',
            'password.min'      => 'Password must be at least 8 characters with uppercase, lowercase, number and special character.',
            'password.regex'    => 'Password must be at least 8 characters with uppercase, lowercase, number and special character.',
            'password.confirmed'=> 'Passwords do not match.',
        ]);

        // Generate a unique token
        $token = Str::random(64);

        // Store registration data + token + timestamp in session
        $request->session()->put('pending_registration', [
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'token'      => $token,
            'created_at' => now()->timestamp,
        ]);

        // Send verification email
        $verifyLink = route('verify.email', ['token' => $token]);
        Mail::send('emails.verify-email', [
            'name'       => $request->name,
            'verifyLink' => $verifyLink,
        ], function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Verify Your SpaLush Account');
        });

        return redirect()->route('verify.notice');
    }

    /**
     * Show "check your email" notice page
     */
    public function showVerifyNotice()
    {
        if (!session('pending_registration')) {
            return redirect()->route('role.selection');
        }
        return view('auth.verify-notice');
    }

    /**
     * Handle email verification link click
     */
    public function verifyEmail(Request $request, $token)
    {
        $pending = session('pending_registration');

        if (!$pending) {
            return redirect()->route('usersignup')->with('error', 'Session expired. Please register again.');
        }

        // Check token match
        if ($pending['token'] !== $token) {
            return redirect()->route('usersignup')->with('error', 'Invalid verification link. Please register again.');
        }

        // Check 3-minute expiry
        if (now()->timestamp - $pending['created_at'] > 180) {
            $request->session()->forget('pending_registration');
            return redirect()->route('usersignup', ['role' => $pending['role']])
                ->with('error', 'Verification link expired (3 minutes). Please register again.');
        }

        // Create the user
        User::create([
            'name'     => $pending['name'],
            'email'    => $pending['email'],
            'password' => $pending['password'],
            'role'     => $pending['role'],
        ]);

        // Clear session
        $request->session()->forget('pending_registration');

        return redirect()->route('userlogin')
            ->with('success', 'Email verified! Your account is ready. Please login.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.admin')->with('success', 'Welcome Admin, ' . $user->name . '!');
                case 'spa_owner':
                    return redirect()->route('spa_owner.dashboard')->with('success', 'Welcome, ' . $user->name . '!');
                case 'customer':
                    return redirect('/')->with('success', 'Welcome, ' . $user->name . '!');
                default:
                    return redirect('/')->with('success', 'Welcome back, ' . $user->name . '!');
            }
        }

        return back()->with('error', 'Invalid email or password.')->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}