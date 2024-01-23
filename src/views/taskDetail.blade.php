@include('header')
<div class="container mt-5">

    <input hidden value="{{$currentTask['id']}}" id="task_id">
    <input hidden value="{{$currentTask['name']}}" id="task_name">
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$currentTask['name']}}</h4>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-{{$currentTask['status']['color']}}">
                <div class="card-body ">
                    <h4 class="card-title">Статус</h4>
                    <p class="card-text ">{{$currentTask['status']['name']}}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Описание</h4>
                    <p class="card-text">{{$currentTask['description']}}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Дата и время сдачи</h4>
                    <p class="card-text">{{$currentTask['date']}}</p>
                </div>
            </div>
        </div>


        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Постановщик</h4>

                    <?
                        $um = new \App\Models\UserModel();
                        $user1 = $um->getUserById($currentTask['owner_id']);
                    ?>
                    <p class="card-text"><a href="/profile/{{$user1['id']}}" >{{$user1['name']}}</a></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Ответственный</h4>
                    <?
                    $user2 = $um->getUserById($currentTask['worker_id']);
                    ?>
                    <p class="card-text"><a href="/profile/{{$user2['id']}}" >{{$user2['name']}}</a></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Закрыть задачу</h4>
                    <p class="card-text" >
                        <button type="button" class="btn btn-primary " id="deleteTask">Закрыть</button>
                    </p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Изменить задачу</h4>
                    <p class="card-text" >
                        <button type="button" class="btn btn-primary " id="changeWorker">Изменить</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5">

        <h4>Комментарии</h4>

        <div class="card comment_card ">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h4>Добавить комментарий</h4>
                        <div class="mb-3">
                            <input hidden id="task_id" value="{{$currentTask['id']}}">

                            <textarea class="form-control" id="newCommentAdd" rows="3"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary " id="addComment">Отправить</button>
                    </div>
                </div>
                <div class="row">

                </div>

            </div>
        </div>


        @foreach($comments as $comment)

            <div class="card comment_card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">

                            @if($comment['user_data']['photo'] == null)
                                <img src= "/res/images/nopic.jpg" class="mr-3 align-self-start profile-pic-mini" alt="Фото профиля" width="64" height="64">
                            @else
                                <img src= "{{$comment['user_data']['photo']}}" class="mr-3 align-self-start profile-pic-mini" alt="Фото профиля" width="64" height="64">
                            @endif
                                {{$comment['user_data']['name']}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="card-text">{{$comment['text']}}</p>
                            {{$comment['date']}}
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
                <h5 class="modal-title" id="exampleModalLabel">Изменить задачу</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">

                    <div class="mb-3">
                        <label for="nameTask" class="form-label">Название</label>
                        <input type="text" name="name" class="form-control" id="nameTask" value="{{$currentTask['name']}}" placeholder="Введите название">

                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea class="form-control" name="description" id="description"  rows="3"
                                  placeholder="Введите описание">{{$currentTask['description']}}</textarea>
                    </div>


                    <div class="mb-3">
                        <label for="date"  class="form-label">Число и время сдачи</label>
                        <input type="datetime-local" name="date" class="form-control" id="date" rows="3"
                               placeholder="Введите описание" value="{{$currentTask['date']}}"></input>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Статус</label>
                        <?
                        $sm = new \App\Models\TaskStatusModel();
                        $statuses = $sm->getAllStatuses();
                        ?>
                        <select class="form-select" name="status" id="status" aria-label="Выберите язык">
                            <option value="{{$currentTask['id']}}">{{$currentTask['status']['name']}}</option>

                            @foreach($statuses as $status)
                                <option value="{{$status['id']}}">{{$status['name']}}</option>

                            @endforeach

                        </select>
                    </div>
                    <?
                    $dm = new \App\Models\DepartmentModel();
                    $departs = $dm->getAllDerartments();
                    ?>
                    <div class="mb-3">
                    <label for="worker" class="form-label">Отдел</label>
                    <select class="form-select" name="dep_id" id="dep_id" aria-label="Выберите язык">
                        <option value="0" selected>Выберите отдел</option>
                        <option value="{{$departs[$user2['department']]['id']}}" selected>{{$departs[$user2['department']]['name']}} (Текущий)</option>
                        @foreach($departs as $dep)
                            <option value="{{$dep['id']}}">{{$dep['name']}}</option>
                        @endforeach
                    </select>
                    </div>


                    <div class="mb-3">
                        <label for="worker" class="form-label">Ответственный за выполнение</label>
                        <select class="form-select" name="worker_id" id="worker" aria-label="Выберите язык">
                            <option value="user_{{$user2['id']}}" selected>{{$user2['name']}} (Текущий)</option>{{--                                @foreach($users as $user)--}}
                            {{--                                    <option value="user_{{$user['id']}}">{{$user['name']}}</option>--}}
                            {{--                                @endforeach--}}
                        </select>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary " id="upTask" data-bs-dismiss="modal">Сохранить</button>
            </div>
        </div>
    </div>
</div>
<script>
    let changeWorker = document.getElementById("changeWorker");

    changeWorker.addEventListener('click', ()=>{
        let modal = document.getElementById('myModal');
        var myModal = new bootstrap.Modal(modal);


// Отобразите модальное окно
        myModal.show();








    })

    let uptask = document.getElementById("upTask");
    uptask.addEventListener('click', ()=>{

        let taskId = document.getElementById('task_id').value;
        let name = document.getElementById('nameTask').value
        let description = document.getElementById('description').value
        let date = document.getElementById('date').value
        let status = document.getElementById('status').value
        let dep_id = document.getElementById('dep_id').value
        let worker = document.getElementById('worker').value


        let resp = JSON.stringify({

            "task_id": taskId,
            "name": name,
            "description": description,
            "date": date,
            "dep_id": dep_id,
            "worker": worker,
            "status": status,

        });
        console.log(resp)
        ShowNotify("Менеджер задач", "Обновляем задачу")
        fetch('/updateTask',{
            method: 'POST',
            body: resp,

        })

            .then(response=>response.json())

            .then(data=>{


                console.log(data);
            if(data.status == "ok") {
                ShowNotify("Менеджер задач", "Задача обновлена", 'success')

                // Покажите уведомление

                setTimeout(function() {
                    // Перезагрузить текущую страницу
                    location.reload();
                }, 500);
            } else {
                ShowNotify("Менеджер задач", "Ошибка", 'danger')
            }


            })
            .catch(error=>{
                ShowNotify("Менеджер задач", "Ошибка", 'danger')
                console.log(error);
            })

    })

    let dep_id = document.getElementById("dep_id");
    let workerlist = document.getElementById("worker");
    dep_id.addEventListener('change', ()=>{
///getUserByDep/
        workerlist.innerHTML = '';

        // ShowNotify("Менеджер задач", "Меняем статус задачи");
        ShowNotify("Менеджер пользователей", "Получаем данные по отделу", 'warning')
        fetch('/getUserByDep/'+dep_id.value)

            .then(response => response.json())

            .then(data => {

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

    let btnSendcomment = document.getElementById("addComment");
    btnSendcomment.addEventListener('click', ()=>{
        let userId = localStorage.getItem("uid");
        let taskid = document.getElementById("task_id").value;
        let message = document.getElementById("newCommentAdd").value;

        let resp = JSON.stringify({
            "type":"newComment",
            "task_id": taskid,
            "user_id": userId,
            "text": message});

        fetch('/addNewComment',{
            method: 'POST',
            body: resp,

        })

            .then(response=>response.text())

            .then(data=>{


                console.log(data);

                ShowNotify("Менеджер комментарией", "Коментарий сохранен", 'success')

                // Покажите уведомление

                setTimeout(function() {
                    // Перезагрузить текущую страницу
                    location.reload();
                }, 500);

            })
            .catch(error=>{
                ShowNotify("Менеджер комментарией", "Ошибка сохранения", 'danger')
                console.log(error);
            })
    })


    let deletask = document.getElementById("deleteTask");
    deletask.addEventListener('click', ()=>{

            let id = document.getElementById("task_id").value;


            let resp = JSON.stringify({
                "type":"deltask",
                "id": id});
            fetch('/deltask',{
                method: 'POST',
                body: resp,

            })

                .then(response=>response.json())

                .then(data=>{


                    console.log(data);



                    ShowNotify("Менеджер задач", "задача закрыта", 'warning');
                    setTimeout(function() {
                        // Перезагрузить текущую страницу
                        window.location.href = "/tasks";
                    }, 500);



                })
                .catch(error=>{
                    console.log(error);
                    ShowNotify("Менеджер задач", "Ошибка", 'danger');
                })
    })
</script>




@include('footer')
