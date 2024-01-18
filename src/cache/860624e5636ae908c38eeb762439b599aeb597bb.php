<?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container mt-5">
    <h1><?php echo e($currentTask['name']); ?></h1>
    <input hidden value="<?php echo e($currentTask['id']); ?>" id="task_id">
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php echo e($currentTask['name']); ?></h4>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Статус</h4>
                    <p class="card-text"><?php echo e($currentTask['status']); ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Описание</h4>
                    <p class="card-text"><?php echo e($currentTask['description']); ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Дата и время сдачи</h4>
                    <p class="card-text"><?php echo e($currentTask['date']); ?></p>
                </div>
            </div>
        </div>


        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Постановщик</h4>

                    <?
                        $um = new \App\Models\UserModel();
                        $user = $um->getUserById($currentTask['owner_id']);
                    ?>
                    <p class="card-text"><?php echo e($user['name']); ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Ответственный</h4>
                    <?
                    $user = $um->getUserById($currentTask['worker_id']);
                    ?>
                    <p class="card-text"><?php echo e($user['name']); ?></p>
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
    </div>
    <div class="mt-5">

        <h4>Комментарии</h4>

        <div class="card comment_card ">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h4>Добавить комментарий</h4>
                        <div class="mb-3">
                            <input hidden id="task_id" value="<?php echo e($currentTask['id']); ?>">

                            <textarea class="form-control" id="newCommentAdd" rows="3"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary " id="addComment">Отправить</button>
                    </div>
                </div>
                <div class="row">

                </div>

            </div>
        </div>


        <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="card comment_card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">

                            <?php if($comment['user_data']['photo'] == null): ?>
                                <img src= "/res/images/nopic.jpg" class="mr-3 align-self-start profile-pic-mini" alt="Фото профиля" width="64" height="64">
                            <?php else: ?>
                                <img src= "<?php echo e($comment['user_data']['photo']); ?>" class="mr-3 align-self-start profile-pic-mini" alt="Фото профиля" width="64" height="64">
                            <?php endif; ?>
                                <?php echo e($comment['user_data']['name']); ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="card-text"><?php echo e($comment['text']); ?></p>
                            <?php echo e($comment['date']); ?>

                        </div>


                    </div>

                </div>
                </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




    </div>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="saving" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Менеджер комментариев</strong>
                <small>Только что</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Отправляем и обновляем...
            </div>
        </div>
    </div>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="unsaving" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Менеджер комментариев</strong>
                <small>Только что</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
               Ошибка попробуйте еще раз
            </div>
        </div>
    </div>


    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="closing" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Менеджер задач</strong>
                <small>Только что</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Закрываем задачу и переводим в канбан!
            </div>
        </div>
    </div>

</div>
<script>
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

        fetch('http://hac2/addNewComment',{
            method: 'POST',
            body: resp,

        })

            .then(response=>response.text())

            .then(data=>{


                console.log(data);
                var good = new bootstrap.Toast(document.getElementById('saving'));

                // Покажите уведомление
                good.show();
                setTimeout(function() {
                    // Перезагрузить текущую страницу
                    location.reload();
                }, 500);

            })
            .catch(error=>{

                var bad = new bootstrap.Toast(document.getElementById('unsaving'));

                // Покажите уведомление
                bad.show();
                console.log(error);
            })
    })


    let deletask = document.getElementById("deleteTask");
    deletask.addEventListener('click', ()=>{

            let id = document.getElementById("task_id").value;


            let resp = JSON.stringify({
                "type":"deltask",
                "id": id});
            fetch('http://hac2/deltask',{
                method: 'POST',
                body: resp,

            })

                .then(response=>response.json())

                .then(data=>{


                    console.log(data);



                    var good = new bootstrap.Toast(document.getElementById('closing'));

                    // Покажите уведомление
                    good.show();
                    setTimeout(function() {
                        // Перезагрузить текущую страницу
                        window.location.href = "/tasks";
                    }, 500);



                })
                .catch(error=>{
                    console.log(error);
                    var myToast = new bootstrap.Toast(document.getElementById('faildel'));

                    // Покажите уведомление
                    myToast.show();
                })
    })
</script>




<?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\OSPanel\domains\hac2\src\views/taskDetail.blade.php ENDPATH**/ ?>