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
            <a class="nav-link navAdministrator" id="admintagihan" href="#" onclick="CallAdminPage('admintagihan')">Tagihan</a>
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
        <button onclick="$('#AdminContent').html('')" type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
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




    <?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/admin/index.blade.php ENDPATH**/ ?>