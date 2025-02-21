<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?></title>
</head>
<body>
    <header>
        <nav>
            <a href="<?php echo e(route('tasks.index')); ?>">Список задач</a>
            <a href="<?php echo e(url('/about')); ?>">О нас</a>
        </nav>
    </header>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\fwad\todo-app\resources\views/layouts/app.blade.php ENDPATH**/ ?>