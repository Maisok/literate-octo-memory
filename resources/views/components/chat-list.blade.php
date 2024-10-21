
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/chat-show.css') }}">
<div class="col-md-3 chat-list"> <!-- Список чатов занимает 3 колонки -->
    <h6>Чаты</h6>
    <ul class="list-group">
        <!-- Отображаем чаты -->
        @foreach($userChats as $userChat)
            <li class="list-group-item chat-item">
                <a href="{{ route('chat.show', ['chat' => $userChat]) }}">
                    <!-- Отображаем аватар пользователя -->
                    <img src="{{ $userChat->user1_id == auth()->id() ? $userChat->user2->avatar_url : $userChat->user1->avatar_url }}" alt="Аватар" class="avatar">
                    <!-- Отображаем имя пользователя жирным черным шрифтом -->
                    <strong>{{ $userChat->user1_id == auth()->id() ? $userChat->user2->username : $userChat->user1->username }}</strong>:
                    <!-- Отображаем текст последнего сообщения -->
                    @if($userChat->last_message)
                        {{ Str::limit($userChat->last_message->message, 20, '...') }}
                    @else
                        Нет сообщений
                    @endif
                    <!-- Отображаем счетчик непрочитанных сообщений -->
                    @if($userChat->unread_count > 0)
                        <span class="badge badge-primary">{{ $userChat->unread_count }}</span>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</div>