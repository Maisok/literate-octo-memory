@extends('layouts.app')
@include('components.header-seller')

@section('content')
<div class="container">
    <div class="row">
        @include('components.chat-list', ['userChats' => $userChats]) <!-- Подключаем компонент список чатов -->
        
        <div class="col-md-8">
            <h2>Выберите чат</h2>
            <p>Пожалуйста, выберите чат из списка слева, чтобы начать общение.</p>
        </div>
    </div>
</div>
@endsection