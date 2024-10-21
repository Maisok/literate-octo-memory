@extends('layouts.app')
@include('components.header-seller')   
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script>

@section('content')
<link rel="stylesheet" href="{{ asset('css/adverts-create.css') }}"> <!-- Подключение основного CSS-файла -->

<div class="container2">
    <h1>Как вы хотите добавить товары?</h1>

    <button class="button" onclick="scrollToForm()" onmouseover="showText('Создавайте товар заполняя форму')" onmouseout="hideText()">Создать товар с помощью формы</button>
    <button class="button" onclick="scrollToForm2()" onmouseover="showText('Если у Вас есть правйс-лист Вы можете загрузить все ваши товары используя функцию импорта')" onmouseout="hideText()">Загрузить товары из прайс-листа</button>
    
    <p id="hoverText" style="display: none;"></p>
</div>

<div class="container" id="create-product-form">
    <h2>Создать новый товар с помощью формы</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('adverts.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="art_number">Артикул</label>
            <input type="text" class="form-control" id="art_number" name="art_number">
        </div>

        <div class="form-group">
            <label for="product_name">Название товара</label>
            <input type="text" class="form-control" id="product_name" name="product_name">
        </div>

        <div class="form-group">
            <label for="number">Номер детали</label>
            <input type="text" class="form-control" id="number" name="number">
        </div>

        <div class="form-group">
            <label for="new_used">Состояние</label>
            <select class="form-control" id="new_used" name="new_used">
                <option value="new">Новый</option>
                <option value="used">Б/У</option>
            </select>
        </div>

        <select id="brand" name="brand" data-url="{{ route('get.models') }}">
            <option value="">Выберите марку</option>
            @foreach(App\Models\BaseAvto::distinct()->pluck('brand') as $brand)
                <option value="{{ $brand }}" {{ request()->get('brand') == $brand ? 'selected' : '' }}>
                    {{ $brand }}
                </option>
            @endforeach
        </select>
        <select id="model" name="model">
            <option value="">Выберите модель</option>
            @if(request()->get('brand')) 
                @foreach(App\Models\BaseAvto::where('brand', request()->get('brand'))->distinct()->pluck('model') as $model)
                    <option value="{{ $model }}" {{ request()->get('model') == $model ? 'selected' : '' }}>
                        {{ $model }}
                    </option>
                @endforeach
            @endif
        </select>
        <select id="year" name="year">
            <option value="">Выберите год выпуска</option>
            @for($i = 2000; $i <= date('Y'); $i++)
                <option value="{{ $i }}" {{ request()->get('year') == $i ? 'selected' : '' }}>
                    {{ $i }}
                </option>
            @endfor
        </select>

        <div class="form-group">
            <label for="body">Модель Кузова</label>
            <input type="text" class="form-control" id="body" name="body">
        </div>

        <div class="form-group">
            <label for="engine">Модель Двигателя</label>
            <input type="text" class="form-control" id="engine" name="engine">
        </div>

        <div class="form-group">
            <label for="L_R">Слева/Справа</label>
            <select class="form-control" id="L_R" name="L_R">
                <option value="">Выберите раположение</option>
                <option value="Слева">Слева (L)</option>
                <option value="Справа">Справа (R)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="F_R">Спереди/Сзади</label>
            <select class="form-control" id="F_R" name="F_R">
                <option value="">Выберите раположение</option>
                <option value="Спереди">Спереди (F)</option>
                <option value="Сзади">Сзади (R)</option>
            </select>        
        </div>

        <div class="form-group">
            <label for="U_D">Сверху/Снизу</label>
            <select class="form-control" id="U_D" name="U_D">
                <option value="">Выберите раположение</option>
                <option value="Сверху">Сверху (U)</option>
                <option value="Снизу">Снизу (D)</option>
            </select>         
        </div>

        <div class="form-group">
            <label for="color">Цвет</label>
            <input type="text" class="form-control" id="color" name="color">
        </div>

        <div class="form-group">
            <label for="applicability">Применимость</label>
            <input type="text" class="form-control" id="applicability" name="applicability">
        </div>

        <div class="form-group">
            <label for="quantity">Количество</label>
            <input type="number" class="form-control" id="quantity" name="quantity" min="1">
        </div>

        <div class="form-group">
            <label for="price">Цена</label>
            <input type="text" class="form-control" id="price" name="price" min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>

        <div class="form-group">
            <label for="availability">Наличие</label>
            <select class="form-control" id="availability" name="availability">
                <option value="1">В наличии</option>
                <option value="0">Нет в наличии</option>
            </select>
        </div>

        <!-- Добавление полей для URL фотографий -->
        <div class="form-group">
            <label for="main_photo_url">Основное фото (URL)</label>
            <input type="text" class="form-control" id="main_photo_url" name="main_photo_url">
        </div>

        <div class="form-group">
            <label for="additional_photo_url_1">Дополнительное фото 1 (URL)</label>
            <input type="text" class="form-control" id="additional_photo_url_1" name="additional_photo_url_1">
        </div>

        <div class="form-group">
            <label for="additional_photo_url_2">Дополнительное фото 2 (URL)</label>
            <input type="text" class="form-control" id="additional_photo_url_2" name="additional_photo_url_2">
        </div>

        <div class="form-group">
            <label for="additional_photo_url_3">Дополнительное фото 3 (URL)</label>
            <input type="text" class="form-control" id="additional_photo_url_3" name="additional_photo_url_3">
        </div>

        <button type="submit" class="btn btn-primary">Создать товар</button>
    </form>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/search-form.js') }}" defer></script>