@include('header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dragula@3.7.3/dist/dragula.min.css">
<style>





</style>
<script src="../src/views/js/auth.js"></script>
<div class="container py-5">


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
                                                 src="{{$task['task_photo']}}"
                                                 alt="Bootstrap Kanban Board"/>
                                            <h5 class="mb-2"><a href="/task/{{$task['id']}}">{{$task['name']}}</a></h5>


                                            <div class="text-right">
                                                Описание: {{$task['description']}}
                                            </div>
                                            <div class="text-right">
                                                Назначил: {{$users[$task['owner_id']]['name']}}
                                            </div>
                                            <div class="text-right">
                                                Ответственный: {{$users[$task['worker_id']]['name']}}
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
                            <label for="worker" class="form-label">Ответственный за выполнение</label>
                            <select class="form-select" name="worker_id" id="worker" aria-label="Выберите язык">
                                @foreach($users as $user)
                                    <option value="user_{{$user['id']}}">{{$user['name']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="date"  class="form-label">Число и время сдачи</label>
                            <input type="datetime-local" name="date" class="form-control" id="date" rows="3"
                                   placeholder="Введите описание"></input>
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


<script src="https://cdn.jsdelivr.net/npm/dragula@3.7.3/dist/dragula.min.js"></script>
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
        notificationSound.play();
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

</script>
<script src="../src/views/js/tasks.js"></script>


@include('footer')