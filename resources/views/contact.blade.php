@extends('layouts.main')

@section('title', 'Contact Us - SpaLush')

@section('content')

<style>
    .contact-hero {
        background: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
                    url('{{ asset("assets/img/aboutus.png") }}') center/cover;
        padding: 100px 20px;
        text-align: center;
        color: #FAF7F2;
    }

    .contact-hero h1 {
        font-size: 56px;
        font-weight: 300;
        letter-spacing: 3px;
        margin-bottom: 32px;
        font-family: 'Georgia', serif;
        text-transform: uppercase;
        line-height: 1.08;
    }

    .contact-hero p {
        font-size: 18px;
        font-weight: 300;
        color: rgba(255, 255, 255, 0.9);
        letter-spacing: 1px;
        max-width: 600px;
        margin: 0 auto;
    }

    .contact-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 80px 40px;
        display: grid;
        grid-template-columns: 1fr 1.4fr;
        gap: 60px;
        align-items: start;
    }

    /* Left: Contact Info */
    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 36px;
    }

    .contact-info-item {
        display: flex;
        align-items: flex-start;
        gap: 18px;
    }

    .contact-icon {
        width: 48px;
        height: 48px;
        background: rgba(200, 145, 106, 0.12);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .contact-icon i {
        font-size: 20px;
        color: #C8916A;
    }

    .contact-info-text h3 {
        font-family: 'Georgia', serif;
        font-size: 17px;
        font-weight: 600;
        color: #1C1008;
        margin: 0 0 6px;
    }

    .contact-info-text p {
        color: #777;
        font-size: 15px;
        margin: 0;
        line-height: 1.5;
    }

    /* Right: Form Card */
    .contact-form-card {
        background: #ffffff;
        border: 1px solid rgba(200, 145, 106, 0.2);
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    }

    .contact-form-card h2 {
        font-family: 'Georgia', serif;
        font-size: 26px;
        font-weight: 400;
        color: #1C1008;
        margin: 0 0 8px;
    }

    .contact-form-card .form-subtitle {
        color: #999;
        font-size: 14px;
        margin: 0 0 28px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #555;
        margin-bottom: 6px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        color: #333;
        background: #fafafa;
        transition: all 0.3s ease;
        font-family: Arial, sans-serif;
        box-sizing: border-box;
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: #bbb;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #C8916A;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(200, 145, 106, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 140px;
    }

    .contact-submit-btn {
        display: inline-block;
        padding: 14px 36px;
        background: #1C1008;
        color: #FAF7F2;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .contact-submit-btn:hover {
        background: #C8916A;
        color: #fff;
        box-shadow: 0 4px 16px rgba(200, 145, 106, 0.35);
    }

    /* Success message */
    .contact-success {
        background: #e8f5e9;
        border: 1px solid #a5d6a7;
        color: #2e7d32;
        padding: 14px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .contact-section {
            grid-template-columns: 1fr;
            padding: 50px 20px;
            gap: 40px;
        }

        .contact-hero h1 {
            font-size: 34px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

{{-- Hero Banner --}}
<section class="contact-hero">
    <h1>Contact Us</h1>
    <p>Have a question or ready to book? We're here to make your experience seamless and relaxing.</p>
</section>

{{-- Contact Content --}}
<section class="contact-section">

    {{-- Left: Info --}}
    <div class="contact-info">
        <div class="contact-info-item">
            <div class="contact-icon">
                <i class="fa-solid fa-location-dot"></i>
            </div>
            <div class="contact-info-text">
                <h3>Our Location</h3>
                <p>SpaLush Headquarters<br>Pokhara, Nepal</p>
            </div>
        </div>

        <div class="contact-info-item">
            <div class="contact-icon">
                <i class="fa-solid fa-phone"></i>
            </div>
            <div class="contact-info-text">
                <h3>Call Us</h3>
                <p>+977 9800000000</p>
            </div>
        </div>

        <div class="contact-info-item">
            <div class="contact-icon">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="contact-info-text">
                <h3>Email Us</h3>
                <p>info@spalush.com</p>
            </div>
        </div>

        <div class="contact-info-item">
            <div class="contact-icon">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="contact-info-text">
                <h3>Working Hours</h3>
                <p>Open 24 hours, 7 days a week</p>
            </div>
        </div>
    </div>

    {{-- Right: Form --}}
    <div class="contact-form-card">
        <h2>Send us a Message</h2>
        <p class="form-subtitle">Fill out the form below and we'll get back to you shortly.</p>

        @if(session('success'))
            <div class="contact-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('contact.send') }}" method="POST">
            @csrf

            <div class="form-row">
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" placeholder="Your Name" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                    @error('name') <span style="color:#e53935;font-size:12px;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="email">Your Email</label>
                    <input type="email" id="email" name="email" placeholder="Your Email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                    @error('email') <span style="color:#e53935;font-size:12px;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" placeholder="Phone Number" value="{{ old('phone') }}">
                @error('phone') <span style="color:#e53935;font-size:12px;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" placeholder="Subject" value="{{ old('subject') }}" required>
                @error('subject') <span style="color:#e53935;font-size:12px;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea id="message" name="message" placeholder="Your Message" required>{{ old('message') }}</textarea>
                @error('message') <span style="color:#e53935;font-size:12px;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="contact-submit-btn">Send Message</button>
        </form>
    </div>

</section>

@endsection
