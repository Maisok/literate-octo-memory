<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}"> <!-- Подключение CSS-файла -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=bef13086-2418-4e93-bac9-45e709948f50&lang=ru_RU&suggest_apikey=bef13086-2418-4e93-bac9-45e709948f50" type="text/javascript"></script>  
    <script src="{{ asset('js/register.js') }}" type="text/javascript"></script>  <!-- Подключение JavaScript файла -->
</head>
<body>
    @include('components.header-seller')   

<div class="header">
    <a href="{{ route('login') }}">Есть аккаунт? Войти</a>
</div>

<div class="container">
    <h2>Регистрация</h2>

    <form id="registerForm" method="POST" action="{{ route('register') }}">
        @csrf
        
        <!-- Выбор роли: клиент или продавец -->
        <div>
            <label>
                <input type="radio" name="user_status" value="0" checked> Клиент
            </label>
            <label>
                <input type="radio" name="user_status" value="1"> Продавец
            </label>
        </div>
        
        <!-- Поле для имени пользователя -->
        <input type="text" name="username" id="usernameInput" placeholder="Название компании" required><br>
        
        <!-- Поле для email -->
        <input type="email" name="email" placeholder="Email" required><br>
        
        <div class="password-container">
            <!-- Поле для пароля -->
            <input type="password" name="password" id="passwordInput" placeholder="Пароль" required>
            <span class="toggle-password" onclick="togglePasswordVisibility('passwordInput', 'confirmPasswordInput', this)">
                <img src="images/close_password.png" alt="Показать" class="password-icon">
            </span>
        </div>
        
        <!-- Поле для подтверждения пароля -->
        <input type="password" name="password_confirmation" id="confirmPasswordInput" placeholder="Повторите пароль" required><br>
        
        <!-- Поле для телефона -->
        <input type="text" id="phoneInput" name="phone" placeholder="Телефон (7XXXXXXXXXX)" required maxlength="19"><br>

        <!-- Поле для города с автозаполнением -->
        <input type="text" id="cityInput" name="city" placeholder="Введите город" required autocomplete="off"><br>
        <div id="citySuggestions" style="border: 1px solid #ccc; display: none;"></div>

        <!-- Поле для адреса с автозаполнением -->
        <input type="text" id="addressInput" name="address_line" placeholder="Введите адрес" required><br>

        <!-- Чекбокс для согласия с офертой -->
        <div>
            <input type="checkbox" id="agree" name="agree" required>
            <label for="agree">
                Я прочитал и согласен с <a href="{{ url('/oferta') }}" target="_blank" style="color: blue; text-decoration: underline;">офертой</a>
            </label>
        </div>
        <p id="agreementError" style="color: red; display: none;">Подтвердите, что ознакомлены и согласны с офертой.</p>

        <!-- Обработка ошибок валидации -->
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <button type="submit">Зарегистрироваться</button>
    </form>

    <p>После регистрации вам будет отправлено письмо для подтверждения почты.</p>
</div>

<script>
    // Функция для изменения placeholder в зависимости от выбранной роли
    function updatePlaceholder() {
        const usernameInput = document.getElementById('usernameInput');
        const clientRadio = document.querySelector('input[name="user_status"][value="0"]');
        const sellerRadio = document.querySelector('input[name="user_status"][value="1"]');

        if (clientRadio.checked) {
            usernameInput.placeholder = 'Ваше имя';
        } else if (sellerRadio.checked) {
            usernameInput.placeholder = 'Название компании';
        }
    }

    // Добавляем обработчик события change на радиокнопки
    document.querySelectorAll('input[name="user_status"]').forEach(radio => {
        radio.addEventListener('change', updatePlaceholder);
    });

    // Инициализация placeholder при загрузке страницы
    updatePlaceholder();
</script>

</body>
</html>