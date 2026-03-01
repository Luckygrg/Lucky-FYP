<style>
    .sidebar {
        width: 260px;
        min-width: 260px;
        background: #1a1a1a;
        padding: 30px 0;
        display: flex;
        flex-direction: column;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        min-height: 100vh;
    }

    .sidebar .logo {
        font-size: 24px;
        font-weight: 300;
        color: white;
        margin: 0 30px 50px;
        letter-spacing: 3px;
        font-family: 'Georgia', serif;
        text-decoration: none;
        display: block;
    }

    .sidebar .logo span { color: #c9a961; }

    .menu-item {
        padding: 15px 30px;
        margin-bottom: 3px;
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s;
        font-size: 14px;
        letter-spacing: 0.5px;
        border-left: 3px solid transparent;
    }

    .menu-item:hover {
        background: rgba(201, 169, 97, 0.1);
        color: #c9a961;
    }

    .menu-item.active {
        background: rgba(201, 169, 97, 0.15);
        color: #c9a961;
        border-left-color: #c9a961;
    }

    .sidebar-logout-form {
        margin-top: auto;
        padding: 0 30px 10px;
    }

    .logout-btn {
        width: 100%;
        padding: 12px 20px;
        border-radius: 4px;
        border: 1px solid rgba(255,255,255,0.2);
        background: transparent;
        color: rgba(255,255,255,0.7);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
        font-size: 14px;
        letter-spacing: 0.5px;
    }

    .logout-btn:hover {
        background: #c9a961;
        border-color: #c9a961;
        color: white;
    }
</style>

<div class="sidebar">
    <a href="{{ route('spa_owner.dashboard') }}" class="logo">SPA<span>LUSH</span></a>

    <a href="{{ route('spa_owner.dashboard') }}"
       class="menu-item {{ request()->routeIs('spa_owner.dashboard') ? 'active' : '' }}">
        <span>📊</span> Dashboard
    </a>

    <a href="{{ route('spa_owner.services') }}"
       class="menu-item {{ request()->routeIs('spa_owner.services*') ? 'active' : '' }}">
        <span>💆</span> Services
    </a>

    <a href="{{ route('spa_owner.bookings') }}"
       class="menu-item {{ request()->routeIs('spa_owner.bookings') ? 'active' : '' }}">
        <span>📅</span> Bookings
    </a>

    <a href="{{ route('spa_owner.schedule') }}"
       class="menu-item {{ request()->routeIs('spa_owner.schedule') ? 'active' : '' }}">
        <span>🕐</span> Schedule
    </a>

    <a href="{{ route('spa_owner.customers') }}"
       class="menu-item {{ request()->routeIs('spa_owner.customers') ? 'active' : '' }}">
        <span>👥</span> Customers
    </a>

    <a href="{{ route('spa_owner.settings') }}"
       class="menu-item {{ request()->routeIs('spa_owner.settings') ? 'active' : '' }}">
        <span>⚙️</span> Settings
    </a>

    <div class="sidebar-logout-form" style="margin-top: auto;">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <span>🚪</span> Log Out
            </button>
        </form>
    </div>
</div>
