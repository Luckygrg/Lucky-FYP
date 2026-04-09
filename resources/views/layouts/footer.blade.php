
<footer class="luxury-footer minimal-footer">
    <div class="luxury-footer-container minimal-footer-container">
        <div class="footer-brand">
             <img src="{{ asset('assets/img/logo2.png') }}" alt="SpaLush" style="height:60px;">
            <div class="footer-logo" style="font-family:'Georgia',serif;font-size:1.6rem;color:#C8916A;font-weight:500;padding:15px;">SpaLush</div>

            <div class="footer-tagline" style="color:#9c8b7a;letter-spacing:1.5px;font-size:1rem;margin-top:2px;">RESTORE. RENEW. RETURN.</div>
        </div>
        <nav class="footer-nav">
            <a href="/" class="footer-link">Home</a>
            <a href="{{ route('spas.index') }}" class="footer-link">Our Spas</a>
            <a href="{{ route('about') }}" class="footer-link">About</a>
            <a href="{{ route('contact') }}" class="footer-link">Contact</a>
        </nav>
       
        <div class="footer-social">
            <a href="#" aria-label="Facebook" class="footer-social-btn"><i class="fa-brands fa-facebook"></i></a>
            <a href="#" aria-label="Instagram" class="footer-social-btn"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" aria-label="Twitter" class="footer-social-btn"><i class="fa-brands fa-twitter"></i></a>
            <a href="#" aria-label="LinkedIn" class="footer-social-btn"><i class="fa-brands fa-linkedin"></i></a>
        </div>
        <div class="footer-divider"></div>
        <div class="footer-copyright">
            &copy; {{ date('Y') }} SpaLush · <a href="#" class="footer-legal">Privacy</a> · <a href="#" class="footer-legal">Terms</a>
        </div>
    </div>
</footer>

<style>
.minimal-footer {
    background: linear-gradient(rgba(250,247,242,0.92), rgba(250,247,242,0.92)), url("{{ asset('assets/img/spa2.jpg') }}") center/cover no-repeat;
    color: #9c8b7a;
    padding: 32px 0 0 0;
    border-top: 1px solid #e5d8c8;
    font-family: 'Georgia', serif;
}
.minimal-footer-container {
    width: 100vw;
    max-width: 100vw;
    margin: 0;
    text-align: center;
    padding: 0;
}
/* .footer-brand {
    margin-bottom: 8px;
} */
.footer-tagline {
    margin-bottom: 18px;
    font-size: 1rem;
    color: #9c8b7a;
    letter-spacing: 2px;
}
.footer-nav {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 32px;
    margin-bottom: 18px;
}
.footer-link {
    color: #9c8b7a;
    text-decoration: none;
    font-size: 1rem;
    letter-spacing: 1px;
    font-weight: 400;
    transition: color 0.2s;
}
.footer-link:hover {
    color: #C8916A;
}
.footer-social {
    display: flex;
    justify-content: center;
    gap: 18px;
    margin-bottom: 18px;
}
.footer-social-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border: 1px solid #C8916A;
    border-radius: 50%;
    overflow: hidden;
    background: transparent;
    transition: border-color 0.2s, opacity 0.2s;
}
.footer-social-btn img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}
.footer-social-btn:hover {
    border-color: #a0704e;
    opacity: 0.85;
}
.footer-divider {
    border-top: 1px solid #e5d8c8;
    margin: 18px 0 10px 0;
}
.footer-copyright {
    color: #b9a892;
    font-size: 13px;
    margin-bottom: 8px;
}
.footer-legal {
    color: #b9a892;
    text-decoration: none;
    margin: 0 4px;
    font-size: 13px;
}
.footer-legal:hover {
    color: #C8916A;
}
@media (max-width: 600px) {
    .footer-nav {
        gap: 12px;
        font-size: 0.95rem;
    }
    .footer-social {
        gap: 10px;
    }
}
</style>

    <style>
        /* Luxury Footer Styles */
        .luxury-footer {
            background: #FAF7F2;
            color: rgba(28,16,8,0.7);
            padding: 32px 0 10px;
            margin-top: 0;
            border-top: 1px solid rgba(200, 145, 106, 0.35);
        }
        
        .luxury-footer-container {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 16px;
        }
        
        .luxury-footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 32px;
            margin-bottom: 12px;
        }
        
        .luxury-footer-section h3 {
            color: #C8916A;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: 400;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-family: 'Georgia', serif;
        }
        
        .luxury-footer-section p {
            color: rgba(28,16,8,0.6);
            line-height: 1.6;
            font-size: 13px;
            font-weight: 300;
        }
        
        .luxury-footer-section ul {
            list-style: none;
            padding: 0;
        }
        
        .luxury-footer-section li {
            margin-bottom: 7px;
            color: rgba(28,16,8,0.6);
            font-size: 13px;
            font-weight: 300;
        }
        
        .luxury-footer-section a {
            color: rgba(28,16,8,0.6);
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 14px;
        }
        
        .luxury-footer-section a:hover {
            color: #C8916A;
        }
        
        .luxury-social-links {
            display: flex;
            gap: 8px;
        }
        
        .luxury-social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: transparent;
            border: 1px solid rgba(28,16,8,0.2);
            color: rgba(28,16,8,0.6);
            text-decoration: none;
            font-size: 11px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .luxury-social-links a:hover {
            background: #C8916A;
            border-color: #C8916A;
            color: #1C1008;
        }
        
        .luxury-copyright {
            border-top: 1px solid rgba(28,16,8,0.1);
            padding-top: 12px;
            text-align: center;
        }
        
        .luxury-copyright p {
            color: rgba(28,16,8,0.4);
            font-size: 11px;
            letter-spacing: 1px;
            font-weight: 300;
        }
        
        @media (max-width: 1024px) {
            .luxury-footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 18px;
            }
        }
        @media (max-width: 768px) {
            .luxury-footer {
                padding: 60px 0 30px;
            }
            .luxury-footer-container {
                padding: 0 10px;
            }
            .luxury-footer-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }
        }
    </style>

@stack('scripts')
</body>
</html>