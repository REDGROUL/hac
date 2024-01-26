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


<script src="../src/views/js/login.js"></script>
@include('footer')