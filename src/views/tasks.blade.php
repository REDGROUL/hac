@include('header')
<link rel="stylesheet" href="../src/views/css/dragula.min.css">
<?
$dm = new \App\Models\DepartmentModel();
$departs = $dm->getAllDerartments();
var_dump($_SESSION);

?>
<div class="container py-5">
    @if($_SESSION['role'] == '1')
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h3 class="card-title h5 mb-1">
                    Выбор отдела
                </h3>
            </div>

            <div class="card-body">



                <ul class="list-group">
                    @foreach($departs as $dep)
                    <li class="list-group-item"><a href="/tasks/{{$dep['id']}}">{{$dep['dep_name']}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

    @endif

        <div class="card mb-3">
            <div class="card-header bg-light">
                <h3 class="card-title h5 mb-1">

                    @if(isset($curent_dep))
                    {{$departs[$curent_dep]['dep_name']}}
                    @else
                    {{$departs[$_SESSION['dep']]['dep_name']}}
                    @endif
                </h3>
            </div>
        </div>

    <div class="row">
    @foreach($boards as $board)

        <!-- Start lane -->
            <div class=" col-lg-3">
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h3 class="card-title h5 mb-1">
                            {{$board['name']}}
                        </h3>
                        <small class="mb-0 text-muted">
                            {{$board['description']}}
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="tasks" id="{{$board['id']}}">
                            <!-- Start task -->

                            @foreach($tasks as $task)
                                @if($task['kanban_id'] == $board['id'])

                                    <div class="card mb-3 cursor-grab task" id="{{$task['id']}}">
                                        <div class="card-body">
                                            <img class="card-img-top"
                                                 src="/{{$task['task_photo']}}"
                                                 alt="Bootstrap Kanban Board"/>
                                            <h5 class="mb-2"><a href="/task/{{$task['id']}}">{{$task['name']}}</a></h5>


                                            <div class="text-right">
                                                Описание: {{$task['description']}}
                                            </div>

                                            <div class="text-right">
                                                Отдел: {{$departs[$task['dep_id']]['name']}}
                                            </div>
                                            <div class="text-right">
                                                Назначил: {{$users[$task['owner_id']]['name']}}
                                            </div>
                                            <div class="text-right">
                                                Ответственный: {{$users[$task['worker_id']]['name']}}
                                            </div>
                                            <div class="text-right">
                                                Открыта: {{$task['date_open']}}
                                            </div>

                                            <div class="text-right">
                                                Дата: {{$task['date']}}
                                            </div>


                                            <div class="text-right" id="task-status">
                                                <span class="badge bg-{{$task['status']['color']}} text-white mb-2"> {{$task['status']['name']}}</span>
                                            </div>

                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="btn btn-primary btn-block addTask" id="btn_board_id_{{$board['id']}}">Новая задача
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
</div>


<div class="modal" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавление задачи</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Форма для ввода данных -->
                <form id="newTaskForm" method="POST" enctype="multipart/form-data">
                    <div>
                        <input hidden name="kanban_id" id="modal_board_id">
                        <input hidden name = "owner_id" id="modal_owner_id">


                        <div class="mb-3">
                            <label for="title" class="form-label">Название</label>
                            <input type="text" name="name" class="form-control" id="title" placeholder="Введите название">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Описание</label>
                            <textarea class="form-control" name="description" id="description" rows="3"
                                      placeholder="Введите описание"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="worker" class="form-label">Отдел</label>
                            <select class="form-select" name="dep_id" id="dep_id" aria-label="Выберите язык">
                                <option value="0" selected>Выберите отдел</option>
                                @foreach($departs as $dep)
                                    <option value="{{$dep['id']}}">{{$dep['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="worker" class="form-label">Ответственный за выполнение</label>
                            <select class="form-select" name="worker_id" id="worker" aria-label="Выберите язык">
                                <option value="">Нужно выбрать отдел</option>
{{--                                @foreach($users as $user)--}}
{{--                                    <option value="user_{{$user['id']}}">{{$user['name']}}</option>--}}
{{--                                @endforeach--}}
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="date"  class="form-label">Число и время сдачи</label>
                            <input type="datetime-local" name="date" class="form-control" id="date" rows="3"
                                   placeholder="Введите описание"/>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Статус</label>

                            <select class="form-select" name="status" id="status" aria-label="Выберите язык">
                                @foreach($statuses as $status)
                                    <option value="{{$status['id']}}">{{$status['name']}}</option>

                                @endforeach

                            </select>
                        </div>

                        <div class="input-group">

                            <label class="input-group-text" for="fileInput">Фото</label>
                            <input type="file" name="file" class="form-control" id="fileInput">
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary " id="saveTask" data-bs-dismiss="modal">Сохранить</button>
            </div>
        </div>
    </div>
</div>


<script src="../src/views/js/dragula.min.js"></script>
<script>



    dragula([
        @foreach($boards as $board)
        document.getElementById('{{$board["id"]}}'),
        @endforeach]).on('drag', function (el) {

    }).on('drop', function (el) {


        console.log(el.id);
        console.log(el.parentElement.id);

        let resp = JSON.stringify({
            "type": "changeStatus",
            "taskId": el.id,
            "kanban_id": el.parentElement.id
        });
        ShowNotify("Менеджер задач", "Меняем статус задачи");

        fetch('/tasks/changeStatus', {
            method: 'POST',
            body: resp,

        })
            .then(response => response.text())

            .then(data => {


                console.log(data);


                ShowNotify("Менеджер задач", "Изменение статуса задачи прошло успешно!", 'success');

            })
            .catch(error => {
                console.log(error);
            })
    });

    let workerlist = document.getElementById("worker");
    let dep_id = document.getElementById("dep_id");

    dep_id.addEventListener('change', ()=>{
        workerlist.innerHTML = `\`<option value="" selected>Загружаем выбранный отдел</option>\``;


       // ShowNotify("Менеджер задач", "Меняем статус задачи");
        ShowNotify("Менеджер пользователей", "Получаем данные по отделу", 'warning')
        fetch('/getUserByDep/'+dep_id.value)

            .then(response => response.json())

            .then(data => {
                workerlist.innerHTML = '';
                let dt = Object.keys(data)
                console.log(dt);
                dt.forEach((usr)=>{
                    console.log(data[usr].name);
                    workerlist.innerHTML+=`<option value="user_${data[usr].id}">${data[usr].name}</option>`;

                })

                //ShowNotify("Менеджер задач", "Изменение статуса задачи прошло успешно!", 'success');

            })
            .catch(error => {
                console.log(error);
            })

    })


</script>
<script src="../src/views/js/tasks.js"></script>


@include('footer')