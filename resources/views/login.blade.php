@extends('layouts.main')

@section('content')

<div style="max-width: 450px; margin: 60px auto; padding: 40px; background: white; border-radius: 8px;">
    
    <h2 style="text-align: center; color: green;">Login to SpaLush</h2>
    
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
    
    <form action="{{ route('loginuser') }}" method="POST">
        @csrf
        
        <label>Email</label>
        <br>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd;">
        
        <br>
        
        <label>Password</label>
        <br>
        <input type="password" name="password" placeholder="Enter your password" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd;">
        
        <br>
        
        <button type="submit" style="width: 100%; padding: 12px; background: green; color: white; border: none; cursor: pointer; font-size: 16px; font-weight: bold;">
            Login
        </button>
    </form>
    
    <br>
    
    <p style="text-align: center;">
        No account? <a href="{{ route('usersignup') }}" style="color: green;">Sign Up</a>
    </p>

</div>

@endsection