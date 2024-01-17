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

                                <div class="card mb-3 cursor-grab">
                                    <div class="card-body">
                                        <input hidden id="<?php echo e($board['id']); ?>" value="<?php echo e($board['id']); ?>">
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
<script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.6.6/dragula.min.js'></script>
<script>
    
    
    
    

    
    
    


    
    
    
    
    
    
    
    
    
    
    
    
    
    


    dragula([
        <?php $__currentLoopData = $boards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $board): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        document.getElementById('<?php echo e($board["id"]); ?>'),
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>]).on('drag', function (el) {
        el.className = el.className.replace('ex-moved', '');
    }).on('drop', function (el) {
        el.className += ' ex-moved';
        console.log("moved");
        console.log(el.parentElement.id);
    });
</script>
<?php echo $__env->make('footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\hac2\src\views/tasks.blade.php ENDPATH**/ ?>