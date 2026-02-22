@extends('layouts.main')

@section('title', 'Login - SpaLush')

@section('content')

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    .login-wrapper {
        min-height: 100vh;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }
    
    .login-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 2px solid #e8e8e8;
        max-width: 450px;
        width: 100%;
        padding: 45px 40px;
    }
    
    .login-header {
        text-align: center;
        margin-bottom: 35px;
    }
    
    .login-header h2 {
        color: #1a1a1a;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .login-header p {
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
    
    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .alert strong {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
    }
    
    .alert ul {
        margin-left: 20px;
        margin-top: 8px;
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
    
    .submit-btn:active {
        transform: translateY(0);
    }
    
    .form-footer {
        margin-top: 30px;
        text-align: center;
    }
    
    .form-footer a {
        color: #c9a961;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .form-footer a:hover {
        color: #b8985a;
        text-decoration: underline;
    }
    
    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 25px 0;
        color: #999999;
        font-size: 14px;
    }
    
    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #e8e8e8;
    }
    
    .divider span {
        padding: 0 15px;
    }
    
    @media (max-width: 576px) {
        .login-container {
            padding: 35px 25px;
        }
        
        .login-header h2 {
            font-size: 26px;
        }
    }
</style>

<div class="login-wrapper">
    <div class="login-container">
        <div class="login-header">
            <h2>Welcome Back</h2>
            <p>Login to your SpaLush account</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>⚠ Please fix the following errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
        
        <form action="{{ route('loginuser') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input 
                    type="email" 
                    id="email"
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="Enter your email" 
                    required
                >
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
            </div>
            
            <button type="submit" class="submit-btn">Login</button>
        </form>
        
        <div class="divider">
            <span>OR</span>
        </div>
        
        <div class="form-footer">
            Don't have an account? <a href="{{ route('role.selection') }}">Sign Up</a>
        </div>
    </div>
</div>

@endsection