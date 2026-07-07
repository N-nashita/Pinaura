<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pinaura — find your vibe')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,500&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/pinaura.css') }}">
</head>
<body>

    <aside class="sidebar">
        <a href="{{ route('home') }}" class="sidebar-logo">p</a>

        <nav class="sidebar-nav">
            <a href="{{ route('home') }}" class="sidebar-link active" title="Home">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    
                     <path stroke-linecap="round" stroke-linejoin="round" 
              d="M3 9.5L12 3l9 6.5V21a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1V9.5z"/>
                </svg>
            </a>

            <a href="{{ route('grid') }}" class="sidebar-link" title="Grid">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                    <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                    <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                    <rect x="14" y="14" width="7" height="7" rx="1.5"/>
                </svg>
            </a>

            <a href="{{ route('pins.create') }}" class="sidebar-link" title="Create">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M12 5v14M5 12h14"/>
                </svg>
            </a>

            <a href="{{ route('boards.index') }}" class="sidebar-link" title="Boards">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l3.5 7 7.5 1-5.5 5.2L18.5 22 12 18l-6.5 4 1-6.8L1 10l7.5-1z"/>
                </svg>
            </a>
        </nav>

        <div class="sidebar-bottom">
            <a href="{{ route('profile.show') }}" class="sidebar-account" title="Account">
                {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : '👤' }}
            </a>
            <a href="{{ route('profile.settings') }}" class="sidebar-link" title="Settings">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06A1.65 1.65 0 004.6 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06A1.65 1.65 0 009 4.6a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
                </svg>
            </a>
        </div>
    </aside>

    <div class="page-wrap">
        <header class="site-header">
            <div class="header-inner">
                <form action="{{ route('home') }}" method="GET" class="search-form">
                    <div class="search-box">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                        </svg>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search pins or a vibe...">
                    </div>
                </form>
            </div>

            @include('partials.filter-bar')
        </header>

        <main>
            @yield('content')
        </main>
    </div>

</body>
</html>