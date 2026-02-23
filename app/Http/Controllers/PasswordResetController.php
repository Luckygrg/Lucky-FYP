<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * Show forgot password form
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset link
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if user exists
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->with('error', 'No account found with this email address.');
        }

        // Check if user has requested recently (within 40 seconds)
        $recentRequest = DB::table('password_reset_requests')
            ->where('email', $request->email)
            ->where('last_request_at', '>', Carbon::now()->subSeconds(40))
            ->first();

        if ($recentRequest) {
            $waitTime = 40 - Carbon::now()->diffInSeconds($recentRequest->last_request_at);
            return back()->with('error', "Please wait {$waitTime} seconds before requesting again.");
        }

        // Generate token
        $token = Str::random(64);
        $expiresAt = Carbon::now()->addSeconds(40);

        // Delete old tokens for this email
        DB::table('password_reset_requests')->where('email', $request->email)->delete();

        // Store new token
        DB::table('password_reset_requests')->insert([
            'email' => $request->email,
            'token' => $token,
            'expires_at' => $expiresAt,
            'last_request_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Send email
        $resetLink = url('/reset-password/' . $token);
        
        try {
            Mail::send('emails.reset-password', ['resetLink' => $resetLink, 'user' => $user], function($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Your Password - SpaLush');
            });

            return back()->with('success', 'Password reset link has been sent to your email. Link expires in 40 seconds.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email. Please try again later.');
        }
    }

    /**
     * Show reset password form
     */
    public function showResetForm($token)
    {
        // Check if token exists and is valid
        $resetRequest = DB::table('password_reset_requests')
            ->where('token', $token)
            ->first();

        if (!$resetRequest) {
            return redirect()->route('userlogin')->with('error', 'Invalid password reset link.');
        }

        // Check if token has expired
        if (Carbon::parse($resetRequest->expires_at)->isPast()) {
            DB::table('password_reset_requests')->where('token', $token)->delete();
            return redirect()->route('userlogin')->with('error', 'Password reset link has expired.');
        }

        return view('auth.reset-password', ['token' => $token, 'email' => $resetRequest->email]);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Check if token exists and is valid
        $resetRequest = DB::table('password_reset_requests')
            ->where('token', $request->token)
            ->where('email', $request->email)
            ->first();

        if (!$resetRequest) {
            return back()->with('error', 'Invalid password reset link.');
        }

        // Check if token has expired
        if (Carbon::parse($resetRequest->expires_at)->isPast()) {
            DB::table('password_reset_requests')->where('token', $request->token)->delete();
            return redirect()->route('userlogin')->with('error', 'Password reset link has expired.');
        }

        // Update user password
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the token
        DB::table('password_reset_requests')->where('token', $request->token)->delete();

        return redirect()->route('userlogin')->with('success', 'Password has been reset successfully! You can now login with your new password.');
    }
}
