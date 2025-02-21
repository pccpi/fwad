<?php $__env->startSection('title', 'Список задач'); ?>

<?php $__env->startSection('content'); ?>
    <h1>Список задач</h1>
    <ul>
        <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a href="<?php echo e(route('tasks.show', $task['id'])); ?>">
                    <?php echo e($task['title']); ?> (<?php echo e($task['status']); ?>)
                </a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\fwad\todo-app\resources\views/tasks/index.blade.php ENDPATH**/ ?>