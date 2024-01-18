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
                    <img src= "{{$userData['photo']}}" class="mr-3 align-self-start profile-pic-mini" alt="Фото профиля" width="64" height="64">
                @endif

                <div class="card-body">
                    <h5 class="card-title">{{$userData['name']}}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Панель редактирования</h5>
                    <!-- Добавьте элементы управления для редактирования профиля здесь -->
                </div>
            </div>
        </div>
    </div>


    <div class="card margins">
        <div class="card-body">
         <h4>Список задач:</h4>
    </div>
    </div>

    @foreach($tasks as $task)


    <div class="card comment_card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                   Название: {{$task['name']}}
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

                    <a href="/task/{{$task['id']}}">К задаче</a>
                </div>
            </div>




        </div>
    </div>
    @endforeach
</div>
@include('footer')
