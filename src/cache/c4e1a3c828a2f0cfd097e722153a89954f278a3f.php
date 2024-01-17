<?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<style>


    .cursor-grab {
        cursor: -webkit-grab;
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
        <div class="col-12 col-lg-4">
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

                                <div class="card mb-3 cursor-grab" id="<?php echo e($task['id']); ?>">
                                    <div class="card-body">

                                        <p class="mb-0"><?php echo e($task['name']); ?></p>
                                        <div class="text-right">
                                            <small class="text-muted mb-1 d-inline-block">25%</small>
                                        </div>
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <!-- End task -->














                        <!-- End task -->
                    </div>
                    <div class="btn btn-primary btn-block">Add task</div>
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


<script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.6.6/dragula.min.js'></script>
<script>
    
    
    
    

    
    
    


    
    
    
    
    
    
    
    
    
    
    
    
    
    


    dragula([
        <?php $__currentLoopData = $boards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $board): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        document.getElementById('<?php echo e($board["id"]); ?>'),
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>]).on('drag', function (el) {
        el.className = el.className.replace('ex-moved', '');
    }).on('drop', function (el) {
        el.className += ' ex-moved';


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
</script>
<?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\hac2\src\views/tasks.blade.php ENDPATH**/ ?>