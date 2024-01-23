@include('header')

<style>
    html, body {
        height: 100%;
    }

</style>
<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Авторизация в Awesome kanban</div>
                <h2></h2>
                <div class="card-body">

                        <div class="mb-3">
                            <label for="loginUsername" class="form-label">Имя пользователя</label>
                            <input type="text" class="form-control" id="loginUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Пароль</label>
                            <input type="password" class="form-control" id="loginPassword" name="password" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" id="login" class="btn btn-primary">Войти</button>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .chat-container {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
</style>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="chat-container">
                <h2 class="text-center">Чат</h2>
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Введите сообщение">
                        <button class="btn btn-primary">Отправить</button>
                    </div>
                </div>
                <div class="chat-messages">
                    <!-- Здесь будут отображаться сообщения чата -->
                </div>
            </div>
        </div>
    </div>
</div>
{{--<div class="container mt-5" id="cont">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-6">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">Вход</div>--}}
{{--                <div class="card-body">--}}
{{--                    <form>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="loginUsername">Логин</label>--}}
{{--                            <input type="text" class="form-control" id="loginUsername" placeholder="Введите логин">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="loginPassword">Пароль</label>--}}
{{--                            <input type="password" class="form-control" id="loginPassword" placeholder="Введите пароль">--}}
{{--                        </div>--}}

{{--                    </form>--}}

{{--                    <button  id="login" class="btn btn-primary">Войти</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<script src="../src/views/js/login.js"></script>
{{--<div>--}}
{{--<form id="loginForm">--}}
{{--    <h2>Авторизация</h2>--}}
{{--    <label for="loginUsername">Имя пользователя:</label>--}}
{{--    <input type="text" id="loginUsername" name="login" required>--}}

{{--    <label for="loginPassword">Пароль:</label>--}}
{{--    <input type="password" id="loginPassword" name="pass" required>--}}

{{--    <button type="button" id="login">Войти</button>--}}
{{--</form>--}}
{{--</div>--}}
@include('footer')