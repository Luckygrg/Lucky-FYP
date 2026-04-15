@extends('layouts.main')

@section('title', 'Verify Your Email - SpaLush')

@section('content')

<style>
    .verify-wrapper {
        min-height: 80vh;
        background: #FAF7F2;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    .verify-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        max-width: 500px;
        width: 100%;
        padding: 50px 40px;
        text-align: center;
    }

    .verify-icon {
        font-size: 64px;
        color: #c9a961;
        margin-bottom: 25px;
    }

    .verify-card h2 {
        font-size: 28px;
        font-weight: 300;
        color: #1a1a1a;
        margin-bottom: 15px;
        font-family: 'Georgia', serif;
        letter-spacing: 1px;
    }

    .verify-card p {
        font-size: 16px;
        color: #666;
        line-height: 1.7;
        margin-bottom: 15px;
    }

    .timer-box {
        background: #fff8e6;
        border: 1px solid #c9a961;
        border-radius: 8px;
        padding: 15px 20px;
        margin: 25px 0;
        font-size: 15px;
        color: #856404;
    }

    .timer-box span {
        font-weight: 700;
        font-size: 20px;
        color: #c9a961;
    }

    .back-link {
        display: inline-block;
        margin-top: 20px;
        color: #c9a961;
        text-decoration: none;
        font-size: 14px;
        letter-spacing: 1px;
        text-transform: uppercase;
        border-bottom: 1px solid transparent;
        transition: border-color 0.3s;
    }

    .back-link:hover {
        border-bottom-color: #c9a961;
    }
</style>

<div class="verify-wrapper">
    <div class="verify-card">
        <div class="verify-icon">
            <i class="fas fa-envelope-open-text"></i>
        </div>
        <h2>Check Your Email</h2>
        <p>We've sent a verification link to your email address. Please open it to activate your account.</p>

        <div class="timer-box">
            Link expires in <span id="countdown">3:00</span>
        </div>

        <p style="font-size: 14px; color: #999;">Didn't receive it? Check your spam folder, or register again after the timer expires.</p>

        <a href="{{ route('role.selection') }}" class="back-link">← Register Again</a>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<script>
    let seconds = 180;
    const el = document.getElementById('countdown');

    const interval = setInterval(() => {
        seconds--;
        const m = Math.floor(seconds / 60);
        const s = seconds % 60;
        el.textContent = m + ':' + String(s).padStart(2, '0');

        if (seconds <= 0) {
            clearInterval(interval);
            el.textContent = 'Expired';
            el.style.color = '#dc3545';
        }
    }, 1000);
</script>

@endsection
