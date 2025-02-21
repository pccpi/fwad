<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('tasks.index') }}">Список задач</a>
            <a href="{{ url('/about') }}">О нас</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>
