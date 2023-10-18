
<?php $__env->startSection('content'); ?>
<style>
    input,select{
    border:none;
    color: rgb(88, 137, 204);
    }

    .input{
    color: rgb(117, 115, 115);
    border-bottom: .5px solid rgb(215, 226, 243);
    margin-left: 0px;
    margin-bottom: 0px;
    max-width: 100%;
    }

    .validate{
    color: red;
    font-size: 12px;
    }
    input:focus, select:focus{
    color: rgb(88, 137, 204);
    border:none;
    outline: none;
    /* border-bottom: 1px solid rgb(173, 162, 162); */
    }
</style>
<div class="container">
    <div class="container row" style="margin-top:20vh;">
        <div class="col-lg-4 col-1"></div>
        <div class="col">
            <h2 class="blueFont text-end">Selamat Datang</h2>
            <h4 class="blueFont text-end">Sis Billing</h4>
        </div>
        <div class="col-lg-4 col-1"></div>
    </div>
    <div class="container row" style="margin-top:5vh;">
        <div class="col-lg-4"></div>
        <form style="padding:0;" class="col" method="POST" action="<?php echo e(url('/auuten')); ?>">
            <?php echo csrf_field(); ?>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="alert alert-danger"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div class="row mt-3">
                <label for="displayLogin-email" class="col-xl-4 col-lg-4 col-md-3 col-sm-3 col-3">Email</label>
                <label for="displayLogin-email" class="col-auto" style="padding-right:0;">:</label>
                <input id="displayLogin-email" name="email" type="email" class="d-flex col form input" >
            </div>
            <div class="row mt-3">
                <label for="displayLogin-password" class="col-xl-4 col-lg-4 col-md-3 col-sm-3 col-3">Password</label>
                <label for="displayLogin-password" class="col-auto" style="padding-right:0;">:</label>
                <input id="displayLogin-password" name="password" type="password" class="input d-flex col form" >
            </div>
            <div class="row mt-3">
                <div class="col-1"></div>
                <button class="col-10 btn btn-primary">Login</button>
                <div class="col-1"></div>
            </div>
            <div class="row mt-2">
                <div class="col-6 blueFont">
                    <a href="<?php echo e(url('/forgot')); ?>">lupa Password?</a>
                </div>
                <div class="col-6 blueFont text-end">
                    <a href="<?php echo e(url('/registerView')); ?>">Pengguna Baru</a>
                </div>
            </div>
        </form>
        <div class="col-lg-4"></div>
    </div>
</div>
<img src="<?php echo e(asset('public/wave.svg')); ?>" style="bottom:0; position: fixed; z-index:-1">

<script>
    if (caches && caches.keys) {
        caches.keys().then(function(names) {
        names.forEach(function(name) {
            caches.delete(name);
        });
        });
    }

  // Membersihkan localStorage
  localStorage.clear();
</script>
<?php $__env->stopSection(); ?>
    
<?php echo $__env->make('layout.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/displayLogin.blade.php ENDPATH**/ ?>