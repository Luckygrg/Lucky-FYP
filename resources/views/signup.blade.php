@extends('layouts.main')
@section('title', 'Sign Up - SpaLush')
@section('hyasabcontentauncha')

<div class="register-wrapper">
    <form class="register-card" action="{{ route('usersignup.create') }}" method="POST" novalidate>
        @csrf

        <h2>Create Account</h2>

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Please fix the following errors:</strong>
                <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label for="name">Full Name</label>
            <input 
                type="text" 
                id="name"
                name="name" 
                placeholder="Enter your full name" 
                value="{{ old('name') }}"
                required
            >
            @error('name')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="email">Email Address</label>
            <input 
                type="email" 
                id="email"
                name="email" 
                placeholder="Enter your email address" 
                value="{{ old('email') }}"
                required
            >
            @error('email')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input 
                type="password" 
                id="password"
                name="password" 
                placeholder="Enter a strong password (min. 6 characters)"
                required
            >
            @error('password')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input 
                type="password" 
                id="password_confirmation"
                name="password_confirmation" 
                placeholder="Re-enter your password"
                required
            >
        </div>

        <button type="submit">Create Account</button>

        <p class="login-link">
            Already have an account? <a href="{{ route('userlogin') }}">Login here</a>
        </p>
    </form>
</div>

@endsection