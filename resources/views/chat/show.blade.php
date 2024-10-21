@extends('layouts.app')
@include('components.header-seller')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/chat-show.css') }}"> <!-- Подключение основного CSS-файла -->

@section('content')
<div class="container">
    <div class="row">
        @include('components.chat-list', ['userChats' => $userChats]) <!-- Подключаем компонент список чатов -->

        <div class="col-md-9"> <!-- Чат занимает 9 колонок -->
            @if($chat && $advert)
                <h5>
                    <a href="{{ route('advert.show', ['advert' => $advert->id]) }}">
                        {{ $advert->product_name }} <!-- Здесь отображается название объявления -->
                    </a>
                </h5>

                <div id="chat-messages" class="chat-messages" style="border: 1px solid #ccc; padding: 10px; height: 400px; overflow-y: scroll;">
                @foreach($messages as $message)
                    @if(!isset($lastDate) || $lastDate != $message->created_at->toDateString())
                        <div class="message-date">{{ $message->created_at->format('d.m.Y') }}</div>
                        @php
                            $lastDate = $message->created_at->toDateString();
                        @endphp
                    @endif
                    <div class="message @if($message->user_id === auth()->id()) sent @else received @endif">
                        <img src="{{ $message->user->avatar_url }}" alt="Аватар" class="avatar">
                        <div class="message-content">
                            <strong>{{ $message->user->username }}</strong> {{ $message->message }}
                            <span class="text-muted" style="font-size: 0.8em;">{{ $message->created_at->diffForHumans() }}</span>
                            @if($message->user_id !== auth()->id())
                                @if($message->is_read)
                                    <img src="{{ asset('images/messageyes.png') }}" alt="Прочитано" class="status-icon" style="width:15px">
                                @else
                                    <img src="{{ asset('images/messageno.png') }}" alt="Не прочитано" class="status-icon" style="width:15px">
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
                </div>
                
                <form action="{{ route('chat.send', ['chat' => $chat]) }}" method="POST" class="mt-3">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="message" class="form-control" placeholder="Введите сообщение" required>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Отправить</button>
                        </div>
                    </div>
                </form>
            @else
                <p>Выберите чат из списка.</p>
            @endif
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Обработчик отправки формы
    $('form').on('submit', function(e) {
        e.preventDefault(); // Предотвращаем стандартное поведение формы

        var messageInput = $(this).find('input[name="message"]');
        var message = messageInput.val();
        var chatId = '{{ $chat->id }}'; // Получаем ID чата

        $.ajax({
            url: '/chat/' + chatId + '/send',
            type: 'POST',
            data: {
                message: message,
                _token: '{{ csrf_token() }}' // Добавляем CSRF-токен
            },
            success: function(response) {
                // Добавляем новое сообщение в интерфейс
                $('#chat-messages').append('<div class="message sent">' + response.message + ' <span class="text-muted" style="font-size: 0.8em;">just now</span></div>');
                messageInput.val(''); // Очищаем поле ввода
                $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight); // Прокручиваем вниз

                // Отмечаем сообщения как прочитанные
                markMessagesAsRead(chatId);
            },
            error: function(xhr) {
                console.log(xhr.responseText); // Обработка ошибок
            }
        });
    });

    // Функция для отметки сообщений как прочитанных
    function markMessagesAsRead(chatId) {
        $.ajax({
            url: '/chat/' + chatId + '/mark-as-read',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Обновляем статус сообщений в интерфейсе
                $('.message.received').each(function() {
                    var isRead = $(this).find('img.status-icon').attr('src').includes('messageyes.png');
                    if (isRead) {
                        $(this).find('img.status-icon').attr('src', '{{ asset('images/messageyes.png') }}');
                    } else {
                        $(this).find('img.status-icon').attr('src', '{{ asset('images/messageno.png') }}');
                    }
                });
            },
            error: function(xhr) {
                console.log(xhr.responseText); // Обработка ошибок
            }
        });
    }

    // Отмечаем сообщения как прочитанные при загрузке страницы
    markMessagesAsRead('{{ $chat->id }}');

    // Функция для периодической проверки новых сообщений
    function fetchMessages() {
    var chatId = '{{ $chat->id }}'; // Получаем ID чата

    $.ajax({
        url: '/chat/' + chatId + '/messages', // Создайте этот маршрут и метод в контроллере
        type: 'GET',
        success: function(response) {
            $('#chat-messages').empty(); // Очищаем старые сообщения
            var lastDate = null;
            response.messages.forEach(function(message) {
                // Форматируем время с помощью moment.js
                var formattedTime = moment(message.created_at).fromNow();
                var messageDate = moment(message.created_at).format('YYYY-MM-DD');

                // Добавляем дату, если это первое сообщение за день
                if (lastDate !== messageDate) {
                    $('#chat-messages').append('<div class="message-date">' + moment(message.created_at).format('DD.MM.YYYY') + '</div>');
                    lastDate = messageDate;
                }

                // Определяем статус сообщения
                var readStatus = message.is_read ? '<img src="{{ asset('images/messageyes.png') }}" alt="Прочитано" class="status-icon" style="width:15px">' : '<img src="{{ asset('images/messageno.png') }}" alt="Не прочитано" class="status-icon" style="width:15px">';

                // Добавляем сообщение с аватаром и статусом
                $('#chat-messages').append('<div class="message ' + (message.user_id === {{ auth()->id() }} ? 'sent' : 'received') + '">' +
                    '<img src="' + message.user.avatar_url + '" alt="Аватар" class="avatar">' +
                    '<div class="message-content">' +
                        '<strong>' + message.user.username + '</strong> ' + message.message +
                        '<span class="text-muted" style="font-size: 0.8em;">' + formattedTime + '</span>' +
                        (message.user_id !== {{ auth()->id() }} ? readStatus : '') +
                    '</div>' +
                '</div>');
            });
            $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight); // Прокручиваем вниз

            // Отмечаем сообщения как прочитанные
            markMessagesAsRead(chatId);
        },
        error: function(xhr) {
            console.log(xhr.responseText); // Обработка ошибок
        }
    });
}

    // Запускаем функцию каждые 5 секунд (опционально)
    setInterval(fetchMessages, 5000);

    // Отмечаем сообщения как прочитанные при загрузке страницы
    markMessagesAsRead('{{ $chat->id }}');
});
</script>
@endsection