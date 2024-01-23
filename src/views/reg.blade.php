@include('header')
<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Регистрация пользователя</div>
                <div class="logo">
                    <?
                    $dm = new \App\Models\DepartmentModel();
                    $departs = $dm->getAllDerartments();

                    $rm = new \App\Models\RoleModel();
                    $roles = $rm->getAllRoles();
                    ?>
                </div>
                <h2></h2>
                <div class="card-body">

                    <div class="mb-3">
                        <label for="fio" class="form-label">ФИО</label>
                        <input type="text" class="form-control" id="fio" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="loginUsername" class="form-label">Логин</label>
                        <input type="text" class="form-control" id="loginUsername" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label">Пароль</label>
                        <input type="text" class="form-control" id="pass" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="worker" class="form-label">Отдел</label>
                        <select class="form-select" name="dep_id" id="dep" aria-label="Выберите язык">
                            @foreach($departs as $dep)
                                <option value="{{$dep['id']}}">{{$dep['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Права</label>
                        <select class="form-select" name="role_id" id="role" aria-label="Выберите язык">
                            @foreach($roles as $role)
                                <option value="{{$role['id']}}">{{$role['name']}}</option>
                            @endforeach
                        </select>
                    </div>



                    <div class="text-center">
                        <button type="submit" id="reg" class="btn btn-primary">Регистрация</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let btnReg = document.getElementById("reg");
    btnReg.addEventListener('click', ()=>{
        let fio = document.getElementById("fio").value;
        let login = document.getElementById("loginUsername").value;
        let pass = document.getElementById("pass").value;
        let dep = document.getElementById("dep").value;
        let role = document.getElementById("role").value;

        let resp = JSON.stringify({

            "name": fio,
            "pass": pass,
            "login": login,
            "dep":dep,
            "role":role
        });
        ShowNotify("Менеджер пользователей", "Отправляем данные");
        fetch('/addUser',{
            method: 'POST',
            body: resp,

        })

            .then(response=>response.json())

            .then(data=>{
                if(data.status == "ok") {

                    ShowNotify("Менеджер пользователей", "Регистрация успешна", "success");

                } else {
                    console.log(data)
                    ShowNotify("Менеджер пользователей", "Возможно такой логин уже есть", 'danger');
                }

            })
            .catch(error=>{
                console.log(error);
                ShowNotify("Ошибка", error, 'danger');
            })
    })

</script>


@include('footer')
