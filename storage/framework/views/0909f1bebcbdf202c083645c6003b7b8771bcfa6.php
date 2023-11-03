<div id="mainBlock">
    <div id="d-block" style="display:none; background-color: black;opacity:0.3; z-index:1000; position:fixed;top:0;right:0;bottom:0;left:0;"></div>
    <button id="tutorShow" onclick="tutorShow()" style="z-index:1100; position:fixed; bottom:200px; right:50px;" class="btn btn-light">
        Lanjutkan
        <img style="width:30px; margin:-2.5px 0 0 0;" src="data:image/png;base64,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">
    </button>
    <div class="card p-3 textTutor" id="tutortopright" style="display:none; opacity:.9; position: fixed; z-index:1001; top:20px; right:20px;"></div>
    <div class="card p-3 textTutor" id="tutorbottomleft" style="display:none; opacity:.9; position: fixed; z-index:1001; bottom:20px; left:20px;"></div>
    <div id="avatarHallo" style=" display:none; position: fixed; z-index:1001; left:0px; bottom:20px;">
        <img src="<?php echo e(asset('public/avatarHallo.png')); ?>">
        <center style="color: white; margin-bottom:50px;">
            Image by <a style="color: white;" href="https://www.freepik.com/free-psd/3d-rendering-woman-waving_23735412.htm#page=2&query=people%20avatar&position=48&from_view=search&track=ais"><u>Freepik</u></a><br>
        </center>
        
    </div>
    <div id="avatarKritik" style=" display:none; position: fixed; z-index:1001; left:0px; bottom:20px;">
        <img src="<?php echo e(asset('public/avatarKritik.png')); ?>">
        <center style="color: white; margin-bottom:50px;">
            Image by <a style="color: white;" href="https://www.freepik.com/free-psd/3d-rendering-woman-waving_23735412.htm#page=2&query=people%20avatar&position=48&from_view=search&track=ais"><u>Freepik</u></a><br>
        </center>
        
    </div>
</div>
<script>
    $('#d-block').fadeToggle('slow')
    $('#d-block').click(function(){
        showNty('Tekan Lanjutkan Untuk Melewati')
    })
    var indexTutor = 1;
    var zIndexValue = 0;
    tutorShow()
    function tutorShow(){
        $('.textTutor').hide()
        if(indexTutor == 1){
            $('body').css('overflow','hidden')
            indexTutor = indexTutor + 1;
            $('#avatarHallo').fadeToggle('slow')
            $('#tutortopright').fadeToggle('slow')
            $('#tutortopright').html("Hallo, Selamat datang di SisBilling, <br>Saya akan menjelaskan langkah-langkah dasar penggunaan aplikasi ini. <br> Tekan Lanjutkan")
        }else if(indexTutor == 2){
            indexTutor = indexTutor + 1;
            $('#avatarHallo').fadeToggle('slow')
            $('#tutorbottomleft').fadeToggle('slow')
            $('#tutorbottomleft').html("Tagihan Kamu tampil pada agenda ini,<br>Dan Kamu bisa juga menggunakannya untuk agenda pribadi.")
            $('#showscheduler').find('*').css('z-index','1010')
        }else if(indexTutor == 3){
            indexTutor = indexTutor + 1;
            $('#tutortopright').fadeToggle('slow')
            $('#tutortopright').html("ini adalah menu tagihan Kamu <br>setelah Kamu mengunakan jasa Pengelola yang terdaftar di SisBilling")
            UIkit.switcher('.uk-switcher').show(1)
            if (activeItem) {
                activeItem.classList.remove("active");
            }
            activeItem = menuItems[1] //untuk set aktiv variable global navbar Mobile (activeItem harus diperbarui valuenya)
            activeItem.classList.add("active")
            offsetMenuBorder(activeItem, menuBorder);
        }else if(indexTutor == 4){
            indexTutor = indexTutor + 1;
            $('#tutortopright').fadeToggle('slow')
            $('#tutortopright').html("Disini digunakan untuk forum Kamu, <br>Oh yaa, jika ingin memberi kritik, Tekan saja Pesan di atas, lalu pilih 'Support Center'.<br>Kami sangat senang menerima masukan dan saran dari pengguna kami.")
            UIkit.switcher('.uk-switcher').show(2)
            if (activeItem) {
                activeItem.classList.remove("active");
            }
            activeItem = menuItems[2] //untuk set aktiv variable global navbar Mobile (activeItem harus diperbarui valuenya)
            activeItem.classList.add("active")
            offsetMenuBorder(activeItem, menuBorder);
            $('#avatarKritik').fadeToggle('slow')
        }else if(indexTutor == 5){
            indexTutor = indexTutor + 1;
            $('#avatarKritik').fadeToggle('slow')
            $('#tutortopright').fadeToggle('slow')
            $('#tutortopright').html("Disini profile Kamu, Jika ingin bergabung sebagai pengelola,<br>Tekan saja 'Perusahaan' di Pengaturan, lalu ajukan perusahaan Kamu, <br>Setelah itu jangan lupa untuk mendaftarkan Produk Kamu yaa..<br><br><strong>Terimakasi Sudah Bergabung Di SisBilling</strong>")
            UIkit.switcher('.uk-switcher').show(3)
            if (activeItem) {
                activeItem.classList.remove("active");
            }
            activeItem = menuItems[3] //untuk set aktiv variable global navbar Mobile (activeItem harus diperbarui valuenya)
            activeItem.classList.add("active")
            offsetMenuBorder(activeItem, menuBorder);
            $('#tutorShow').text("Selesai")
        }else if(indexTutor == 6){
            $('#mainBlock').hide()
            $('body').css('overflow-y','scroll')
            $.ajax({
                type: 'GET',
                cache: false,
                url: '<?php echo e(url("/updateTutor")); ?>',
                success:function(){
                    window.location.href="<?php echo e(url('/')); ?>";
                }
            });
        }
    }
</script><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/tutor.blade.php ENDPATH**/ ?>