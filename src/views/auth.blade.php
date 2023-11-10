@include('header')
<form id="loginForm">
    <h2>Авторизация</h2>
    <label for="loginUsername">Имя пользователя:</label>
    <input type="text" id="loginUsername" name="login" required>

    <label for="loginPassword">Пароль:</label>
    <input type="password" id="loginPassword" name="pass" required>

    <button type="button" id="login">Войти</button>
</form>

@include('footer')