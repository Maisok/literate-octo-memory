@extends('layouts.app')
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Все товары</title>
    <link rel="stylesheet" href="{{ asset('css/adverts-index.css') }}"> <!-- Подключение основного CSS-файла -->
</head>
<body>

@include('components.header-seller')   
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script>

<!-- Рекламный баннер -->
<h1></h1>
<img src="{{ asset('images/banner.png') }}"  alt="Реклама" class="banner">
<p></p>

<h2>Поиск запчастей:</h2>
@include('components.search-form') <!-- Подключение формы поиска -->

<div class="container">        
    @if($adverts->isEmpty())
        <p>Нет доступных объявлений.</p>
    @else
        @php
            // Фильтруем коллекцию, исключая товар с id 1111
            $filteredAdverts = $adverts->reject(function($advert) {
                return $advert->id == 1111;
            });
        @endphp

        @foreach($filteredAdverts as $advert)
    <div class="advert-block" onclick="location.href='{{ route('adverts.show', $advert->id) }}'" tabindex="0" role="button">
        <div class="advert-details">
            <!-- Вывод главного фото -->
            @if ($advert->main_photo_url)
                <img src="{{ $advert->main_photo_url }}" alt="{{ $advert->product_name }} - Главное фото" class="advert-main-photo">
            @else
                <img src="{{ asset('images/dontfoto.jpg') }}" alt="Фото отсутствует" class="advert-main-photo">
            @endif
        </div>

        <div class="list">
            <div class="name">
            <span class="list_name">{{ $advert->product_name }}</span>
            <span class="end" >{{ $advert->price }} ₽</span>
            </div>
               

               <div class="info">
               <span class="beg">{{ $advert->number}}</span>
               <span class="end">{{ $advert->user->userAddress->city ?? 'Не указан' }}</span>
            </div>
             
             <div class="car">
             <span>{{ $advert->brand}}</span>
             <span>{{ $advert->model}}</span>
             <span>{{ $advert->body}}</span>
             <span>{{ $advert->engine}}</span>


             </div>
            </div>
    </div>
@endforeach

        <!-- Подключение пагинации -->
        @include('components.pagination', ['adverts' => $adverts])
    @endif
</div>
</body>
</html>