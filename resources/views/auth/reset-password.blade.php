@extends('layouts.main')

@section('title', 'Reset Password - SpaLush')

@section('content')

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    .reset-wrapper {
        min-height: 100vh;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }
    
    .reset-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 2px solid #e8e8e8;
        max-width: 450px;
        width: 100%;
        padding: 45px 40px;
    }
    
    .reset-header {
        text-align: center;
        margin-bottom: 35px;
    }
    
    .reset-header h2 {
        color: #1a1a1a;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .reset-header p {
        color: #666666;
        font-size: 15px;
    }
    
    .alert {
        padding: 15px 18px;
        border-radius: 10px;
        margin-bottom: 25px;
        font-size: 14px;
        line-height: 1.5;
    }
    
    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-group label {
        display: block;
        color: #1a1a1a;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .form-group input {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e8e8e8;
        border-radius: 10px;
        font-size: 15px;
        color: #1a1a1a;
        transition: all 0.3s ease;
        background: white;
    }
    
    .form-group input:focus {
        outline: none;
        border-color: #c9a961;
        box-shadow: 0 0 0 3px rgba(201, 169, 97, 0.1);
    }
    
    .form-group input::placeholder {
        color: #999999;
    }
    
    .submit-btn {
        width: 100%;
        padding: 16px;
        background: #c9a961;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(201, 169, 97, 0.3);
        margin-top: 10px;
    }
    
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(201, 169, 97, 0.4);
        background: #b8985a;
    }
    
    @media (max-width: 576px) {
        .reset-container {
            padding: 35px 25px;
        }
        
        .reset-header h2 {
            font-size: 26px;
        }
    }
</style>

<div class="reset-wrapper">
    <div class="reset-container">
        <div class="reset-header">
            <h2>Reset Password</h2>
            <p>Enter your new password below</p>
        </div>

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Please fix the following errors:</strong>
                <ul style="margin: 10px 0 0 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div class="form-group">
                <label for="password">New Password</label>
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    placeholder="Enter new password (min 8 characters)" 
                    required
                >
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
            
            <button type="submit" class="submit-btn">Reset Password</button>
        </form>
    </div>
</div>

@endsection
