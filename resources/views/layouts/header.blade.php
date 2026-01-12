<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'SpaLush - Nepal\'s Premier Spa Booking Platform')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
            color: white;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 8px 20px;
            border: 2px solid white;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .nav-links a:hover {
            background: white;
            color: #667eea;
        }

        .nav-links a:last-child {
            background: white;
            color: #667eea;
            border: none;
            font-weight: 600;
        }

        .logout-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 1px solid white;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: white;
            color: #667eea;
        }

        main {
            flex: 1;
            width: 100%;
        }

        footer {
            background: #2c3e50;
            color: white;
            padding: 40px 0 20px;
            margin-top: auto;
        }

        footer a:hover {
            color: #667eea !important;
        }

        @media (max-width: 600px) {
            .nav-container {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>