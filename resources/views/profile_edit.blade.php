<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование профиля</title>
</head>
<body>
    @include('components.header-seller')   

    <h1>Редактирование профиля</h1>

    <form action="{{ route('profile.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        <br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" placeholder="Оставьте пустым, если не хотите менять">
        <br>

        <!-- Добавляем поле для ввода ссылки на аватар -->
        <label for="avatar_url">Ссылка на аватар:</label>
        <input type="text" id="avatar_url" name="avatar_url" value="{{ old('avatar_url', $user->avatar_url) }}">
        <br>

        <!-- Добавляем поле для ввода URL картинки логотипа -->
        @if(auth()->check() && auth()->user()->user_status == 1)
            <label for="logo_url">URL картинки логотипа:</label>
            <input type="text" id="logo_url" name="logo_url" value="{{ old('logo_url', $user->logo_url) }}">
            <br>
        @endif

        <button type="submit">Сохранить изменения</button>
    </form>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>