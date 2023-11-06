<div class="container" style="padding-bottom: 20vh">
    <center>
        <style>
            .avatar-upload {
                position: relative;
                max-width: 205px;
                margin: 50px auto;
            }
            .avatar-edit {
                position: absolute;
                right: 50px;
                z-index: 1;
                top: 0px;
                
            }
            .avatar-edit input {
                display: none;
                + label {
                    display: inline-block;
                    width: 34px;
                    height: 34px;
                    margin-bottom: 0;
                    border-radius: 100%;
                    background: #FFFFFF;
                    border: 1px solid transparent;
                    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
                    cursor: pointer;
                    font-weight: normal;
                    transition: all .2s ease-in-out;
                    &:hover {
                        background: #f1f1f1;
                        border-color: #d6d6d6;
                    }
                    &:after {
                        /* content: "\f040";
                        font-family: 'FontAwesome'; */
                        color: #757575;
                        position: absolute;
                        top: 5px;
                        left: 0;
                        right: 0;
                        text-align: center;
                        margin: auto;
                    }
                }
            }
            .avatar-preview {
                width: 100px;
                height: 100px;
                position: relative;
                border-radius: 100%;
                border: 6px solid #F8F8F8;
                box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
                background-color: #ccc4c4;
            }
            .avatar-preview > div {
                width: 100%;
                height: 100%;
                border-radius: 100%;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
            }
        </style>
        <div class="uploadimg">
            <form class="avatar-upload" id="myprofile-formimg">
                <div class="avatar-edit">
                    <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                    <label for="imageUpload"><i class="las la-pencil-alt" style="font-size: 1.2em;margin-top:5px;"></i></label>
                </div>
                <div class="avatar-preview">
                    <div id="imagePreview" style="background-image: url(<?php echo e(asset('public/storage/'.session('UIDGlob')->profileImg)); ?>);">
                    </div>
                </div>
                <button class="btn btn-primary mt-2" style="display: none;" type="submit" id="myprofile-saveimage">Simpan Perubahan</button>
            </form>
        </div>
        <form style="max-width: 500px" id="myprofile-formprofile">
            <div class="form-outline">
                <input type="text" id="myprofile_nama" class="form-control" value="<?php echo e(session('UIDGlob')->nama); ?>" required/>
                <label class="form-label" for="myprofile_nama">Nama</label>
            </div>
            <div class="form-outline mt-3">
                <input type="text" id="myprofile_Email" class="form-control" value="<?php echo e(session('UIDGlob')->email); ?>" required/>
                <label class="form-label" for="myprofile_Email">Email</label>
            </div>
            <div class="form-outline mt-3">
                <input type="number" id="myprofile_hp" class="form-control" value="<?php echo e(session('UIDGlob')->hp); ?>" required/>
                <label class="form-label" for="myprofile_hp">HP</label>
            </div>
            <div class="form-outline mt-3">
                <input type="text" id="myprofile_alamatSingkat" class="form-control" value="<?php echo e(session('UIDGlob')->alamatSingkat); ?>" required/>
                <label class="form-label" for="myprofile_alamatSingkat">Alamat Singkat</label>
            </div>
            <div class="form-outline mt-3">
                <textarea type="text" id="myprofile_alamatLengkap" class="form-control" required><?php echo e(session('UIDGlob')->alamatLengkap); ?></textarea>
                <label class="form-label" for="myprofile_alamatLengkap">Alamat Lengkap</label>
            </div>
            <div class="form-outline mt-3">
                <input type="text" id="myprofile_infoTambahan" class="form-control" value="<?php echo e(session('UIDGlob')->infoTambahan); ?>" required/>
                <label class="form-label" for="myprofile_infoTambahan">Info Tambahan</label>
            </div>
            <button class="btn btn-primary mt-3">Simpan Perubahan</button>
        </form>
        <div style="max-width: 500px">
            <hr>
            <h4>Ubah Password</h4>
            <div id="alertpass" style="display:none;" class="alert alert-danger">Password Tidak Sama</div>
            <div class="form-outline mt-3">
                <input type="password" id="myprofile_Passwordold" class="form-control" />
                <label class="form-label" for="myprofile_Passwordold">old Password</label>
            </div>
            <div class="form-outline mt-3">
                <input type="password" id="myprofile_Password" class="form-control" />
                <label class="form-label" for="myprofile_Password">New Password</label>
            </div>
            <div class="form-outline mt-3">
                <input type="password" id="myprofile_Password2" class="form-control" />
                <label class="form-label" for="myprofile_Password2">Confirm New Password</label>
            </div>
            <button id="myprofile_savepass" type="button" class="btn btn-primary mt-2" style="right:0;" disabled>Konfirmasi Password</button>
        </div>
        <?php if(session('UIDGlob')->companyid != ''): ?>
        <div style="max-width: 500px">
            <hr>
            <h4>Midtrans (Gateway)</h4>
            <div class="form-outline mt-3">
                <input type="password" id="clientKey" class="form-control seemid" value="<?php echo e($tblcomp['Client_Key']); ?>" readonly/>
                <label class="form-label" for="clientKey">Client Key</label>
            </div>
            <div class="form-outline mt-3">
                <input type="password" id="ServerKey" class="form-control seemid" value="<?php echo e($tblcomp['Server_Key']); ?>" readonly/>
                <label class="form-label" for="ServerKey">Server Key</label>
            </div>
            <div class="form-outline mt-3">
                <input type="password" id="IDMerchat" class="form-control seemid" value="<?php echo e($tblcomp['Merchant_ID']); ?>" readonly/>
                <label class="form-label" for="IDMerchat">Merchant ID</label>
            </div>
            <button onclick="toggleSeeMID()" class="btn btn-info mt-2" id="seemid">Lihat</button> <!-- Tombol untuk mengganti tipe input -->
        </div>
        <?php endif; ?>
    </center>
    <hr>
    <h4>Pengaturan</h4>
    <button class="btn btn-secondary mt-2 me-2" data-mdb-toggle="modal" data-mdb-target="#myprofile_companySetting">Perusahaan</button>
    <?php if(session('UIDGlob')->companyid != ''): ?>
    <button class="btn btn-secondary mt-2 me-2" onclick="opnMasterProduct()">Master Produk</button>
    <button class="btn btn-secondary mt-2 me-2" onclick="opnProductType()">Produk Type</button>
    <button class="btn btn-secondary mt-2 me-2" onclick="opnPaymentMethod()">Payment Method</button>
    <button class="btn btn-secondary mt-2 me-2" onclick="opnmdlcustomer()">Tambah Customer</button>
    <?php endif; ?>
    
    
    <!-- Modal popup -->
    <div class="modal fade" id="myprofile_companySetting" tabindex="-1" aria-labelledby="myprofile_companySettingLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id='myprofile-formcompany'>
                <input type="hidden" id='myprofile-companyidP' name="companyid" value="<?php echo e($tblcomp['companyid']); ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="myprofile_companySettingLabel">Perusahaan</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if(session('UIDGlob')->companyid == ''): ?>
                    <div class='mt-3'>
                        <label class='form-label' for='myprofile_companynameP'>Subsribe</label>
                        <select name="subscribe" id="myprofile_subscribe" class="form-select" style="background-color: red;color:white;font-weight:bold;">
                            <?php $__currentLoopData = $paket; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p->productCode); ?>"><?php echo e($p->productName); ?> <?php echo e(number_format($p->price,2)); ?>  disc <?php echo e($p->disc); ?>% (<?php echo e(number_format($p->price - ($p->price * $p->disc / 100),2)); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    <div class='mt-3'>
                        <label class='form-label' for='myprofile_companynameP'>Nama Perusahaan</label>
                        <input type='text' id='myprofile_companynameP' class='form-control' name='companyname' value="<?php echo e($tblcomp['companyname']); ?>" required/>
                    </div>
                    <div class='mt-3'>
                        <label class='form-label' for='myprofile_producttypeArrayP'>Pilih Pengelola</label>
                        <select style='width:100%;' name='producttypeArray[]' id='myprofile_producttypeArrayP' class='form-control select2' multiple='multiple' required>
                            <?php $__currentLoopData = $tblproducttype; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $productTempCompany = json_decode($tblcomp['producttypeArray']);
                                    if (is_array($productTempCompany)) {
                                        $select = in_array($d->producttypeid, $productTempCompany) ? "selected" : "";
                                    }else{
                                        $select = '';
                                    }
                                ?>
                                <option value="<?php echo e($d->producttypeid); ?>" <?php echo e($select); ?>><?php echo e($d->productTypeName); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>;
                        </select>
                    </div>
                    <div class='mt-3'>
                        <label class='form-label' for='myprofile_emailP'>Email Perusahaan</label>
                        <input type='text' id='myprofile_emailP' class='form-control' name='email' value="<?php echo e($tblcomp['email']); ?>" required/>
                    </div>
                    <div class='mt-3'>
                        <label class='form-label' for='myprofile_hpP'>HP</label>
                        <input type='text' id='myprofile_hpP' class='form-control' name='hp' value="<?php echo e($tblcomp['hp']); ?>" required/>
                    </div>
                    <div class='mt-3'>
                        <label class='form-label' for='myprofile_companyaddressP'>Alamat Perusahaan</label>
                        <input type='text' id='myprofile_companyaddressP' class='form-control' name='companyaddress' value="<?php echo e($tblcomp['companyaddress']); ?>" required/>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php if(session('UIDGlob')->companyid != ''): ?>
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <?php else: ?>
                    <button type="submit" class="col-12 btn btn-danger" name="subscribe" value="1">Subscribe</button>
                    <a href="https://api.whatsapp.com/send?phone=<?php echo e(App\Models\tbluser::find(1)->hp); ?>" target="_blank" class="col-12 btn btn-outline-secondary" style="height: 35px;">
                        <i class="fab fa-whatsapp"></i> Follow Up? <span style="color:red; font-size:0.8em;">*Menunggu Persetujuan Admin Sis Billing</span>
                    </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>  
</div>
<script>
    function toggleSeeMID() {
        var inputs = document.querySelectorAll('.seemid');
        inputs.forEach(function(input) {
            if (input.type === 'password') {
                input.type = 'text'; // Ganti ke tipe teks
                $('#seemid').text("Sembunyikan")
            } else {
                input.type = 'password'; // Ganti ke tipe sandi (password)
                $('#seemid').text("Lihat")
            }
        });
    }
    function opnmdlcustomer(){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '<?php echo e(url("/viewaddcustomer")); ?>',
            success: function(data) {
                openmodal('Tambah Customer',data)
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
    function opnmdlpengelola(){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '<?php echo e(url("/viewaddpengelola")); ?>',
            success: function(data) {
                openmodal('Tambah Pengelola',data)
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
    
    function opnMasterProduct(){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '<?php echo e(url("/viewmasterproduct")); ?>',
            success: function(data) {
                openmodal('Master Product',data)
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
    function opnProductType(){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '<?php echo e(url("/viewproductype")); ?>',
            success: function(data) {
                openmodal('Product Type',data)
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
    function opnPaymentMethod(){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '<?php echo e(url("/viewpaymentmethod")); ?>',
            success: function(data) {
                openmodal('Payment Method',data)
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
    $("#myprofile_companysetting").dxPopup({
        fullScreen: true,
        title: "Company Setting",
    });
    $('#myprofile_producttypeArrayP').select2()
    
    // var select2Element = $('.select2').select2();
    // select2Element.append(new Option(d.productTypeName, d.producttypeid, true, true)).trigger('change') //add selected
    // $('h4').append(formCompany)
    // $('#myprofile_producttypeArray').select2();

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
            $('#myprofile-saveimage').show()
        }
    }
    $("#imageUpload").change(function() {
        readURL(this);
    });
    $('#formctu').submit(function(g){
        g.preventDefault()
        if($('#myprofile_companyaddE').val() == ''){
            showNty("Tolong Pilih Pengelola")
            return false;
        }else{
            this.submit();
        }
    })
    $('#myprofile-formcompany').submit(function(d) {
        $('#loader').show('slow')
        d.preventDefault();
        $.ajax({
            type: 'POST',
            cache: false,
            url: '<?php echo e(url("/companyUpdate")); ?>',
            data: $('#myprofile-formcompany').serialize(),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(data) {
                showNty(data,10000)
                $('#loader').hide('slow')
                setTimeout(() => {
                    window.location.href = '<?php echo e(url("/")); ?>'
                }, 10000);
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    });
    $('#myprofile-formimg').submit(function(e){
        e.preventDefault()
        // Get the file input element and the selected file
        var input = $('#imageUpload')[0];
        var file = input.files[0];
        
        // Create a FormData object and add the file to it
        var formData = new FormData();
        formData.append('image', file);
        
        // Make an AJAX request to the server to upload the image
        $.ajax({
            url: '<?php echo e(url("/uploadimageprofile")); ?>',
            type: 'POST',
            cache: false,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(data) {
                // Handle the response from the server
                console.log(data);
                $('#imagePreview').css('background-image', 'url(' + data + ')');
                $('#myprofile-saveimage').hide()
                showNty('Success Change Profile')
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    })
    $('#myprofile-formprofile').submit(function(f) {
        f.preventDefault();
        var formData = new FormData();

        // Mengambil value dari form input
        var nama = $('#myprofile_nama').val();
        var email = $('#myprofile_Email').val();
        var hp = $('#myprofile_hp').val();
        var alamatSingkat = $('#myprofile_alamatSingkat').val();
        var alamatLengkap = $('#myprofile_alamatLengkap').val();
        var infoTambahan = $('#myprofile_infoTambahan').val();

        // Menambahkan value ke dalam FormData object
        formData.append('nama', nama);
        formData.append('email', email);
        formData.append('hp', hp);
        formData.append('alamatSingkat', alamatSingkat);
        formData.append('alamatLengkap', alamatLengkap);
        formData.append('infoTambahan', infoTambahan);

        // Mengirim request ke server menggunakan Ajax
        $.ajax({
            type: 'POST',
            cache: false,
            url: '<?php echo e(url("/updateUser")); ?>',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(data) {
                $('#myprofile_nama').val(data.nama);
                $('#myprofile_Email').val(data.email);
                $('#myprofile_hp').val(data.hp);
                $('#myprofile_alamatSingkat').val(data.alamatSingkat);
                $('#myprofile_alamatLengkap').val(data.alamatLengkap);
                $('#myprofile_infoTambahan').val(data.infoTambahan);
                showNty('Success Save')
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    });
    $('#myprofile_Password, #myprofile_Password2').on('input',function(){
        if($('#myprofile_Password').val() != $('#myprofile_Password2').val()){
            $('#alertpass').show()
            $('#myprofile_savepass').prop('disabled',true)
        }else{
            $('#myprofile_savepass').prop('disabled',false)
            $('#alertpass').hide()
        }
    })
    
    $('#myprofile_savepass').click(function(){
        var myprofile_Passwordold = $('#myprofile_Passwordold').val()
        var myprofile_Password = $('#myprofile_Password').val()
        var myprofile_Password2 = $('#myprofile_Password2').val()

        if(myprofile_Passwordold == "" && myprofile_Password == "" && myprofile_Password2 == ""){
            showNty('Please Input Password')
            return false
        }
        if (myprofile_Password.length < 6) {
            showNty('The password must consist of a minimum of 6 characters')
            return false;
        }

        var formData = new FormData();
        formData.append('passwordold', myprofile_Passwordold);
        formData.append('password', myprofile_Password);

        $.ajax({
            type: 'POST',
            cache: false,
            url: '<?php echo e(url("/changePass")); ?>',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(data) {
                if(data == 0){
                    showNty('Old password is incorrect')
                    return false
                }
                $('#myprofile_Passwordold').val("");
                $('#myprofile_Password').val("");
                $('#myprofile_Password2').val("");
                showNty('Success Save')
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    })
</script><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/tabs/myprofile.blade.php ENDPATH**/ ?>