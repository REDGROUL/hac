@include('header')
<!-- 
.----------------.  .----------------.  .----------------. 
| .--------------. || .--------------. || .--------------. |
| |  ________    | || |     _____    | || |  _________   | |
| | |_   ___ `.  | || |    |_   _|   | || | |_   ___  |  | |
| |   | |   `. \ | || |      | |     | || |   | |_  \_|  | |
| |   | |    | | | || |      | |     | || |   |  _|  _   | |
| |  _| |___.' / | || |     _| |_    | || |  _| |___/ |  | |
| | |________.'  | || |    |_____|   | || | |_________|  | |
| |              | || |              | || |              | |
| '--------------' || '--------------' || '--------------' |
 '----------------'  '----------------'  '----------------' 
  -->


<div class="container mt-5" id="cont">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Вход</div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="loginUsername">Логин</label>
                            <input type="text" class="form-control" id="loginUsername" placeholder="Введите логин">
                        </div>
                        <div class="form-group">
                            <label for="loginPassword">Пароль</label>
                            <input type="password" class="form-control" id="loginPassword" placeholder="Введите пароль">
                        </div>

                    </form>

                    <button  id="login" class="btn btn-primary">Войти</button>
                </div>
            </div>
        </div>
    </div>
</div>
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