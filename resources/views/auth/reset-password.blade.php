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
        background: #FAF7F2;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }
    
    .reset-container {
        background: #FFFFFF;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.4);
        border: 2px solid rgba(200,145,106,0.2);
        max-width: 450px;
        width: 100%;
        padding: 45px 40px;
    }
    
    .reset-header {
        text-align: center;
        margin-bottom: 35px;
    }
    
    .reset-header h2 {
        color: #1C1008;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .reset-header p {
        color: rgba(28,16,8,0.6);
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
        color: rgba(28,16,8,0.7);
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .form-group input {
        width: 100%;
        padding: 14px 16px;
        border: 1px solid rgba(28,16,8,0.15);
        border-radius: 10px;
        font-size: 15px;
        color: rgba(28,16,8,0.9);
        transition: all 0.3s ease;
        background: #F5EEE4;
    }
    
    .form-group input:focus {
        outline: none;
        border-color: #C8916A;
        box-shadow: 0 0 0 3px rgba(200, 145, 106, 0.1);
    }
    
    .form-group input::placeholder {
        color: rgba(28,16,8,0.3);
    }
    
    .password-wrapper {
        position: relative;
    }
    
    .password-wrapper input {
        padding-right: 48px;
    }
    
    .toggle-password {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: rgba(28,16,8,0.4);
        font-size: 16px;
        padding: 0;
        transition: color 0.2s;
    }
    
    .toggle-password:hover {
        color: #C8916A;
    }
    
    .submit-btn {
        width: 100%;
        padding: 16px;
        background: #C8916A;
        color: #1C1008;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(200, 145, 106, 0.3);
        margin-top: 10px;
    }
    
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(200, 145, 106, 0.4);
        background: #AE7A55;
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
                <div class="password-wrapper">
                    <input 
                        type="password" 
                        id="password"
                        name="password" 
                        placeholder="Enter new password" 
                        required
                    >
                    <button type="button" class="toggle-password" onclick="togglePwd('password', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <div class="password-wrapper">
                    <input 
                        type="password" 
                        id="password_confirmation"
                        name="password_confirmation" 
                        placeholder="Re-enter your password" 
                        required
                    >
                    <button type="button" class="toggle-password" onclick="togglePwd('password_confirmation', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <button type="submit" class="submit-btn">Reset Password</button>
        </form>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script>
    function togglePwd(id, btn) {
        const input = document.getElementById(id);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
    </div>
</div>

@endsection
