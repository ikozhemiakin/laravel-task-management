<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Task Management') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-body">
    <div class="app-shell">
        <header class="app-header">
            <div class="app-header-inner">
                <a href="{{ route('tasks.index') }}" class="app-brand">
                    <span class="app-brand-mark" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M2.25 6a3 3 0 0 1 3-3h13.5a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V6Zm3.97.97a.75.75 0 0 1 1.06 0l2.25 2.25a.75.75 0 0 1-1.06 1.06l-1.47-1.47-1.72 1.72a.75.75 0 1 1-1.06-1.06l2.25-2.25Zm0 7.5a.75.75 0 0 1 1.06 0l2.25 2.25a.75.75 0 0 1-1.06 1.06l-1.47-1.47-1.72 1.72a.75.75 0 1 1-1.06-1.06l2.25-2.25Zm7.5-7.5a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Zm0 7.5a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span>
                        <span class="app-brand-title">Task Management</span>
                        <span class="app-brand-sub">Projects & priorities</span>
                    </span>
                </a>

                <nav class="app-nav" aria-label="Main">
                    <a href="{{ route('tasks.index') }}"
                       class="app-nav-link {{ request()->routeIs('tasks.*') ? 'app-nav-link-active' : '' }}">
                        Tasks
                    </a>
                    <a href="{{ route('projects.index') }}"
                       class="app-nav-link {{ request()->routeIs('projects.*') ? 'app-nav-link-active' : '' }}">
                        Projects
                    </a>
                </nav>
            </div>
        </header>

        <main class="app-main">
            @if (session('success'))
                <x-alert type="success">{{ session('success') }}</x-alert>
            @endif

            @if (session('warning'))
                <x-alert type="warning">{{ session('warning') }}</x-alert>
            @endif

            @yield('content')
        </main>

        <footer class="app-footer">
            <p>Laravel task management · Drag-and-drop priorities</p>
        </footer>
    </div>
</body>
</html>
