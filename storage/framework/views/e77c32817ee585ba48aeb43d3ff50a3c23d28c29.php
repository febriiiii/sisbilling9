<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card mt-2">
        <div class="card-header" style="font-weight:bold;"><?php echo e($key); ?></div>
        <div class="card-body" >
            <?php if(count($val) != 0): ?>
                <?php $__currentLoopData = $val; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-1"><img style="margin-right: 20px; height:30px;width:30px; border-radius:100%;" src="<?php echo e(asset('public/storage/'.$d->profileImg)); ?>"><span style="margin-top:4px; position: absolute; font-weight:bold;"><?php echo e($d->nama); ?></span></div>    
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <center>Belum Ada Yang Memilih</center>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/getView/viewPolling.blade.php ENDPATH**/ ?>