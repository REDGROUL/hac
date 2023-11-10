@include('header')
<form id="loginForm">
    <h2>Авторизация</h2>
    <label for="loginUsername">Имя пользователя:</label>
    <input type="text" id="loginUsername" name="loginUsername" required>

    <label for="loginPassword">Пароль:</label>
    <input type="password" id="loginPassword" name="loginPassword" required>

    <button type="button" onclick="login()">Войти</button>
</form>

<script>
    function login() {
        var username = document.getElementById("loginUsername").value;
        var password = document.getElementById("loginPassword").value;
        // Здесь вы можете добавить логику для проверки авторизации
        console.log("Попытка входа:", username, password);
    }
</script>
@include('footer')