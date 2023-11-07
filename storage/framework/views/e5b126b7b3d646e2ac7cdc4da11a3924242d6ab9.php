<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <link rel="icon" type="image/png" href="<?php echo e(asset('public/icon.png')); ?>">
        <link rel="apple-touch-startup-image" href="<?php echo e(asset('public/icon.png')); ?>">

        <title>Sis Billing</title>
        <?php echo $__env->make('layout.headerlink', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <style>body{margin:0 !important;padding:0 !important;}</style>
        <?php
            $UIDGlob = session('UIDGlob');
        ?>
        <script>
            const UIDGlob = JSON.parse(`<?php echo $UIDGlob; ?>`);
            if(UIDGlob == null){
                window.location.href = '<?php echo e(url("/logout")); ?>';
            }
        </script>
    </head>
    <body style="overflow-y: scroll; height: auto;">
        <header style="position: fixed; top:0;left:0;right:0; z-index:500;">
            <?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </header>
        
        <?php echo $__env->make('modal.mainModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('modal.mainModal2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('modal.mainModalSelect', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
        <?php if($UIDGlob->companyid != '' && session('UIDGlob')->scrb < 1): ?>
            <?php if(session('UIDGlob')->superadmin != 1): ?>
                <div class="uk-alert-danger" uk-alert style="position: fixed; top:50px; right:5px;vw;z-index:99999">
                    <a href class="uk-alert-close" uk-close></a>
                    <p>Akun Anda Telah Habis Masa Aktif, Tolong Lakukan Pembayaran</p>
                    <p>Jika Butuh Bantuan Hubungi CS SisBilling.</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <div class="body" style="padding-bottom:20vh; padding-top:30px;">
            <div class="container">
                <?php echo $__env->make('loader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <ul class="uk-switcher switcher-navbarCustom uk-margin">
                    <li><?php echo $__env->make('tabs.mydashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></li>
                    <?php if(($UIDGlob->companyid != '' && session('UIDGlob')->scrb > 0) || session('UIDGlob')->superadmin == 1): ?>
                    <li><?php echo $__env->make('tabs.mycustomer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></li>
                    <?php endif; ?>
                    <li><?php echo $__env->make('tabs.mybilling', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></li>
                    <li><?php echo $__env->make('tabs.myforum', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></li>
                    <li><?php echo $__env->make('tabs.myprofile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></li>
                </ul>
            </div>
        </div>
        
        <?php if($UIDGlob->isTutor == 1): ?>
            <?php echo $__env->make('tutor', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        
        <?php echo $__env->make('layout.navbarMobile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layout.footerlink', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </body>
    <script>
        if('<?php echo e(session("track")); ?>' == 'mybilling'){
            UIkit.switcher('.uk-switcher').show(1)
            if (activeItem) {
                activeItem.classList.remove("active");
            }
            activeItem = menuItems[1] //untuk set aktiv variable global navbar Mobile (activeItem harus diperbarui valuenya)
            activeItem.classList.add("active")
            offsetMenuBorder(activeItem, menuBorder);
            loadbilling()
            $.ajax({
                url: '<?php echo e(url("/track")); ?>',
                method: 'GET',
                cache: false,
            });

        }
    </script>
</html>
<?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/layout/main.blade.php ENDPATH**/ ?>