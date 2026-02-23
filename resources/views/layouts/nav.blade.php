<body>
    <!-- LUXURY NAVBAR -->
    <nav class="luxury-navbar">
        <div class="luxury-nav-container">
            <a class="luxury-logo" href="/">
                <img src="{{ asset('assets/img/logo.png') }}" alt="SpaLush Logo" style="height: 100px; width: auto; object-fit: contain;">
            </a>

            <div class="luxury-nav-menu">
                @guest
                    <a href="/" class="luxury-nav-link">Home</a>
                    <a href="{{ route('spas.index') }}" class="luxury-nav-link">Our Spas</a>
                    <a href="{{ route('about') }}" class="luxury-nav-link">About</a>
                    <a href="{{ route('userlogin') }}" class="luxury-nav-link">Login</a>
                    <a href="{{ route('role.selection') }}" class="luxury-nav-btn">Register</a>
                @endguest

                @auth
                    <a href="/" class="luxury-nav-link">Home</a>
                    <a href="{{ route('spas.index') }}" class="luxury-nav-link">Our Spas</a>
                    <a href="{{ route('about') }}" class="luxury-nav-link">About</a>
                    <a href="#" class="luxury-nav-link">My Bookings</a>
                    <span class="luxury-nav-welcome">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button class="luxury-logout-btn" type="submit">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <style>
        /* Luxury Navigation Styles */
        .luxury-navbar {
            background: rgba(26, 26, 26, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
        
        .luxury-nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .luxury-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: white;
        }
        
        .logo-icon {
            font-size: 24px;
            color: #c9a961;
        }
        
        .logo-text {
            font-size: 22px;
            font-weight: 300;
            letter-spacing: 3px;
            color: white;
            font-family: 'Georgia', serif;
        }
        
        .luxury-nav-menu {
            display: flex;
            align-items: center;
            gap: 35px;
        }
        
        .luxury-nav-link {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 13px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-weight: 400;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .luxury-nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 1px;
            background: #c9a961;
            transition: width 0.3s ease;
        }
        
        .luxury-nav-link:hover {
            color: #c9a961;
        }
        
        .luxury-nav-link:hover::after {
            width: 100%;
        }
        
        .luxury-nav-btn {
            padding: 10px 28px;
            background: transparent;
            color: rgba(255,255,255,0.9);
            border: 1px solid rgba(255,255,255,0.25);
            text-decoration: none;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            font-weight: 400;
        }
        
        .luxury-nav-btn:hover {
            background: rgba(255,255,255,0.05);
            border-color: rgba(255,255,255,0.5);
            color: white;
        }
        
        .luxury-nav-welcome {
            color: rgba(255,255,255,0.7);
            font-size: 13px;
            letter-spacing: 1px;
            font-weight: 300;
        }
        
        .luxury-logout-btn {
            padding: 10px 28px;
            background: transparent;
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 400;
        }
        
        .luxury-logout-btn:hover {
            background: #c9a961;
            border-color: #c9a961;
            color: #1a1a1a;
        }
        
        @media (max-width: 768px) {
            .luxury-nav-container {
                padding: 0 20px;
            }
            
            .luxury-nav-menu {
                gap: 15px;
                flex-wrap: wrap;
            }
            
            .luxury-nav-link {
                font-size: 11px;
            }
        }
    </style>

    