@extends('layouts.main')
@section('title', 'Login - SpaLush')
@section('hyasabcontentauncha')

<div class="register-wrapper">
    <form class="register-card" action="{{ route('loginuser') }}" method="POST" novalidate>
        @csrf

        <h2>Welcome Back</h2>

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Login failed:</strong>
                <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label for="email">Email Address</label>
            <input 
                type="email" 
                id="email"
                name="email" 
                placeholder="Enter your email address"
                value="{{ old('email') }}"
                required
                autofocus
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
                placeholder="Enter your password"
                required
            >
            @error('password')
                <small class="error-text">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit">Login</button>

        <p class="login-link">
            Don't have an account? <a href="{{ route('usersignup') }}">Create one here</a>
        </p>
    </form>
</div>

@endsection