<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Анализ рынка</title>
    <link rel="stylesheet" href="{{ asset('css/search-form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adverts-index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/market.css') }}">
   
</head>
<body>
@include('components.header-seller')

<div class="container">
    <h2>Анализ рынка</h2>
    <div class="ad-list">
        <form id="searchForm" action="{{ route('market.analysis') }}" method="GET">
            <div class="form-group">
                <input type="text" class="form-control" id="part_name_or_number" name="part_name_or_number" placeholder="Введите название или номер детали" value="{{ $productName ?? '' }}">
            </div>

            <div class="form-group">
                <input type="text" class="form-control" id="brand" name="brand" placeholder="Введите марку" value="{{ $brand ?? '' }}">
            </div>

            <button type="submit" class="btn btn-primary">Поиск</button>
        </form>
    </div>

    @if(isset($productName) && isset($brand))
        <!-- Ссылка с якорем для перемещения на блок статистики -->
        <a href="#statistic" class="btn btn-secondary mb-3">Перейти к статистике цен</a>

        @if(isset($userAdverts) && $userAdverts->count() > 0)
            <h4>Мои товары</h4>
            @foreach($userAdverts as $advert)
                <div class="advert-block" onclick="location.href='{{ route('adverts.show', $advert->id) }}'" tabindex="0" role="button">
                    <div class="advert-details">
                        <!-- Вывод главного фото -->
                        @if ($advert->main_photo_url)
                            <img src="{{ $advert->main_photo_url }}" alt="{{ $advert->product_name }} - Главное фото" class="advert-main-photo">
                        @endif
                        <div>
                            <strong>ID:</strong> {{ $advert->id }}<br>
                            <strong>Название продукта:</strong> {{ $advert->product_name }}<br>
                            <strong>Цена:</strong> {{ $advert->price }} ₽<br>
                            <strong>Статус:</strong> {{ $advert->status_ad }}<br>
                            <strong>Город:</strong> {{ $advert->user->userAddress->city ?? 'Не указан' }}<br>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>Нет результатов для "{{ $productName }}" и "{{ $brand }}" среди ваших товаров.</p>
        @endif

        @if(isset($competitorAdverts) && $competitorAdverts->count() > 0)
            <h4>Товары конкурентов</h4>
            @foreach($competitorAdverts as $advert)
                <div class="advert-block" onclick="location.href='{{ route('adverts.show', $advert->id) }}'" tabindex="0" role="button">
                    <div class="advert-details">
                        <!-- Вывод главного фото -->
                        @if ($advert->main_photo_url)
                            <img src="{{ $advert->main_photo_url }}" alt="{{ $advert->product_name }} - Главное фото" class="advert-main-photo">
                        @endif
                        <div>
                            <strong>ID:</strong> {{ $advert->id }}<br>
                            <strong>Название продукта:</strong> {{ $advert->product_name }}<br>
                            <strong>Цена:</strong> {{ $advert->price }} ₽<br>
                            <strong>Статус:</strong> {{ $advert->status_ad }}<br>
                            <strong>Город:</strong> {{ $advert->user->userAddress->city ?? 'Не указан' }}<br>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>Нет результатов для "{{ $productName }}" и "{{ $brand }}" среди товаров конкурентов.</p>
        @endif

        @if(isset($minPrice) && isset($maxPrice) && isset($avgPrice))
            <div class="statistic" id="statistic">
                <h3>Статистика цен</h3>
                <p>Минимальная цена: <span class="min-price">{{ $minPrice }} ₽</span></p>
                <p>Средняя цена: <span class="avg-price">{{ $avgPrice }} ₽</span></p>
                <p>Максимальная цена: <span class="max-price">{{ $maxPrice }} ₽</span></p>
            </div>
        @endif
    @endif
</div>

@extends('layouts.app')

@section('content')
    <!-- Здесь можно добавить дополнительный контент для страницы анализа рынка -->
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Проверяем, есть ли результаты поиска на странице
        const filteredAdverts = document.querySelector('.container h3:first-of-type');

        if (filteredAdverts) {
            // Сброс значений полей формы после вывода результатов поиска
            document.getElementById('part_name_or_number').value = '';
            document.getElementById('brand').value = '';
        }

        // Плавный скролл по якорю
        const links = document.querySelectorAll('a[href^="#"]');
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>
</body>
</html>