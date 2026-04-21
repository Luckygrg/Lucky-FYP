<body>
    <!-- LUXURY NAVBAR -->
    <nav class="luxury-navbar">
        <div class="luxury-nav-container">
            <a class="luxury-logo" href="/">
                <img src="{{ asset('assets/img/logo.png') }}" alt="SpaLush Logo" style="height: 54px; width: auto; object-fit: contain;">
            </a>

            <div class="luxury-nav-menu">
                @guest
                    <a href="/" class="luxury-nav-link">Home</a>
                    <a href="{{ route('spas.index') }}" class="luxury-nav-link">Our Spas</a>
                    <a href="{{ route('about') }}" class="luxury-nav-link">About</a>
                    <a href="{{ route('contact') }}" class="luxury-nav-link">Contact</a>
                    <a href="{{ route('userlogin') }}" class="luxury-nav-link">Login</a>
                    <a href="{{ route('role.selection') }}" class="luxury-nav-btn">Register</a>
                @endguest

                @auth
                    <a href="/" class="luxury-nav-link">Home</a>
                    {{-- @if(Auth::user()->role === 'customer')
                        <a href="{{ route('customer.services') }}" class="luxury-nav-link">Services</a>
                    @endif --}}
                    <a href="{{ route('spas.index') }}" class="luxury-nav-link">Our Spas</a>

                    <a href="{{ route('about') }}" class="luxury-nav-link">About</a>
                    <a href="{{ route('contact') }}" class="luxury-nav-link">Contact</a>
                    @if(Auth::user()->role === 'spa_owner')
                            <a href="{{ route('spa_owner.dashboard') }}" class="luxury-nav-link">Dashboard</a>
                        <span class="luxury-nav-welcome">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button class="luxury-logout-btn" type="submit">Logout</button>
                        </form>
                    @endif

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.admin') }}" class="luxury-nav-link">Dashboard</a>
                        <span class="luxury-nav-welcome">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button class="luxury-logout-btn" type="submit">Logout</button>
                        </form>
                    @endif

                    @if(Auth::user()->role === 'customer')
                        <!-- Customer Profile Dropdown -->
                        <div class="profile-dropdown" id="profileDropdown">
                            <button class="profile-toggle" id="profileToggle" type="button">
                                <svg class="profile-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                <svg class="dropdown-chevron" id="dropdownChevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6 9 12 15 18 9"/>
                                </svg>
                            </button>

                            <div class="profile-dropdown-menu" id="profileMenu">
                                <!-- User Info Header -->
                                <div class="dropdown-user-info">
                                    @if(Auth::user()->photo)
                                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Photo" class="dropdown-avatar-img">
                                    @else
                                        <div class="dropdown-avatar">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="dropdown-user-name">{{ strtoupper(Auth::user()->name) }}</div>
                                        <div class="dropdown-user-role">CUSTOMER</div>
                                    </div>
                                </div>

                                <div class="dropdown-divider"></div>

                                <!-- Menu Items -->
                                <a href="{{ route('customer.profile') }}" class="dropdown-item">
                                    <i class="fas fa-user"></i>
                                    MY PROFILE
                                </a>
                                <a href="{{ route('customer.profile', ['tab' => 'bookings']) }}" class="dropdown-item">
                                    <i class="fas fa-calendar-check"></i>
                                    BOOKINGS
                                </a>
                                <a href="{{ route('customer.profile', ['tab' => 'payments']) }}" class="dropdown-item">
                                    <i class="fas fa-credit-card"></i>
                                    PAYMENT HISTORY
                                </a>
                                <a href="{{ route('customer.profile', ['tab' => 'notifications']) }}" class="dropdown-item">
                                    <i class="fas fa-bell"></i>
                                    NOTIFICATIONS
                                </a>

                                <div class="dropdown-divider"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item dropdown-logout">
                                        <i class="fas fa-sign-out-alt"></i>
                                        LOGOUT
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <style>
        /* Luxury Navigation Styles */
        .luxury-navbar {
            background: rgba(250, 247, 242, 0.95);
            backdrop-filter: blur(10px);
            padding: 0.5rem 0 0.5rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(200, 145, 106, 0.35);
        }
        
        .luxury-nav-container {
            width: 100%;
            padding: 0 20px 0 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .luxury-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #1C1008;
            padding: 4px 8px;
        }
        
        .logo-icon {
            font-size: 32px;
            color: #C8916A;
        }
        
        .logo-text {
            font-size: 22px;
            font-weight: 300;
            letter-spacing: 3px;
            color: #1C1008;
            font-family: 'Georgia', serif;
        }
        
        .luxury-nav-menu {
            display: flex;
            align-items: center;
            gap: 22px;
        }
        
        .luxury-nav-link {
            color: rgba(28,16,8,0.85);
            text-decoration: none;
            font-size: 14px;
            letter-spacing: 1.8px;
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
            background: #C8916A;
            transition: width 0.3s ease;
        }
        
        .luxury-nav-link:hover {
            color: #C8916A;
        }
        
        .luxury-nav-link:hover::after {
            width: 100%;
        }
        
        .luxury-nav-btn {
            padding: 7px 18px;
            background: transparent;
            color: rgba(28,16,8,0.9);
            border: 1px solid rgba(28,16,8,0.25);
            text-decoration: none;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            font-weight: 400;
        }
        
        .luxury-nav-btn:hover {
            background: rgba(28,16,8,0.05);
            border-color: rgba(28,16,8,0.5);
            color: #1C1008;
        }
        
        .luxury-nav-welcome {
            color: rgba(28,16,8,0.7);
            font-size: 13px;
            letter-spacing: 1px;
            font-weight: 300;
        }
        
        .luxury-logout-btn {
            padding: 6px 16px;
            background: transparent;
            color: #1C1008;
            border: 1px solid rgba(28,16,8,0.3);
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 400;
        }
        
        .luxury-logout-btn:hover {
            background: #C8916A;
            border-color: #C8916A;
            color: #1C1008;
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

        /* Profile Dropdown Styles */
        .profile-dropdown {
            position: relative;
        }

        .profile-toggle {
            display: flex;
            align-items: center;
            gap: 4px;
            background: none;
            border: 1px solid rgba(28,16,8,0.2);
            border-radius: 50px;
            padding: 8px 12px;
            cursor: pointer;
            color: rgba(28,16,8,0.7);
            transition: all 0.3s ease;
        }

        .profile-toggle:hover {
            border-color: #C8916A;
            color: #C8916A;
        }

        .profile-icon {
            width: 22px;
            height: 22px;
        }

        .dropdown-chevron {
            width: 14px;
            height: 14px;
            transition: transform 0.3s ease;
        }

        .dropdown-chevron.rotated {
            transform: rotate(180deg);
        }

        .profile-dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            width: 280px;
            background: #FFFFFF;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12), 0 2px 10px rgba(0,0,0,0.06);
            border: 1px solid rgba(200,145,106,0.15);
            z-index: 2000;
            overflow: hidden;
            animation: dropdownSlide 0.25s ease;
        }

        .profile-dropdown-menu.show {
            display: block;
        }

        @keyframes dropdownSlide {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-user-info {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 20px;
        }

        .dropdown-avatar {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            background: #C8916A;
            color: #1C1008;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 600;
            flex-shrink: 0;
        }

        .dropdown-avatar-img {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .dropdown-user-name {
            font-size: 14px;
            font-weight: 600;
            color: #1C1008;
            letter-spacing: 1px;
        }

        .dropdown-user-role {
            font-size: 11px;
            color: #C8916A;
            letter-spacing: 1.5px;
            margin-top: 2px;
            font-weight: 500;
        }

        .dropdown-divider {
            height: 1px;
            background: rgba(28,16,8,0.08);
            margin: 0;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 20px;
            color: rgba(28,16,8,0.75);
            text-decoration: none;
            font-size: 13px;
            letter-spacing: 1.5px;
            transition: all 0.2s ease;
            border: none;
            background: none;
            width: 100%;
            cursor: pointer;
            font-family: inherit;
        }

        .dropdown-item i {
            width: 18px;
            text-align: center;
            font-size: 15px;
            flex-shrink: 0;
            color: rgba(28,16,8,0.4);
            transition: color 0.2s ease;
        }

        .dropdown-item:hover {
            background: rgba(200,145,106,0.08);
            color: #C8916A;
        }

        .dropdown-item:hover i {
            color: #C8916A;
        }

        .dropdown-logout {
            color: #ef9a9a;
        }

        .dropdown-logout i {
            color: #ef9a9a;
        }

        .dropdown-logout:hover {
            background: rgba(229,57,53,0.08);
            color: #ef9a9a;
        }

        .dropdown-logout:hover i {
            color: #ef9a9a;
        }
    </style>

    @auth
    @if(Auth::user()->role === 'customer')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('profileToggle');
            const menu = document.getElementById('profileMenu');
            const chevron = document.getElementById('dropdownChevron');

            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.classList.toggle('show');
                chevron.classList.toggle('rotated');
            });

            document.addEventListener('click', function(e) {
                if (!document.getElementById('profileDropdown').contains(e.target)) {
                    menu.classList.remove('show');
                    chevron.classList.remove('rotated');
                }
            });
        });
    </script>
    @endif
    @endauth

    