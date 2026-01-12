<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-container">
            <a class="logo" href="/" style="text-decoration: none">🌸 SpaLush</a>

            @guest
                <div class="nav-links">
                    <a href="{{ route('userlogin') }}">Login</a>
                    <a href="{{ route('usersignup') }}">Sign Up</a>
                </div>
            @endguest

            @auth
                <div class="nav-links">
                    <span style="margin-right: 10px;">Welcome, {{ Auth::user()->name }}!</span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button class="logout-btn" type="submit">Logout</button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>