
<style>
    #dropzone-external {
  width: fit-content;
  height: fit-content;
  background-color: rgba(183, 183, 183, 0.1);
  border-width: 2px;
  border-style: dashed;
  padding: 10px;
}

#dropzone-external > * {
  pointer-events: none;
}

#dropzone-external.dropzone-active {
  border-style: solid;
}

.widget-container > span {
  font-size: 22px;
  font-weight: bold;
  margin-bottom: 16px;
}

#dropzone-image {
  max-width: 100%;
  max-height: 100%;
}

#dropzone-text > span {
  font-weight: 100;
  opacity: 0.5;
}

#upload-progress {
  display: flex;
  margin-top: 10px;
}

.flex-box {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
</style>
<form class="row" style="padding: 0 20px 0 20px; margin:0;" id="viewpayment-submit">
    <?php echo csrf_field(); ?>
    <h6>Informasi</h6><hr>
    <?php echo $__env->make('receipt', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <h6 class="mt-4">Metode Pembayaran</h6><hr>
    <div class="col-6">
        <label class="mt-2" for="">Invoice No.</label>
        <input id="transG" type="text" class="form-control" name="notrans" value="<?php echo e($trans->notrans); ?>" readonly>
    </div>
    <div class="col-6">
        <label class="mt-2" for="">Tagihan</label>
        <input type="text" class="form-control" value="<?php echo e(number_format($trans->Amount)); ?>" readonly>
    </div>
    <div class="col-6">
        <label class="mt-2" for="">Metode Pembayaran</label>
        <select id="viewpayment-paymentid" onchange="viewPaymentPaymentid(this.value)" class="form-control form-select" name="paymentid">
            <?php $__currentLoopData = $paymentMethod; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $selected = "";
                if ($p->paymentid == $trans->paymentid) {
                    $selected = "selected";
                }
            ?>
            <option <?php echo e($selected); ?> value="<?php echo e($p->paymentid); ?>"><?php echo e($p->paymentName); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="col-6">
        <label class="mt-2" for="">Atas Nama</label>
        <input id="viewPayment-AtasNama" type="text" class="form-control" value="-" readonly>
    </div>
    <div class="col-6">
        <label class="mt-2" for="">No Rek Tujuan</label>
        <input id="viewPayment-RekTujuan" type="text" class="form-control" value="-" readonly>
    </div>
    <div class="col-12 mt-2 p-3">
        <div class="widget-container flex-box">
            <div id="dropzone-external" class="flex-box dx-theme-border-color">
            <img id="dropzone-image" src="#" hidden alt="" style="max-height:300px; max-width:250px;"/>
            <div id="dropzone-text" class="flex-box">
                <span>Seret Bukti Pembayaran</span>
                <span>Atau Klik Ini.</span>
            </div>
            <div id="upload-progress"></div>
            </div>
            <div id="file-uploader"></div>
        </div>
    </div>
    <?php if($trans->statusid == 5 || $trans->statusid == 11): ?>
        <?php if($trans->companyid != session('UIDGlob')->companyid): ?>
        <div class="onpay row">
            <button type="submit" class="col-5 btn btn-success mt-4" name="reject" value="0">Bayar Tagihan</button>
            <div class="col-2"></div>
            <button id="gatewayClose" <?php if($trans->statusid == 11): ?> style="display: none;" <?php endif; ?> type="button" class="col-5 btn btn-primary mt-4" onclick="payGateway(event)" name="reject" value="0">Gunakan Payment Gateway</button>
            <div id="gatewayOpen" class="col-5 mt-4" <?php if($trans->statusid != 11): ?> style="display: none;" <?php endif; ?>>
                <div class="btn-group" style="width: 110%;">
                    <button type="button" onclick="payGateway(event)" class="btn btn-primary">Menungu Pembayaran</button>
                    <button type="button" onclick="payExpire()" class="btn btn-danger">Tutup Pembayaran</button>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="onpay">
            <button type="button" onclick="voidtrans()" class="btn btn-danger mt-4" name="reject" value="0">Void</button>
        </div>
        <?php endif; ?>
    <?php elseif($trans->statusid == 6): ?>
        <?php if($trans->companyid == session('UIDGlob')->companyid): ?>
            <button type="submit" class="col-5 btn btn-danger mt-4" name="reject" value="1">Tolak Pembayaran</button>
            <div class="col-2"></div>
            <button type="submit" class="col-5 btn btn-success mt-4" name="reject" value="0">Konfirmasi Pembayaran</button>
        <?php endif; ?>
    <?php elseif($trans->statusid == 7): ?>
            <center>
                <h3 class="mt-4" style="color:red;">LUNAS</h3>
            </center>
    <?php elseif($trans->statusid == 13): ?>
        <center>
            <h3 class="mt-4" style="color:red;">VOID</h3>
        </center>
    <?php endif; ?>
    <div id="PayloadMID"></div>
</form>

<script>
    transG = '<?php echo e($trans->notrans); ?>'
    var snapToken = '<?php echo e($snapToken); ?>';
    $('#viewpayment-submit').submit(function(event){
        $('#loader').show('slow')
        event.preventDefault();
        var form = new FormData();
        var fileInput = $('#file-uploader').dxFileUploader('instance');
        var file = fileInput.option('value');
        form.append('files', file[0]);

        // Tambahkan data lain yang diperlukan ke dalam FormData
        form.append('paymentid', $('#viewpayment-paymentid').val());
        form.append('notrans', transG);
        form.append('reject', $('button[name="reject"]:focus').val());

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?php echo e(url("/confirmPembayaran")); ?>', true);
        xhr.setRequestHeader('Cache-Control', 'no-store'); // CACHE FALSE
        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = xhr.responseText;
                new Noty({
                    text: response,
                    timeout: 2000 
                }).show();
                if(response == 'Success'){
                    renderlonceng()
                    closemodal2()
                    loadbilling()
                    
                    if (typeof querysaled === 'function') {
                        querysaled()
                    }
                    if (typeof querysaledBil === 'function') {
                        querysaledBil()
                    }
                }
            } else {
                console.log(xhr.status);
            }
            $('#loader').hide('slow')
        };

        xhr.send(form);
    }) 
    
    function voidtrans(){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '<?php echo e(url("/voidtrans")); ?>', //status = 13
            data: {transG},
            success: function(data) {
                if (typeof querysaled === 'function') {
                    querysaled()
                }
                if (typeof querysaledBil === 'function') {
                    querysaledBil()
                }
                closemodal2()
                loadbilling()
            },
            error: function(xhr, status, error) {
                new Noty({
                    text: error,
                    timeout: 10000,
                }).show();
            }
        });
    }
    
    function payGateway(event){
        event.preventDefault();
        if(snapToken == null || snapToken == ''){
            closemodal2()
            new Noty({
                text: 'Jaringan Bermasalah,Tolong Buka ulang Tagihan',
                timeout: 5000,
            }).show();
            return false
        }
        snap.pay(snapToken, {
            onSuccess: function(result) {
                paymentsuccess()
            },
            onPending: function(result) {
                paymentsuccess()
                $('#gatewayClose').hide()
                $('#gatewayOpen').show()
            },
            onError: function(result) {
                paymentsuccess()
            },
            onClose: function(result){
                paymentsuccess()
            }
        });
    }
    function payExpire(){
        $('#loader').show('slow')
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            cache: false,
            url: '<?php echo e(url("/confirmPembayaranMID")); ?>',
            data: {'notrans' : transG, 'type' : 'expire'},
            success: function(data) {
                snapToken = data.snapToken //update dari tbltrans terbaru 
                transG = data.transG //update dari tbltrans terbaru
                $('#transG').val(transG)
                $('#transGR').html(' : '+transG)
                $('#gatewayClose').show()
                $('#gatewayOpen').hide()
                $('#loader').hide('slow')
                loadbilling()
            },
            error: function(xhr, status, error) {
                new Noty({
                    text: error,
                    timeout: 10000 
                }).show();
                $('#loader').hide('slow')
            }
        });
    }
    
    var paymentmethod = JSON.parse(`<?php echo e($paymentMethod); ?>`.replace(/&quot;/g, '"'));
    function viewPaymentPaymentid(id){
        var selectedPayment = paymentmethod.find(function(payment) {
            return payment.paymentid == id;
        });
        $('#viewPayment-RekTujuan').val(selectedPayment.RekTujuan);
        $('#viewPayment-AtasNama').val(selectedPayment.AtasNama);
        $('#pembayaranRecipt').html($('#viewpayment-paymentid option:selected').text())
    }
    setTimeout(() => {
        $('#pembayaranRecipt').html($('#viewpayment-paymentid option:selected').text())
    }, 500);
</script>
<script>
    var scrollView = $("#primarymodal2").dxScrollView({
        height: "100%",
        width: "100%",
    }).dxScrollView("instance");
    $(() => {
        var dropZoneImage = document.getElementById('dropzone-image');
        var dropZoneText = document.getElementById('dropzone-text');
        imagePath = '<?php echo e($file); ?>';
        if(imagePath != ''){
            dropZoneImage = document.getElementById('dropzone-image');
            dropZoneImage.src = imagePath;
        }
        
        $('#file-uploader').dxFileUploader({
            dialogTrigger: '#dropzone-external',
            dropZone: '#dropzone-external',
            multiple: false,
            allowedFileExtensions: ['.jpg', '.jpeg', '.gif', '.png'],
            uploadMode: 'instantly',
            visible: false,
            onDropZoneEnter(e) {
                if (e.dropZoneElement.id === 'dropzone-external') { toggleDropZoneActive(e.dropZoneElement, true); }
            },
            onDropZoneLeave(e) {
                if (e.dropZoneElement.id === 'dropzone-external') { toggleDropZoneActive(e.dropZoneElement, false); }
            },
            onUploaded(e) {
                var { file } = e;
                var dropZoneText = document.getElementById('dropzone-text');
                var fileReader = new FileReader();
                fileReader.onload = function () {
                    toggleDropZoneActive(document.getElementById('dropzone-external'), false);
                    var dropZoneImage = document.getElementById('dropzone-image');
                    dropZoneImage.src = fileReader.result;
                };
                fileReader.readAsDataURL(file);
                dropZoneText.style.display = 'none';
                uploadProgressBar.option({
                    visible: false,
                    value: 0,
                });
            },
            onProgress(e) {
                uploadProgressBar.option('value', (e.bytesLoaded / e.bytesTotal) * 100);
            },
            onUploadStarted() {
                toggleImageVisible(false);
                uploadProgressBar.option('visible', true);
            },
        });

        var uploadProgressBar = $('#upload-progress').dxProgressBar({
            min: 0,
            max: 100,
            width: '30%',
            showStatus: false,
            visible: false,
        }).dxProgressBar('instance');

        function toggleDropZoneActive(dropZone, isActive) {
            if (isActive) {
                dropZone.classList.add('dx-theme-accent-as-border-color');
                dropZone.classList.remove('dx-theme-border-color');
                dropZone.classList.add('dropzone-active');
            } else {
                dropZone.classList.remove('dx-theme-accent-as-border-color');
                dropZone.classList.add('dx-theme-border-color');
                dropZone.classList.remove('dropzone-active');
            }
        }

        function toggleImageVisible(visible) {
            var dropZoneImage = document.getElementById('dropzone-image');
            dropZoneImage.hidden = !visible;
        }

        document.getElementById('dropzone-image').onload = function () { toggleImageVisible(true); };
    });

</script><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/getView/viewPayment.blade.php ENDPATH**/ ?>