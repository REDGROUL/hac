@include('header')

<style>
    html, body {
        height: 100%;
    }

</style>
<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="text-center">
                <img src="res/images/big-logo.svg">
            </div>
            <mdui-card class="md-card">
                <h2>Авторизация</h2>

                <div class="card-body">
                    <mdui-text-field class="md-input" variant="outlined" id="loginUsername" name="username"
                                     label="Логин"></mdui-text-field>

                    <mdui-text-field class="md-input" variant="outlined" type="password" id="loginPassword"
                                     name="password" label="Пароль"></mdui-text-field>

                    <div class="text-center">
                        <mdui-button type="submit" id="login">Авторизация</mdui-button>

                    </div>
                </div>
            </mdui-card>
        </div>
    </div>
</div>


<script src="../src/views/js/login.js"></script>
@include('footer')