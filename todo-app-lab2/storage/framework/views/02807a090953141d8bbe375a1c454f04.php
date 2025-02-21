<?php $__env->startSection('title', 'Задача ' . $task['id']); ?>

<?php $__env->startSection('content'); ?>
    <h1><?php echo e($task['title']); ?></h1>
    <p>Статус: <?php echo e($task['status']); ?></p>
    <a href="<?php echo e(route('tasks.index')); ?>">Назад к списку задач</a>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\fwad\todo-app\resources\views/tasks/show.blade.php ENDPATH**/ ?>