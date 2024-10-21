<script src="{{ asset('js/header.js') }}" defer></script>

<script>
    const baseUrl = '{{ url()->current() }}'; // Передаем текущий URL в JavaScript
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
 
<link rel="stylesheet" href="{{ asset('css/header.css') }}"> <!-- Подключение CSS-файла -->
<div class="header">
    <div class="logo" style="float: left;">
        <a href="{{ \App\Helpers\UrlHelper::generateUrlWithCity('adverts.index', null, request()->get('city')) }}">
            @if(auth()->check() && auth()->user()->user_status == 1 && auth()->user()->logo_url)
                <img src="{{ auth()->user()->logo_url }}" alt="Логотип" class="logourl">
            @else
                <span style="font-size: 1.3em;">Где</span><strong>Запчасть</strong><span style="font-size: 1.3em;">.</span><strong>рф</strong>
            @endif
        </a>
    </div>

    <div class="city-selector">
        <select id="city" name="city" onchange="updateCitySelection()">
            <option value="">Все города</option> <!-- Добавлено значение "Все города" -->
            <!-- Здесь будут добавлены города через JavaScript -->
        </select>
   
        @if(auth()->check())
            <a href="{{ \App\Helpers\UrlHelper::generateUrlWithCity('user.show', auth()->user()->id, request()->get('city')) }}">Профиль</a>
            <a href="{{ \App\Helpers\UrlHelper::generateUrlWithCity('chats.index', null, request()->get('city')) }}" class="btn btn-secondary">Сообщения</a>

            @if(auth()->user()->user_status == 0)
                <a href="{{ \App\Helpers\UrlHelper::generateUrlWithCity('adverts.viewed', null, request()->get('city')) }}">Вы посмотрели</a>
                <a href="{{ \App\Helpers\UrlHelper::generateUrlWithCity('adverts.favorites', null, request()->get('city')) }}">Избранное</a>
            @else
                @if(auth()->user()->user_status != 2)
                    <a href="{{ \App\Helpers\UrlHelper::generateUrlWithCity('adverts.create', null, request()->get('city')) }}">Разместить товары</a>
                    <a href="{{ \App\Helpers\UrlHelper::generateUrlWithCity('adverts.my_adverts', null, request()->get('city')) }}">Мои товары</a>
                @endif
            @endif

            @if(auth()->user()->is_seller)
                <!-- Здесь можно добавить ссылки или элементы для продавца -->
            @endif

            <!-- Кнопка "Выйти" для авторизованных пользователей -->
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Выйти</button>
            </form>
        @else
            <!-- Кнопка "Войти" для незарегистрированных пользователей -->
            <a href="{{ route('login') }}" class="btn btn-primary">Войти</a>
        @endif
    </div>
</div>