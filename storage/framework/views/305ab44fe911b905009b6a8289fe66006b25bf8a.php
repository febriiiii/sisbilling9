
<?php $__env->startSection('content'); ?>
<button onclick="window.history.back()" class="btn btn-primary m-3" style="padding:5px 10px 5px 5px; border-radius:100%;"><i class="las la-backspace" style="font-size: 40px;"></i></button>
<div class="container" style="padding-bottom: 15vh;"> 
    <div class="container" style="margin-top:15vh; z-index:3;">
        <?php echo csrf_field(); ?>
        <center>
            <div style="max-width: 500px">
                <h3>Lupa Password ? </h3>
                <form class="input-group mb-3" id="submitmailotp">
                    <input placeholder="Email" class="form-control" name="email" type="email" id="displayForgot_email" class="form-control " required/>
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-primary">
                        <img width="18" height='18' src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAACXBIWXMAAAsTAAALEwEAmpwYAAAEdUlEQVR4nO2aTW/TWBSGLdggVsOSDWKFRpo/gBBL+A1sWLNlx441rNDsoapACNQWcCFVStqkJpA2bXHrxl83uLHDR1WVxmZgpEGiaDjIgbSJ61zf61x/xO2RzqZxrvWcnuQ9fnM47jAO48CE/O7ziZqxdXVZ3njJHZQAgKOaaV/QLWdcVDa+z1UboDVaE1zWQ1t3/kKmfRNZzpZm2lB+3YT8CwTKeutHs/nvn1xWWxxZzhVkOSKyHHBzVd+CvKDD1JwGK9omINPZ5LLa4siyv3XAkWXDvPgWJmeUNnyhYrT/rln2DS5rLY52oX9l7c1HKJTrwBfkNvzDqRVApg26Zf8vinCcy1KLI09WpfcwOavswo+MLYDaaP16vWGvctlpcacnFaMFsxWjDd6Bvz1WgWXlw9411udLXBZaHHlySd6AZ0V1H3y+rO1dZ9pfuSy0OOpKt7VL1fVd8G74B0+XQTf3rtUtm+eGucWRJ1fUTZgqab7wIxMVUIztnutTp/0aRYt3Z2eomZyRfeHdXJDe9b4vLdovU7a4NztDTTe4F/5ZSdlftCS1H0K2eG/uDTU4+Lu8+7m3e96bmPZrIVscN9Tg4N2s1T/uPyNO7ZcHbHHcUBME/0ps+s8HUWs/MGlx/FATBM/P1ED3OytK7dcYtXjQUBMEP8pX28rgdxZz7ZcZt3jQUBME76akb/U9k4n2QwQtTjLUkMALS43+5w6q/VpELU4y1JDAj+dX8WeH0X45whYnHWpI4EcnFl1fr+/ZobRfN52/kWXvRA2OG2pI4N1sW1u4e4TRftX8dEo3bTNKeNxQQwrfsbZwGVr71QiLgBtqSOE71hb2XoNqv8q4CEFDDSl8j7WFSSbarzIqQtBQQwrvtbZwyey5Xx2gCCRDDQ18j7WFbX/Gz/1qiCKQDDU08F5rC5eRPPerhEUgHWpo4P2sLcxnP7rnfjWgCKRDDQ28r7WFy6if+1XfIpAPNbTwftYWVm3i8PzVriLQDDW08H7WFv7LL0bPHzX/Ob0gvf9COtTsgxfw8H2trai1nyZyJW0niv88ztqKRftJQhCaxyYL7D/zWGsrTu0PimLVuBgFPM7ail37cSEsWddZwwdZW4lof78oLqw/Zg2PtbaS1H6/mK0Yayzhg6ytxLXfG9Nl1GIFH2RtpUb7aSSQFJ7I2kqT9pNIIA08ibWVGu0nkUAaeCJrK03aHySBNPCk1laqtB8ngTTwNNZWqrS/nwTSwhNbW2nT/k48L9e3w8Df4xe/TUxLht5oDfzbYqK7frnfEoiDvzM2D/efLv/3aFpayxWVW8J8fffbWm9+OTvQr09J7voJvyXQCz/yaP7Hw5zo8IW1F7k55ZogSH/gzhmkCInu+hWrxkUX/h6/uDOel0y+VHsyJWiXAeAI7Vlhi5Dorp8obp+cfWmeYXUeeuuc0037e+q1P8qg6YTM7PmHKcLQ7/kPXIRh3PNnWYSh2vNnXoRh2POPsgip3fOPqwip2/OPK+rmp/N6w5Ziu+FhcAczfgImbNaj6l8OQQAAAABJRU5ErkJggg==">
                    </button>
                </form>
                <h6><i style="color: red">Cek spam anda jika email tidak ditemukan di kotak masuk</i></h6>
                
                <form id="otp" style="display: none">
                    <hr>
                    <h4>One Time Password</h4>
                    <div class="form-outline mt-3">
                        <input name="otp" type="otp" id="displayForgot_otp" class="form-control" required/>
                        <label class="form-label" for="displayForgot_email">Massukan OTP Anda</label>
                    </div>
                    <button type="submit" class="btn btn-primary col-12 mt-4" style="z-index: 3;">Submit</button>
                </form>
                <div id="contentpass">

                </div>
                <form id="newpas" class="row" style="margin:0; display:none;" action="<?php echo e(url('/confirmotp')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="otp" id="otppasstemp">
                    <input type="hidden" name="mail" id="otpmailtemp">

                    <div id="alertpass" style="display:none;" class="alert alert-danger">Password Tidak Sama</div>
                    <div class="form-outline col mt-3">
                        <input name="password" type="password" id="displayForgot_password" class="form-control" required/>
                        <label class="form-label" for="displayForgot_password">New Password</label>
                    </div>
                    <div class="col-1"></div>
                    <div class="form-outline col mt-3">
                        <input name="password2" type="password" id="displayForgot_password2" class="form-control" required/>
                        <label class="form-label" for="displayForgot_password2">Confirm New Password</label>
                    </div>
                    <button type="submit" class="btn btn-primary col-12 mt-4" style="z-index: 3;">Change Password</button>
                </form>
            </div>
        </center>
    </div>
</div>
<img src="<?php echo e(asset('public/wave.svg')); ?>" style="bottom:0; position: fixed; z-index:-1;">
<script>
    $(document).ready(function() {
        $('#displayForgot_pilihPengelola').select2();
        $('body').css('background-color','transparent')
    });
    $('#displayForgot_password, #displayForgot_password2').on('input',function(){
        if($('#displayForgot_password').val() != $('#displayForgot_password2').val()){
            $('#alertpass').show()
        }else{
            $('#alertpass').hide()
        }
    })
    $('#submitmailotp').submit(function(e){
        e.preventDefault()
        new Noty({
            text: 'Send OTP',
            timeout: 2000 
        }).show();
        $.ajax({
            url: '<?php echo e(url("otp")); ?>',
            type: 'POST',
            cache: false,
            data: $(this).serialize(),
            success: function(response) {
                console.log(response);
                if(response == 0){
                    new Noty({
                        text: 'Email Tidak Ditemukan',
                        timeout: 4000 
                    }).show();
                }else{
                    var email = $('#displayForgot_email').val()
                    new Noty({
                        text: 'OTP Berhasil Dikirim',
                        timeout: 2000 
                    }).show();
                    $('#otp').show()
                    $('#otp').unbind()
                    $('#otp').submit(function(f){
                        f.preventDefault()
                        if(response - 1234 == $('#displayForgot_otp').val()){
                            $('#otp').hide()
                            $('#newpas').show()
                            $('#otpmailtemp').val(email)
                            $('#otppasstemp').val(response)
                        }else{
                            new Noty({
                                text: 'OTP Tidak Sama',
                                timeout: 2000 
                            }).show();
                        }
                    })
                }
            }
        });
    })
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/displayForgot.blade.php ENDPATH**/ ?>