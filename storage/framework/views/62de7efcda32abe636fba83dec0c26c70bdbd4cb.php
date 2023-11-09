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
        
        <?php echo $__env->make('modal.mainModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('modal.mainModal2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('modal.mainModalSelect', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 

        
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg">
                <!-- Container wrapper -->
                <div class="container-fluid">
                <!-- Toggle button -->
                <button
                    class="navbar-toggler"
                    type="button"
                    data-mdb-toggle="collapse"
                    data-mdb-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Navbar brand -->
                    <a class="navbar-brand mt-2 mt-lg-0" href="#">
                    <img
                        src="<?php echo e(asset('public/icon.png')); ?>"
                        alt="SissBilling"
                        loading="lazy"
                        style="height: 30px;"
                    />
                    </a>
                    <!-- Left links -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link navAdministrator" id="adminlistpengelola" href="#" onclick="CallAdminPage('adminlistpengelola')" style="color: blue">List Pengelola</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navAdministrator" id="admintagihan" href="#" onclick="CallAdminPage('admintagihan')">Daftar Paket</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navAdministrator" id="adminpembayaran" href="#" onclick="CallAdminPage('adminpembayaran')">Pembayaran</a>
                    </li>
                    </ul>
                    <!-- Left links -->
                </div>
                <!-- Collapsible wrapper -->

                <!-- Right elements -->
                <div class="d-flex align-items-center">
                    <a type="button" class="btn-close" href="<?php echo e(url('/')); ?>"></a>
                </div>
                <!-- Right elements -->
                </div>
                <!-- Container wrapper -->
            </nav>
            <!-- Navbar -->
            <div class="mt-2 p-2" id="contentAdminRplc">
                
            </div>

            <script>
                CallAdminPage('adminlistpengelola')
                function CallAdminPage(link){
                    $('.navAdministrator').css('color','rgb(100, 100, 100)');
                    $('.navAdministrator').css('font-weight','normal');
                    $(`#${link}`).css('color','blue');
                    $(`#${link}`).css('font-weight','bold');
                    $.ajax({
                        type: 'GET',
                        cache: false,
                        url: '<?php echo e(url("")); ?>/' + link,
                        success: function(data) {
                            $('#contentAdminRplc').html(data)
                        }
                    });
                }
            </script>

        <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layout.footerlink', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </body>
</html>





    <?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/admin/index.blade.php ENDPATH**/ ?>