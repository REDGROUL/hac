<html>
<head>
    <title>App Name - <?php echo $__env->yieldContent('title'); ?></title>
</head>
<body>
<?php $__env->startSection('sidebar'); ?>
    This is the master sidebar.
<?php echo $__env->yieldSection(); ?>

<div class="container">
    <?php echo $name; ?>.
</div>
</body>
</html><?php /**PATH C:\OSPanel\domains\hac\src\views/test.blade.php ENDPATH**/ ?>