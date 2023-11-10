<?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<form id="loginForm">
    <h2>Авторизация</h2>
    <label for="loginUsername">Имя пользователя:</label>
    <input type="text" id="loginUsername" name="login" required>

    <label for="loginPassword">Пароль:</label>
    <input type="password" id="loginPassword" name="pass" required>

    <button type="button" id="login">Войти</button>
</form>

<?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\hac2\src\views/auth.blade.php ENDPATH**/ ?>