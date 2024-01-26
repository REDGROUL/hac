@include('header')

<?
$um = new \App\Models\UserModel();
?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card">

                @if($userData['photo'] == null)
                    <img src="/res/images/nopic.jpg" class="card-img-top" alt="Фото профиля">
                @else
                    <img src="{{$userData['photo']}}" class="mr-3 align-self-start profile-pic-mini" alt="Фото профиля"
                         width="64" height="64">
                @endif
                    <?$dm = new \App\Models\DepartmentModel();
                    $dmName = $dm->getDepartmentNameById($userData['department']);

                    ?>

            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">ФИО: {{$userData['name']}}</h5>
                    <h5 class="card-title">Отдел: {{$dmName['name']}}</h5>
                    <?
                    $rm = new \App\Models\RoleModel();
                    $role = $rm->getRoleById($userData['role']);

                    ?>
                    <h5 class="card-title">Права: {{$role['name']}}</h5>

                </div>
            </div>
            <br>
            @if($_SESSION['uid'] == $userData['id'])
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Панель редактирования</h5>
                        <!-- Добавьте элементы управления для редактирования профиля здесь -->
                    </div>
                </div>
            @endif
        </div>
    </div>

    <br>
    <div class="card mb-3">
        <div class="card-header bg-light">
            <div class="header-task">
                <div class="card-body">
                    <h4>Текущие задачи:</h4>
                </div>
            </div>

            @foreach($tasks as $task)
                <?
                $stm = new \App\Models\TaskStatusModel();
                $status = $stm->getStatusById($task['status']);
                ?>

                <div class="card comment_card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">

                                <h5><a href="/task/{{$task['id']}}">{{$task['name']}}</a></h5>

                                <span class="badge bg-{{$status['color']}} text-white mb-2"> {{$status['name']}}</span>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                Описание: {{$task['description']}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                Время сдачи: {{$task['date']}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <?
                                $owner = $um->getUserById($task['owner_id'])
                                ?>
                                Постановщик: <a href="/profile/{{$owner['id']}}">{{$owner['name']}}</a>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col">
                                <?
                                $worker = $um->getUserById($task['worker_id'])
                                ?>
                                Ответственный: <a href="/profile/{{$worker['id']}}">{{$worker['name']}}</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">


                            </div>
                        </div>


                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@include('footer')
