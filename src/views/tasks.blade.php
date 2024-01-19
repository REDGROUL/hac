@include('header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dragula@3.7.3/dist/dragula.min.css">
<style>


    .cursor-grab {
        cursor: grab;
    }

    .tasks {
        min-height: 450px;
    }


    </style>
<div class="container py-5">

    <button id="generateToastButton" class="btn btn-primary">Сгенерировать тост</button>


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
                                        <img class="card-img-top" src="https://source.unsplash.com/sECcwm6BN8w/400x200" alt="Bootstrap Kanban Board" />
                                        <p class="mb-0"><a href="/task/{{$task['id']}}">{{$task['name']}}</a></p>




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
                                            Срок сдачи: {{$task['date']}}
                                        </div>
                                        <div class="text-right" id="task-status">

                                            <span class="badge bg-danger text-white mb-2"> {{$task['status']}}</span>
                                        </div>

                                    </div>
                                </div>
                            @endif
                    @endforeach
                    </div>
                    <div class="btn btn-primary btn-block addTask" id="btn_board_id_{{$board['id']}}">Новая задача</div>
                </div>
            </div>
        </div>
    @endforeach



    </div>
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Менеджер задач</strong>
            <small>Только что</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Изменение статуса задачи прошло успешно!
        </div>
    </div>
</div>


    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="saving" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Менеджер задач</strong>
            <small>Только что</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Сохраняем и обновляем...
        </div>
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
                <div>
                    <input hidden id="modal_board_id">
                    <input hidden id="modal_owner_id">
                    <input hidden id="modal_worker_id">
                    <div class="mb-3">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" class="form-control" id="title" placeholder="Введите название">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea class="form-control" id="description" rows="3" placeholder="Введите описание"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="worker" class="form-label">Ответственный за выполнение</label>
                        <select class="form-select" id="worker" aria-label="Выберите язык">
                            @foreach($users as $user)
                            <option value="user_{{$user['id']}}">{{$user['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Число и время сдачи</label>
                        <input type="datetime-local" class="form-control" id="date" rows="3" placeholder="Введите описание"></input>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Статус</label>
                        <select class="form-select" id="status" aria-label="Выберите язык">

                            <option value="Ежедневная">Ежедневная</option>
                            <option value="Срочная">Срочная</option>
                            <option value="Обычная">Обычная</option>


                        </select>
                    </div>
                </div>
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
            "type":"changeStatus",
            "taskId": el.id,
            "kanban_id": el.parentElement.id});

        fetch('/tasks/changeStatus',{
            method: 'POST',
            body: resp,

        })

            .then(response=>response.text())

            .then(data=>{


                console.log(data);



                var myToast = new bootstrap.Toast(document.getElementById('liveToast'));

                // Покажите уведомление
                myToast.show();

            })
            .catch(error=>{
                console.log(error);
            })
    });

</script>
<script src="../src/views/js/tasks.js"></script>


@include('footer')