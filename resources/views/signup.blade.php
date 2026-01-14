@extends('layouts.main')

@section('title', 'Sign Up - SpaLush')

@section('content')

<div style="max-width: 450px; margin: 60px auto; padding: 40px; background: white; border-radius: 8px;">
    
    <h2 style="text-align: center; color: green;">Sign Up for SpaLush</h2>
    
    <br>

    {{-- SHOW ALL ERRORS AT TOP --}}
    @if ($errors->any())
        <div style="background: #ffcccc; padding: 15px; border-radius: 4px; margin-bottom: 20px; border: 2px solid red;">
            <strong style="color: red;">ERROR! Please fix these problems:</strong>
            <ul style="margin: 10px 0 0 20px; color: red;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- SHOW SESSION ERROR --}}
    @if(session('error'))
        <div style="background: #ffcccc; padding: 15px; border-radius: 4px; margin-bottom: 20px; border: 2px solid red; color: red;">
            {{ session('error') }}
        </div>
    @endif

    {{-- SHOW SESSION SUCCESS --}}
    @if(session('success'))
        <div style="background: #ccffcc; padding: 15px; border-radius: 4px; margin-bottom: 20px; border: 2px solid green; color: green;">
            {{ session('success') }}
        </div>
    @endif
    
    <form action="{{ route('usersignup.create') }}" method="POST">
        @csrf
        
        <label>Full Name</label>
        <br>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd;">
        
        <br>
        
        <label>Email</label>
        <br>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd;">
        
        <br>
        
        <label>Password (minimum 8 characters)</label>
        <br>
        <input type="password" name="password" placeholder="Enter password" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd;">
        
        <br>
        
        <label>Confirm Password</label>
        <br>
        <input type="password" name="password_confirmation" placeholder="Confirm password" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd;">
        
        <br>
        
        <button type="submit" style="width: 100%; padding: 12px; background: green; color: white; border: none; cursor: pointer; font-size: 16px; font-weight: bold;">
            Sign Up
        </button>
    </form>
    
    <br>
    
    <p style="text-align: center;">
        Have an account? <a href="{{ route('userlogin') }}" style="color: green;">Login</a>
    </p>

</div>

@endsection