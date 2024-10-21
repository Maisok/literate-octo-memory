<!-- resources/views/footer.blade.php -->
<div class="footer">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}"> <!-- Подключение основного CSS-файла -->
    
    <div class="logo2" style="float: left;">
        <a href="{{ \App\Helpers\UrlHelper::generateUrlWithCity('adverts.index', null, request()->get('city')) }}">
                        <span style="font-size: 1.3em;">ГдеЗапчасть.рф</span>
        </a>
        <div class="container">
            <p>&copy; {{ date('Y') }} Все права защищены.</p>
        </div>
    </div>
    <a href="{{ route('about') }}">О проекте</a>
    <a href="{{ route('oferta') }}">Оферта</a>    
    <a href="{{ route('franchise.index') }}">Франшиза</a> 
    <a href="{{ route('help.index') }}">Справка</a>
</div>