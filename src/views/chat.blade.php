@include('header')

<style>
    .chat-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .user-list {
        max-height: 400px;
        overflow-y: auto;
        border-right: 1px solid #ccc;
    }

    .message-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .message {
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    .message.sent {
        background-color: #007BFF;
        color: #fff;
        text-align: right;
    }

    .message.received {
        background-color: #f0f0f0;
        text-align: left;
    }
</style>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="chat-container">
                <h2 class="text-center">Пользователи</h2>
                <ul class="list-group user-list">
                    <!-- Здесь будут отображаться пользователи -->
                    <li class="list-group-item">Пользователь 1</li>
                    <li class="list-group-item">Пользователь 2</li>
                    <li class="list-group-item">Пользователь 3</li>
                </ul>
            </div>
        </div>
        <div class="col-md-8">
            <div class="chat-container">
                <h2 class="text-center">Диалог</h2>
                <div class="message-list">
                    <!-- Здесь будут отображаться сообщения -->
                    <div class="message sent">Вы: Привет!</div>
                    <div class="message received">Пользователь 2: Здравствуйте!</div>
                    <div class="message sent">Вы: Как дела?</div>
                    <div class="message received">Пользователь 2: Хорошо, спасибо!</div>
                </div>
                <div class="input-group mt-3">
                    <input type="text" class="form-control" placeholder="Введите сообщение">
                    <button class="btn btn-primary">Отправить</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
     // Замените адрес и порт на ваш веб-сокет сервер


    // Обработчик успешного подключения к серверу

    </script>

@include('footer')
