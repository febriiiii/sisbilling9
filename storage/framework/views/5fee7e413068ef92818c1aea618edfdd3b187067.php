<style>
  .badge{
    cursor: pointer;
  }
</style>
<div id="myaddbill">
  <h6>Informasi</h6>
  <div class="card p-3">
      <div class="row">
          <div class="col-6 row">
            <div class="col-4">
              Nama Lengkap 
            </div>
            <div class="col-auto">
              : <b><?php echo e($data->namaU); ?></b>
            </div>
          </div>
          <div class="col-6 row">
            <div class="col-4">
              Nama Perusahaan
            </div>
            <div class="col-auto">
              : <b><?php echo e($data->companyname); ?></b>
            </div>
          </div>
          <div class="col-6 row">
            <div class="col-4">
              Alamat Akun 
            </div>
            <div class="col-auto">
              : <b><?php echo e($data->alamatU); ?></b>
            </div>
          </div>
          <div class="col-6 row">
            <div class="col-4">
              Alamat Perusahaan
            </div>
            <div class="col-auto">
              : <b><?php echo e($data->companyaddress); ?></b>
            </div>
          </div>
          <div class="col-6 row">
            <div class="col-4">
              Email Akun
            </div>
            <div class="col-auto">
              : <b><?php echo e($data->emailU); ?></b>
            </div>
          </div>
          <div class="col-6 row">
            <div class="col-4">
              Email Perusahaan
            </div>
            <div class="col-auto">
              : <b><?php echo e($data->emailP); ?></b>
            </div>
          </div>
      </div>
  </div>
  
  <h6 class="mt-4">Buat Tagihan</h6>
  <div class="card">
      <div class="row m-3">
          <div class="col-5">
              <label for="">Tagihan</label>
              <select class="form-select" id="addbillpengelolaProduk" style="font-size: .85em">
                  <?php $__currentLoopData = $produk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($p->productCode); ?>"><?php echo e($p->productName); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
          </div>
          <div class="col-5">
              <label for="">Deskripsi</label>
              <input type="text" id="addbillpengelolaDeskripsi" class="form-control" style="z-index: ">
          </div>
          <div class="col-1 mt-3">
              <button onclick="addbillpengelola()" class="btn btn-info">add</button>
          </div>
      </div>
  
  </div>
  <h6 class="mt-4">Daftar Tagihan</h6>
  <div id="lst" class="card">
      <table class="table align-middle mb-0 bg-white">
          <thead class="bg-light">
            <tr>
              <th>Nama Tagihan</th>
              <th>Aktif</th>
              <th>Tgl Mulai</th>
              <th>Tgl Selesai</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="addbillpengelolatbody">
            <?php if(count($tagihan) != 0): ?>
              <?php $__currentLoopData = $tagihan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr id="TR<?php echo e($t->AppointmentId); ?>">
                <td>
                    <p class="fw-bold mb-1"><?php echo e($t->productName); ?></p>
                    <p class="text-muted mb-0"><?php echo e($t->description); ?></p>
                </td>
                <td>
                  <span class="badge badge-success rounded-pill d-inline" onclick="openVP('<?php echo e($t->notrans); ?>')"><?php echo e($t->Aktif); ?></span>
                </td>
                <td><?php echo e(Carbon\Carbon::parse($t->jatuhTempoTagihan)->format('j F Y')); ?></td>
                <td><?php echo e(Carbon\Carbon::parse($t->FinishDate)->format('j F Y')); ?></td>
                <td>
                  <button type="button" class="btn btn-link btn-sm btn-rounded addbillpengelolaDelTrans" onclick="unsubscribe('<?php echo e($t->AppointmentId); ?>')">
                    Delete
                  </button>
                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <tr>
              <td colspan="5">
                <center><b>Tidak Ada Data</b></center>
              </td>
            </tr>
            <?php endif; ?>
            
          </tbody>
        </table>
  </div>
</div>


<script>
$("#myaddbill").dxScrollView({
        height: "100%",
        width: "100%",
    }).dxScrollView("instance");
$('#myCreateModal').dxPopup('instance').option('fullScreen', true);

  openAddbillpengelola = true;
  function openVP(notrans){
    var val = notrans
    if(val == null){
        return false;
    }
    $.ajax({
    url: '<?php echo e(url("/viewpayment")); ?>',
    type: 'GET',
    cache: false,
    data: {val},
    success: function(data) {
        if(data != 0){
            openmodal2("Form Pembayaran",data)
        }else{
            showNty("Payment Error")
        }
    },
    error: function(xhr, status, error) {
        showNty(error,10000)
    }
    });
  }
    function addbillpengelola(){
      var productCode = $('#addbillpengelolaProduk').val();
      var Deskripsi = $('#addbillpengelolaDeskripsi').val();
      var userid = '<?php echo e($data->userid); ?>';
      if(productCode == ''){
        return false
      }
      $.ajax({
        type: 'POST',
        cache: false,
        url: '<?php echo e(url("/subscribe")); ?>',
        data: {productCode,Deskripsi,userid},
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        },
        success: function(data) {
          description = data[0].description;
          if(data[0].description == null){
            description = '';
          }
          var tr = `<tr id="TR`+data[0].AppointmentId+`">
                    <td>
                        <p class="fw-bold mb-1">`+data[0].productName+`</p>
                        <p class="text-muted mb-0">`+description +`</p>
                    </td>
                    <td>
                      <span class="badge badge-danger rounded-pill d-inline" onclick="openVP(`+data[0].notrans+`)">`+data[0].Aktif+`</span>
                    </td>
                    <td>`+formatDate(data[0].jatuhTempoTagihan)+`</td>
                    <td>`+formatDate(data[0].FinishDate)+`</td>
                    <td>
                      <button type="button" class="btn btn-link btn-sm btn-rounded addbillpengelolaDelTrans" onclick="unsubscribe(`+data[0].AppointmentId+`)">
                        Delete
                      </button>
                    </td>
                  </tr>`
          if('<?php echo e(count($tagihan)); ?>' != '0'){
            $('#addbillpengelolatbody').append(tr)
          }else{
            $('#addbillpengelolatbody').html(tr)
          }
          showNty('success')
        },
        error: function(xhr, status, error) {
          showNty(error,10000)
        }
      });
    }
    
    function unsubscribe(AppointmentId){
        var userid = '<?php echo e($data->userid); ?>';
        $.ajax({
          type: 'POST',
          cache: false,
          url: '<?php echo e(url("/unsubscribe")); ?>',
          data: {AppointmentId,userid},
          beforeSend: function(xhr) {
              xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
          },
          success: function(data) {
            $(`#TR${AppointmentId}`).remove()
            showNty('success')
          },
          error: function(xhr, status, error) {
            showNty(error,10000)
          }
        });
    }
</script><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/admin/modal/addbillpengelola.blade.php ENDPATH**/ ?>