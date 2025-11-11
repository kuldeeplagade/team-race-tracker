<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #0d6efd;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            padding-top: 20px;
            transition: all 0.3s;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            font-size: 15px;
            border-radius: 8px;
            margin: 4px 10px;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #0b5ed7;
        }
        .content {
            margin-left: 240px;
            padding: 25px;
            transition: all 0.3s;
        }
        .sidebar .brand {
            font-size: 20px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 25px;
        }
        /* Responsive sidebar */
        @media (max-width: 991px) {
            .sidebar {
                left: -240px;
            }
            .sidebar.active {
                left: 0;
            }
            .content {
                margin-left: 0;
            }
            .toggle-btn {
                display: block;
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 1000;
                background: #0d6efd;
                border: none;
                color: white;
                border-radius: 6px;
                padding: 8px 10px;
            }
        }
        .toggle-btn {
            display: none;
        }
    </style>
</head>
<body>

    <!-- Toggle button for mobile -->
    <button class="toggle-btn" id="sidebarToggle"><i class="bi bi-list"></i></button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebarMenu">
        <div class="brand mb-3"><i class="bi bi-trophy me-2"></i>Race Tracker</div>

        <a href="{{ route('teams.index') }}" class="{{ request()->is('teams*') ? 'active' : '' }}">
            <i class="bi bi-people me-2"></i> Teams
        </a>

        <a href="{{ route('members.index') }}" class="{{ request()->is('members*') ? 'active' : '' }}">
            <i class="bi bi-person-lines-fill me-2"></i> Members
        </a>

        <a href="{{ route('races.index') }}" class="{{ request()->is('races*') ? 'active' : '' }}">
            <i class="bi bi-flag me-2"></i> Races
        </a>

        <a href="{{ route('race_logs.index') }}" class="{{ request()->is('race_logs*') ? 'active' : '' }}">
            <i class="bi bi-stopwatch me-2"></i> Race Logs
        </a>

        <a href="{{ route('race.reports') }}" class="{{ request()->is('race-reports*') ? 'active' : '' }}">
            <i class="bi bi-graph-up-arrow me-2"></i> Reports
        </a>
    </div>

    <!-- Main Content -->
    <div class="content">
        @yield('content')
    </div>

    <script>
        const sidebar = document.getElementById('sidebarMenu');
        const toggle = document.getElementById('sidebarToggle');
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    </script>

</body>
</html>
