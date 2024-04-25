@include('header')
<link rel="stylesheet" href="../src/views/css/dragula.min.css">
<?
$dm = new \App\Models\DepartmentModel();
$departs = $dm->getAllDerartments();
?>
<div class="container py-5">
    @if($_SESSION['role'] == '1')

        <mdui-card variant="elevated" style="width:100%" class="mgp">

            <mdui-list style="background: #ffd9e3">
                <mdui-collapse accordion>
                    <mdui-collapse-item>
                        <mdui-list-item slot="header" icon="near_me">Отделы
                            ( @if(isset($curent_dep))
                                {{$departs[$curent_dep]['name']}}
                            @else
                                {{$departs[$_SESSION['dep']]['name']}}
                            @endif
                            )
                        </mdui-list-item>


                        <div>
                            @foreach($departs as $dep)
                                <mdui-list-item href="/tasks/{{$dep['id']}}">{{$dep['name']}}</mdui-list-item>
                            @endforeach
                        </div>
                    </mdui-collapse-item>
                </mdui-collapse>
            </mdui-list>

        </mdui-card>


    @endif

    <mdui-dialog close-on-esc
                 close-on-overlay-click class="example-dialog">
        <h2>Добавить задачу</h2><br>
        <form id="newTaskForm" method="POST" enctype="multipart/form-data">
            <div>
                <input hidden name="kanban_id" id="modal_board_id">
                <input hidden name="owner_id" id="modal_owner_id">
                <div class="mb-3">
                    <mdui-text-field name="name" id="title" label="Название"></mdui-text-field>
                </div>
                <div class="mb-3">
                    <mdui-text-field rows="3" name="description" id="description" label="Описание"></mdui-text-field>
                </div>


                <div class="mb-3">
                    <mdui-select value="1" name="dep_id" id="dep_id">
                        <mdui-menu-item value="1">Выбор отдела</mdui-menu-item>
                        @foreach($departs as $dep)
                            <mdui-menu-item value="{{$dep['id']}}">{{$dep['name']}}</mdui-menu-item>
                        @endforeach

                    </mdui-select>
                </div>
                <div class="mb-3">
                    <mdui-select label="Сотрудники отдела" name="worker_id" id="worker">
                    </mdui-select>
                </div>

                <div class="mb-3">
                    <mdui-text-field type="datetime-local" name="date" id="date" label="Дата сдачи"></mdui-text-field>
                </div>

                <div class="mb-3">

                    <mdui-select value="1" name="status" id="status">

                        @foreach($statuses as $status)
                            <mdui-menu-item value="{{$status['id']}}">{{$status['name']}}</mdui-menu-item>
                        @endforeach

                    </mdui-select>
                </div>

                <div class="input-group">
                    <mdui-text-field type="file" name="file" id="fileInput" label="Фото задачи"></mdui-text-field>
                </div>

            </div>
        </form>

        <div class="mb-3">
            <mdui-button id="saveTask">Создать</mdui-button>
            <br>
            <mdui-button class="closeDialog" id="closeDialog">Закрыть форму</mdui-button>
            <br>
        </div>
        <script>

        </script>
    </mdui-dialog>
    <div class="row">
        @foreach($boards as $board)
            <div class=" col-lg-3">
                <mdui-button class="addTask" id="btn_board_id_{{$board['id']}}" variant="filled"
                             style=" margin-bottom: 15px; width:100%">Новая задача
                </mdui-button>
                <mdui-card variant="elevated" class="" style="width: 100%; min-height: 450px; background: #ffd9e3">
                    <h3 class="md-margin"> {{$board['name']}}</h3>

                    <div class="tasks" id="{{$board['id']}}" style="padding: 10px">
                        @foreach($tasks as $task)
                            @if($task['kanban_id'] == $board['id'])
                                <div class=" mb-3 cursor-grab task" id="{{$task['id']}} "
                                     style="background: #e8def8; border-radius: 15px">
                                    <mdui-card variant="elevated " style="background: #e8def8; margin-bottom: 15px"
                                               id="{{$task['id']}}">
                                        @if($task['task_photo'] != "/res/images/noimage.jpg")
                                            <img class="card-img-top"
                                                 src="/{{$task['task_photo']}}"
                                                 alt=""/>
                                        @endif
                                        <div class="md-margin">
                                            <h4>{{$task['name']}}</h4>
                                        </div>
                                        <div class="text-right md-left">
                                            Инфо: {{$task['description']}}

                                        </div>

                                        <div class="text-right md-left">
                                            Назначил: {{$users[$task['owner_id']]['name']}}

                                        </div>
                                        <div class="text-right md-left">
                                            Ответственный: {{$users[$task['worker_id']]['name']}}
                                        </div>
                                        <div class="text-right md-left">
                                            Открыта с: {{$task['date_open']}}
                                        </div>

                                        <div class="text-right md-left">
                                            Сдача: {{$task['date']}}
                                        </div>

                                    </mdui-card>
                                </div>
                            @endif
                        @endforeach

                    </div>

                </mdui-card>
            </div>
            </mdui-card>
        @endforeach
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

        dep_id.addEventListener('change', () => {
            workerlist.innerHTML = `\`<option value="" selected>Загружаем выбранный отдел</option>\``;


            // ShowNotify("Менеджер задач", "Меняем статус задачи");
            ShowNotify("Менеджер пользователей", "Получаем данные по отделу", 'warning')
            fetch('/getUserByDep/' + dep_id.value)

                .then(response => response.json())

                .then(data => {
                    workerlist.innerHTML = '';
                    let dt = Object.keys(data)
                    // console.log(dt);
                    console.log(data);
                    dt.forEach((usr) => {
                        console.log(data[usr].name);
                            workerlist.innerHTML += `<mdui-menu-item value="user_${data[usr].id}">${data[usr].name}</mdui-menu-item>`;

                    })

                    //ShowNotify("Менеджер задач", "Изменение статуса задачи прошло успешно!", 'success');

                })
                .catch(error => {
                    console.log(error);
                })

        })


        let buttons = document.querySelectorAll('.addTask');
        buttons.forEach(function (button) {
            button.addEventListener('click', function (event) {
                console.log("click");
                const dialog = document.querySelector(".example-dialog");
                dialog.open = true;

                let modal_board_id = document.getElementById("modal_board_id");
                let modal_owner_id = document.getElementById("modal_owner_id");

                modal_board_id.value = event.target.id;
                modal_owner_id.value = localStorage.getItem("uid");

            });
        });
    </script>
    <script src="../src/views/js/tasks.js"></script>


@include('footer')