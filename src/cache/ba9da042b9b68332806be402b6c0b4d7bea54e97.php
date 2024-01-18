<?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?
    $um = new \App\Models\UserModel();



?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card">

                <?php if($userData['photo'] == null): ?>
                    <img src="/res/images/nopic.jpg" class="card-img-top" alt="Фото профиля">
                <?php else: ?>
                    <img src= "<?php echo e($userData['photo']); ?>" class="mr-3 align-self-start profile-pic-mini" alt="Фото профиля" width="64" height="64">
                <?php endif; ?>

                <div class="card-body">
                    <h5 class="card-title"><?php echo e($userData['name']); ?></h5>
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

    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


    <div class="card comment_card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                   Название: <?php echo e($task['name']); ?>

                </div>
            </div>
            <div class="row">
                <div class="col">
                   Описание: <?php echo e($task['description']); ?>

                </div>
            </div>

            <div class="row">
                <div class="col">
                   Время сдачи: <?php echo e($task['date']); ?>

                </div>
            </div>

            <div class="row">
                <div class="col">
                    <?
                    $owner = $um->getUserById($task['owner_id'])
                    ?>
                    Постановщик: <a href="/profile/<?php echo e($owner['id']); ?>"><?php echo e($owner['name']); ?></a>
                </div>
            </div>


            <div class="row">
                <div class="col">
                    <?
                    $worker = $um->getUserById($task['worker_id'])
                    ?>
                    Ответственный: <a href="/profile/<?php echo e($worker['id']); ?>"><?php echo e($worker['name']); ?></a>
                </div>
            </div>

            <div class="row">
                <div class="col">

                    <a href="/task/<?php echo e($task['id']); ?>">К задаче</a>
                </div>
            </div>




        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\OSPanel\domains\hac2\src\views/profile.blade.php ENDPATH**/ ?>