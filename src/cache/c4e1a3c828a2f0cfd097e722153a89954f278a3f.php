<?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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


    <div class="row">
<?php $__currentLoopData = $boards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $board): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <!-- Start lane -->
        <div class=" col-lg-3">
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h3 class="card-title h5 mb-1">
                        <?php echo e($board['name']); ?>

                    </h3>
                    <small class="mb-0 text-muted">
                        <?php echo e($board['description']); ?>

                    </small>
                </div>
                <div class="card-body">
                    <div class="tasks" id="<?php echo e($board['id']); ?>">
                        <!-- Start task -->

                        <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($task['kanban_id'] == $board['id']): ?>

                                <div class="card mb-3 cursor-grab task" id="<?php echo e($task['id']); ?>">
                                    <div class="card-body">
                                        <img class="card-img-top" src="https://source.unsplash.com/sECcwm6BN8w/400x200" alt="Bootstrap Kanban Board" />
                                        <p class="mb-0"><a href="http://hac2/task/<?php echo e($task['id']); ?>"><?php echo e($task['name']); ?></a></p>




                                        <div class="text-right">
                                            Описание: <?php echo e($task['description']); ?>

                                        </div>
                                        <div class="text-right">
                                            Назначил: <?php echo e($users[$task['owner_id']]['name']); ?>

                                        </div>
                                        <div class="text-right">
                                            Ответственный: <?php echo e($users[$task['worker_id']]['name']); ?>

                                        </div>

                                        <div class="text-right">
                                            Срок сдачи: <?php echo e($task['date']); ?>

                                        </div>
                                        <div class="text-right" id="task-status">

                                            <span class="badge bg-danger text-white mb-2"> <?php echo e($task['status']); ?></span>
                                        </div>

                                    </div>
                                </div>
                            <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="btn btn-primary btn-block addTask" id="btn_board_id_<?php echo e($board['id']); ?>">Новая задача</div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



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
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="user_<?php echo e($user['id']); ?>"><?php echo e($user['name']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        <?php $__currentLoopData = $boards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $board): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        document.getElementById('<?php echo e($board["id"]); ?>'),
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>]).on('drag', function (el) {

    }).on('drop', function (el) {



        console.log(el.id);
        console.log(el.parentElement.id);

        let resp = JSON.stringify({
            "type":"changeStatus",
            "taskId": el.id,
            "kanban_id": el.parentElement.id});

        fetch('http://hac2/tasks/changeStatus',{
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


    let buttons = document.querySelectorAll('.addTask');
    buttons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            // Ваш обработчик события и код здесь
            let modal = document.getElementById('myModal');

        // <input id="modal_board_id">
        //         <input id="modal_owner_id">
        //         <input id="modal_owner_id">

            console.log(button.parentElement.id);
            let modal_board_id = document.getElementById("modal_board_id");
            let modal_owner_id = document.getElementById("modal_owner_id");
            let modal_worker_id = document.getElementById("modal_worker_id");

            modal_board_id.value = event.target.id;
            modal_owner_id.value = localStorage.getItem("uid");
            modal_worker_id.value = 1;

            var myModal = new bootstrap.Modal(modal);

// Отобразите модальное окно
            myModal.show();
        });
    });

    let saveTask = document.getElementById("saveTask");

    saveTask.addEventListener("click", ()=>{
        let name = document.getElementById("title").value;
        let description = document.getElementById("description").value;
        let modal_board_id = document.getElementById("modal_board_id").value;
        let modal_owner_id = document.getElementById("modal_owner_id").value;
        let date = document.getElementById("date").value;
        let worker = document.getElementById("worker").value;
        let stat = document.getElementById("status").value;
        console.log(date);
        console.log(worker);
        let resp = JSON.stringify({
            "type":"newTask",
            "name": name,
            "description": description,
            "kanban_id": modal_board_id,
            "owner_id":modal_owner_id,
            "worker_id": worker,
            "date":date,
            "status": stat
        });



        fetch('http://hac2/tasks/newTask',{
            method: 'POST',
            body: resp,

        })

            .then(response=>response.json())

            .then(data=>{


                console.log(data);



                var myToast = new bootstrap.Toast(document.getElementById('liveToast'));

                // Покажите уведомление
                myToast.show();
                setTimeout(function() {
                    // Перезагрузить текущую страницу
                    location.reload();
                }, 500);






            })
            .catch(error=>{
                console.log(error);
            })


    });

    var saveButton = document.querySelector('#myModal .btn-primary');

    // Добавьте обработчик события на кнопку "Сохранить"
    saveButton.addEventListener('click', function() {
        // Выполните здесь дополнительные действия, если необходимо


        var myToast = new bootstrap.Toast(document.getElementById('saving'));

        // Покажите уведомление
        myToast.show();
    });




</script>


<?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\hac2\src\views/tasks.blade.php ENDPATH**/ ?>