<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title class="title">Sis Billing</title>
    <link rel="icon" href="<?php echo e(asset('public/logo.png')); ?>" type="image/x-icon">
    <?php echo $__env->make('layout.headerlink', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body style="background-color: transparent">
    <?php echo $__env->yieldContent('content'); ?>
        <div style="background-color:white; position: fixed; bottom: 10px; padding:2px 8px 2px 8px; border-radius:20px; right:20px; font-weight:bold;color:rgb(149, 136, 136)">
            &copy; Copyright GKS
        </div>
    <?php echo $__env->make('layout.footerlink', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/layout/blank.blade.php ENDPATH**/ ?>