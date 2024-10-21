<!DOCTYPE html>
<html lang="ru">
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
</head>
<body>
    @include('components.header-seller')   

<div class="header">
    <a href="{{ route('register') }}">Нет аккаунта? Зарегистрируйся</a>
</div>

<div class="container">
    <h2>Авторизация</h2>

    @if ($errors->any())
        <div>
            <strong>{{ $errors->first() }}</strong>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" required><br> <!-- Изменено на email -->
        <input type="password" name="password" placeholder="Пароль" required><br>
        <div>
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Запомнить меня</label>
        </div>
    
        <button type="submit">Войти</button>
    </form>
</div>

</body>
</html>
