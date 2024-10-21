@extends('layouts.app')
@include('components.header-seller')
@section('content')
<div class="container">
    <h4>Настройки конвертера</h4>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h5>Выберите марки автомобилей которые есть в Вашем прайс-листе</h5>

    <form action="{{ route('converter_set.update') }}" method="POST">
        @csrf
        @method('PUT')

        @foreach ([
            'acura',
            'alfa_romeo',
            'asia',
            'aston_martin',
            'audi',
            'bentley',
            'bmw',
            'byd',
            'cadillac',
            'changan',
            'chevrolet',
            'citroen',
            'daewoo',
            'daihatsu',
            'datsun',
            'fiat',
            'ford',
            'gaz',
            'geely',
            'haval',
            'honda',
            'hyundai',
            'infiniti',
            'isuzu',
            'jaguar',
            'jeep',
            'kia',
            'lada',
            'land_rover',
            'mazda',
            'mercedes_benz',
            'mitsubishi',
            'nissan',
            'opel',
            'peugeot',
            'peugeot_lnonum',
            'porsche',
            'renault',
            'skoda',
            'ssangyong',
            'subaru', 
            'suzuki', 
            'toyota', 
            'uaz', 
            'volkswagen', 
            'volvo', 
            'zaz'

        ] as $brand)
            <div class="form-check">
                <input type="hidden" name="{{ $brand }}" value="0">
                <input class="form-check-input" type="checkbox" name="{{ $brand }}" id="{{ $brand }}" value="1" {{ isset($converterSet) && $converterSet->$brand ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $brand }}">{{ ucfirst(str_replace('_', ' ', $brand)) }}</label>
            </div>
        @endforeach
<!-- Поля для ввода текстовых значений -->
<h5>Введите названия столбцов Вашего прайс-листа. Названия столбцов которых нет в Вашем прайс-листе оставте пустыми </h5>
<div class="form-group">
    <label for="product_name">Название продукта</label>
    <input type="text" class="form-control" name="product_name" id="product_name" value="{{ old('product_name', $converterSet->product_name ?? '') }}">
</div>

<div class="form-group">
    <label for="price">Цена</label>
    <input type="text" class="form-control" name="price" id="price" value="{{ old('price', $converterSet->price ?? '') }}">
</div>

<div class="form-group">
    <label for="car_brand">Марка автомобиля</label>
    <input type="text" class="form-control" name="car_brand" id="car_brand" value="{{ old('car_brand', $converterSet->car_brand ?? '') }}">
</div>

<div class="form-group">
    <label for="car_model">Модель автомобиля</label>
    <input type="text" class="form-control" name="car_model" id="car_model" value="{{ old('car_model', $converterSet->car_model ?? '') }}">
</div>

<div class="form-group">
    <label for="year">Год</label>
    <input type="text" class="form-control" name="year" id="year" value="{{ old('year', $converterSet->year ?? '') }}">
</div>

<div class="form-group">
    <label for="oem_number">OEM номер</label>
    <input type="text" class="form-control" name="oem_number" id="oem_number" value="{{ old('oem_number', $converterSet->oem_number ?? '') }}">
</div>

<div class="form-group">
    <label for="picture">Изображение</label>
    <input type="text" class="form-control" name="picture" id="picture" value="{{ old('picture', $converterSet->picture ?? '') }}">
</div>

<div class="form-group">
    <label for="body">Кузов</label>
    <input type="text" class="form-control" name="body" id="body" value="{{ old('body', $converterSet->body ?? '') }}">
</div>

<div class="form-group">
    <label for="engine">Двигатель</label>
    <input type="text" class="form-control" name="engine" id="engine" value="{{ old('engine', $converterSet->engine ?? '') }}">
</div>

<div class="form-group">
    <label for="quantity">Количество</label>
    <input type="text" class="form-control" name="quantity" id="quantity" value="{{ old('quantity', $converterSet->quantity ?? '') }}">
</div>

<div class="form-group">
    <label for="text_declaration">Текст декларации</label>
    <input type="text" class="form-control" name="text_declaration" id="text_declaration" value="{{ old('text_declaration', $converterSet->text_declaration ?? '') }}">
</div>

<div class="form-group">
    <label for="left_right">Лево/Право</label>
    <input type="text" class="form-control" name="left_right" id="left_right" value="{{ old('left_right', $converterSet->left_right ?? '') }}">
</div>

<div class="form-group">
    <label for="up_down">Вверх/Вниз</label>
    <input type="text" class="form-control" name="up_down" id="up_down" value="{{ old('up_down', $converterSet->up_down ?? '') }}">
</div>

<div class="form-group">
    <label for="front_back">Вперед/Назад</label>
    <input type="text" class="form-control" name="front_back" id="front_back" value="{{ old('front_back', $converterSet->front_back ?? '') }}">
</div>

<div class="form-group">
    <label for="fileformat_col">Формат файла</label>
    <input type="text" class="form-control" name="fileformat_col" id="fileformat_col" value="{{ old('fileformat_col', $converterSet->fileformat_col ?? '') }}">
</div>

<div class="form-group">
    <label for="encoding">Кодировка</label>
    <input type="text" class="form-control" name="encoding" id="encoding" value="{{ old('encoding', $converterSet->encoding ?? '') }}">
</div>


<div class="form-group">
    <label for="art_number">Артикул</label>
    <input type="text" class="form-control" name="art_number" id="art_number" value="{{ old('art_number', $converterSet->art_number ?? '') }}">
</div>

<div class="form-group">
    <label for="availability">Наличие</label>
    <input type="text" class="form-control" name="availability" id="availability" value="{{ old('availability', $converterSet->availability ?? '') }}">
</div>


<div class= "form-group ">
    <label for= "color ">Цвет</label>
    <input type= "text "class= "form-control "name= "color "id= "color "value= "{{ old ('color ', $converterSet -> color ?? '')}}">
</div>

<div class= "form-group ">
    <label for= "delivery_time ">Время доставки</label>
    <input type= "text "class= "form-control "name= "delivery_time "id= "delivery_time "value= "{{ old ('delivery_time ', $converterSet -> delivery_time ?? '')}}">
</div>

<div class= "form-group ">
    <label for= "new_used ">Новое/Б/У</label>
    <input type= "text "class= "form-control "name= "new_used "id= "new_used "value= "{{ old ('new_used ', $converterSet -> new_used ?? '')}}">
</div>

<h5>Параметры файла </h5>


<div class="form-group">
    <label for="file_price">Адрес файла</label>
    <input type="text" class="form-control" name="file_price" id="file_price" value="{{ old('file_price', $converterSet->file_price ?? '') }}">
</div>

<div class="form-group">
    <label for="my_file">Мой файл</label>
    <input type="text" class="form-control" name="my_file" id="my_file" value="{{ old('my_file', $converterSet->my_file ?? '') }}">
</div>

<div class="form-group">
    <label for="header_str_col">Строка заголовка (начасть с [строки])</label>
    <input type="text" class="form-control" name="header_str_col" id="header_str_col" value="{{ old('header_str_col', $converterSet->header_str_col ?? '') }}">
</div>

<div class="form-group">
    <label for="separator_col">Разделитель колонок</label>
    <input type="text" class="form-control" name="separator_col" id="separator_col" value="{{ old('separator_col', $converterSet->separator_col ?? '') }}">
</div>

<div class="form-group">
    <label for="del_duplicate">Удалить дубликаты</label>
    <input type="text" class="form-control" name="del_duplicate" id="del_duplicate" value="{{ old('del_duplicate', $converterSet->del_duplicate ?? '') }}">
</div>

<div class= "form-group ">
    <label for= "many_pages_col ">Файл содержит несколько листов (книга Excel)</label>
    <input type= "text "class= "form-control "name= "many_pages_col "id= "many_pages_col "value= "{{ old ('many_pages_col ', $converterSet -> many_pages_col ?? '')}}">
</div>



        <button type="submit" class="btn btn-primary">Сохранить настройки</button>
    </form>
</div>
@endsection
