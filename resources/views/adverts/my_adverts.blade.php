@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/my_adverts.css') }}"> <!-- Подключение основного CSS-файла -->
<script src="{{ asset('js/my_adverts.js') }}" defer></script>
@include('components.header-seller')

<div class="container">
    <!-- Форма поиска -->
    <form method="GET" action="{{ route('adverts.my_adverts') }}" class="search-form">
        <input type="text" name="search" class="searchInput" placeholder="Поиск по наименованию или номеру" value="{{ request()->input('search') }}">
        <select name="brand" class="brandFilter">
            <option value="">Все марки</option>
            @foreach($brands as $brand)
                <option value="{{ $brand }}" {{ request()->input('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-search">Поиск</button>
        <a href="{{ route('adverts.my_adverts') }}" class="btn-reset">Сбросить</a> <!-- Кнопка сброса -->
    </form>

    <!-- Таблица объявлений -->
    @if ($adverts->isEmpty())
        <p>У вас нет активных объявлений.</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>Артикул</th>
                <th>Наименование</th>
                <th>Состояние</th>
                <th>Марка</th>
                <th>Модель</th>
                <th>Кузов</th>
                <th>Номер</th>
                <th>Двигатель</th>
                <th>Год</th>
                <th>L/R</th>
                <th>F/R</th>
                <th>U/D</th>
                <th>Цена</th>
                <th>Цвет</th>
                <th>Применимость/Описание</th>
                <th>Количество</th>
                <th>Наличие</th>
                <th>Время доставки</th>
                <th>Фото</th>
                <th>Действия</th> <!-- Новый столбец для кнопок -->
            </tr>
        </thead>
        <tbody>
            @foreach($adverts as $advert)
            <tr data-id-info="{{ $advert->id }}"
                data-art-number="{{ $advert->art_number }}"
                data-product-name="{{ $advert->product_name }}"
                data-brand-info="{{ $advert->brand }}"
                data-model-info="{{ $advert->model }}"
                data-body-info="{{ $advert->body }}"
                data-number-info="{{ $advert->number }}"
                data-engine-info="{{ $advert->engine }}"
                data-main-photo-url="{{ $advert->main_photo_url }}"
                data-additional-photo-url-1="{{ $advert->additional_photo_url_1 }}"
                data-additional-photo-url-2="{{ $advert->additional_photo_url_2 }}"
                data-additional-photo-url-3="{{ $advert->additional_photo_url_3 }}"
                data-price-info="{{ $advert->price }}">
                <td>{{ $advert->art_number }}</td>
                <td>{{ $advert->product_name }}</td>
                <td>{{ $advert->new_used }}</td>
                <td>{{ $advert->brand }}</td>
                <td>{{ $advert->model }}</td>
                <td>{{ $advert->body }}</td>
                <td>{{ $advert->number }}</td>
                <td>{{ $advert->engine }}</td>
                <td>{{ $advert->year }}</td>
                <td>{{ $advert->L_R }}</td>
                <td>{{ $advert->F_R }}</td>
                <td>{{ $advert->U_D }}</td>
                <td>{{ $advert->price }}</td>
                <td>{{ $advert->color }}</td>
                <td>{{ $advert->applicability }}</td>
                <td>{{ $advert->quantity }}</td>
                <td>{{ $advert->availability }}</td>
                <td>{{ $advert->delivery_time }}</td>
                <td><img src="{{ $advert->main_photo_url }}" alt="Фото" style="width: 50px; height: 50px;"></td>
                <td>
                    <button class="btn btn-primary edit-btn" data-id="{{ $advert->id }}">Редактировать</button>
                    <form action="{{ route('adverts.destroy', $advert->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Подключение пагинации -->
    @include('components.pagination', ['adverts' => $adverts])
    @endif
</div>

<!-- Модальное окно для редактирования -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Редактировать объявление</h2>
        <form id="editForm" action="{{ route('adverts.update') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="editAdvertId" name="id">
            <input type="hidden" id="old_art_number" name="old_art_number">
            <input type="hidden" id="old_product_name" name="old_product_name">
            <input type="hidden" id="old_number" name="old_number">
            <input type="hidden" id="old_new_used" name="old_new_used">
            <input type="hidden" id="old_brand" name="old_brand">
            <input type="hidden" id="old_model" name="old_model">
            <input type="hidden" id="old_year" name="old_year">
            <input type="hidden" id="old_body" name="old_body">
            <input type="hidden" id="old_engine" name="old_engine">
            <input type="hidden" id="old_L_R" name="old_L_R">
            <input type="hidden" id="old_F_R" name="old_F_R">
            <input type="hidden" id="old_U_D" name="old_U_D">
            <input type="hidden" id="old_color" name="old_color">
            <input type="hidden" id="old_applicability" name="old_applicability">
            <input type="hidden" id="old_quantity" name="old_quantity">
            <input type="hidden" id="old_price" name="old_price">
            <input type="hidden" id="old_availability" name="old_availability">
            <input type="hidden" id="old_main_photo_url" name="old_main_photo_url">
            <input type="hidden" id="old_additional_photo_url_1" name="old_additional_photo_url_1">
            <input type="hidden" id="old_additional_photo_url_2" name="old_additional_photo_url_2">
            <input type="hidden" id="old_additional_photo_url_3" name="old_additional_photo_url_3">

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

            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
</div>

<!-- Модальное окно (окно подробностями о товаре) -->
<div id="viewModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-images">
            <img id="modalMainImg" src="" style="width: 400px; height: 400px; object-fit: cover;">
            <div class="additional-images">
                <img id="modalAdditionalImg1" src="" style="width: 100px; height: 100px; object-fit: cover;">
                <img id="modalAdditionalImg2" src="" style="width: 100px; height: 100px; object-fit: cover;">
                <img id="modalAdditionalImg3" src="" style="width: 100px; height: 100px; object-fit: cover;">
            </div>
        </div>
        <p id="modalInfo" style="margin-left: 420px;"></p>
        <div class="addToCartContainer">
            <button id="addToCartBtn">Добавить в корзину</button>
            <p id="cartNotification" style="font-size: 12px;"></p>
        </div>
    </div>
</div>

@endsection