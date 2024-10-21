<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пользователя</title>
</head>
<body>
@include('components.header-seller')

    <h2>Профиль пользователя</h2>
    
    <!-- profile.blade.php -->
<div id="user-profile">
    @if($user->avatar_url)
        <img src="{{ $user->avatar_url }}" alt="Аватар пользователя" class="ava">
    @else
        <p>Аватар не задан.</p>
    @endif

    <p><strong>Имя пользователя:</strong> {{ $user->username }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>

    @if($user->UserAddress)
        <p><strong>Город:</strong> {{ $user->UserAddress->city }}</p>
        <p><strong>Улица:</strong> {{ $user->UserAddress->address_line }}</p>
    @else
        <p>Адрес не указан.</p>
    @endif

    @if($user->UserPhoneNumber)
        <p><strong>Номер:</strong> {{ $user->UserPhoneNumber->number_1 }}</p>
    @else
        <p>Номер не указан.</p>
    @endif
    <!-- Добавьте другие поля по необходимости -->
</div>
    @extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('converter_set.edit') }}" class="btn btn-primary">Настройки конвертера</a>
    
    <!-- Добавляем условие для отображения кнопки "Анализ рынка" -->
    @if($user->user_status == 1)
        <a href="{{ route('market.analysis') }}" class="btn btn-primary">Анализ рынка</a>
    @endif
</div>

<!-- Кнопка редактирования профиля -->
<a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary">Редактировать профиль</a>
@if($user->user_status == 1)
        <a href="{{ route('tariff.settings') }}" class="btn btn-primary">Настроить тариф</a>
    @endif
@endsection
</body>
</html>