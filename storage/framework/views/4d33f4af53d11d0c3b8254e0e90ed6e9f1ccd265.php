<div class="dropdown headericonX">
    <a href="#" class="notification" data-mdb-toggle="dropdown">
        
        <lord-icon
            src="https://cdn.lordicon.com/psnhyobz.json"
            trigger="click"
            colors="primary:#ffffff"
            style="width:30px;height:30px">
        </lord-icon>
        <?php if($notif['count'] != 0): ?>
        <span class="badge" style="background-color: whitesmoke;color:black; position: absolute; margin-left:-10px; margin-top:-7px"><?php echo e($notif['count']); ?></span>
        <?php endif; ?>
    </a>
    <ul class="dropdown-menu" style="position: absolute; left:-170px; box-shadow:-3px 3px 6px rgb(221, 221, 221)">
        <?php $__currentLoopData = $notif['myAgendda']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li onclick=""><a class="dropdown-item card mt-1" href="#"><?php echo e($i->text); ?> </a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $notif['pengumuman']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                if (strlen($p->judul) > 20) {
                    $limitedString = substr($p->judul, 0, 20) . '...';
                } else {
                    $limitedString = $p->judul;
                }
                if($p->isPengumumanCompany == 1){
                    $indexLi = 0;
                }else{
                    $indexLi = 2;
                    if(session('UIDGlob')->companyid != null){
                        $indexLi = 3;
                    }
                }
            ?>
            <li onclick="showpengumuman('<?php echo e(session('UIDGlob')->userid); ?>','<?php echo e($p->pengumumanid); ?>','<?php echo e($indexLi); ?>')"><a class="dropdown-item card mt-1" href="#">Pengumuman : <?php echo e($limitedString); ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $notif['chat']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                if (strlen($c->nama) > 20) {
                    $limitedString = substr($c->nama, 0, 20) . '...';
                } else {
                    $limitedString = $c->nama;
                }
            ?>
            <li onclick="opnchat(<?php echo e($c->chatid); ?>)"><a class="dropdown-item card mt-1" href="#"><?php echo e($c->total); ?> Pesan Dari <?php echo e($limitedString); ?> </a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $notif['invoice']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li onclick="payment('<?php echo e($i->notrans); ?>')"><a class="dropdown-item card mt-1" href="#">Tagihan : <?php echo e($i->Text); ?> </a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $notif['invoiceReject']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li onclick="payment('<?php echo e($i->notrans); ?>')"><a class="dropdown-item card mt-1" href="#">Reject <?php echo e($i->Text); ?> : <?php echo e($i->notrans); ?> </a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $notif['invoiceWaiting']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li onclick="payment('<?php echo e($i->notrans); ?>')"><a class="dropdown-item card mt-1" href="#">Approval <?php echo e($i->Text); ?> : <?php echo e($i->notrans); ?> </a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>

<script>
    if(parseInt('<?php echo e(count($notif["invoiceReject"])); ?>') > 0){
        loadbilling()
    }
    function showpengumuman(userid,pengumumanid,index) {
        UIkit.switcher('.uk-switcher').show(index);

        if (activeItem) {
            activeItem.classList.remove("active");
        }
        activeItem = menuItems[index] //untuk set aktiv variable global navbar Mobile (activeItem harus diperbarui valuenya)
        activeItem.classList.add("active")
        offsetMenuBorder(activeItem, menuBorder);
        // $('.navbarCustomIcon').css('background-color', 'rgb(180, 174, 174)');
        // $('.uk-subnav > li:eq('+index+') .navbarCustomIcon').css('background-color', 'aliceblue');

        if(index == 0){
            var targetDiv = $('#pengumumanCompany' + pengumumanid);
        }else{
            var targetDiv = $('#pengumumanForum' + pengumumanid);
        }
        var posisiLayar = window.scrollY || window.pageYOffset;
        var originalBackgroundColor = targetDiv.css('background-color');
        setTimeout(() => {
            $('html, body').stop().animate({
                    scrollTop: targetDiv.offset().top - 150
            }, 50 );
            window.scrollBy(0, 500)
            targetDiv.css('background-color', 'whitesmoke');
            setTimeout(() => {
                targetDiv.css('background-color', originalBackgroundColor);
            }, 2000);       
        }, 500);
        $.ajax({
            url: '<?php echo e(url("/readpengumuman")); ?>',
            type: 'GET',
            cache: false,
            data: {userid,pengumumanid}
        });
    }



</script><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/getView/viewLonceng.blade.php ENDPATH**/ ?>