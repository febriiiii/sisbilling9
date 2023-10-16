<div class="container">
  <div class="row mb-2">
      <div class="col-sm mt-2"><h6>Daftar Produk</h6><div id="userOut"></div></div>
      <div class="col-sm mt-2"><h6>Penggunaan <?php echo e(explode(" ", $nama)[0]); ?></h6><div id="userIn"></div></div>
  </div>
  <hr>
  <div class="card" style="background-color: rgb(252, 253, 244)">
      <form id="formAgendaBill">
          <div class="row mt-2 p-2">
              <div class="col-12">
                  <label for="">Keterangan</label>
                  <textarea id="viewformbillingKeterangan" name="description" class="form-control" cols="10" rows="1" required></textarea>
              </div>
              <div class="col-sm-3">
                  <label for="">Pokok</label>
                  <input id="viewformbillingPokok" type="text" name="Pokok" class="numericInput form-control" value="" required>
              </div>
              <div class="col-sm-3">
                  <label for="">Bunga</label>
                  <input id="viewformbillingBunga" type="number" name="bungaPercent" class="form-control" value="" required>
              </div>
              <div class="col-sm-3">
                  <label for="">Fee</label>
                  <input id="viewformbillingFee" type="number" name="lateFeePercent" class="form-control" value="" required>
              </div>
              <div class="col-sm-3">
                  <label for="">Produk</label>
                  <input id="viewformbillingProduk" type="text" name="productCode" class="form-control" value="" disabled>
                  <input type="hidden" id="viewformbillingPK">
                </div>
          </div>
          <div class="row mt-2 p-2">
              <div class="col d-flex"></div>
              <button type="submit" class="col-sm-2 btn btn-primary me-3">Save</button>
          </div>
      </form>
  </div>
</div>
<script>
  // FORMAT INPUT
  $('.numericInput').on('input', function () {
    var val = $(this).val();
    $(this).val(formatAngkaDenganKoma(val));
  });
  function formatAngkaDenganKoma(angka) {
    angka = angka.replace(/[^0-9.]/g, '');
    var parts = angka.split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    if (parts.length === 2) {
      return parts.join('.') + (parts[1].length === 1 ? '0' : ''); 
    } else {
      return parts[0];
    }
  }
  function formatAngkaTanpaKoma(angka) {
    return parseFloat(angka.replace(/,/g, ''));
  }
  // END OF FORMAT

  var scrollView = $("#primarymodal").dxScrollView({
      height: "100%",
      width: "100%",
  }).dxScrollView("instance");

  var userid = $('#primarymodal').attr('val');
  $('#formAgendaBill').submit(function(event){
    event.preventDefault();
    if($('#viewformbillingPK').val() == ''){
      new Noty({
          text: "Tolong Pilih Produk Pada Dafta Produk",
          timeout: 2000 
      }).show()
      return false;
    }
      $('#viewformbillingPokok').val(formatAngkaTanpaKoma($('#viewformbillingPokok').val()))
      var formData = $(this).serialize();
      var csrfToken = $('meta[name="csrf-token"]').attr('content');
      formData += '&_token=' + csrfToken;
      formData += '&AppointmentId=' + $('#viewformbillingPK').val();
      $.ajax({
          type: 'POST',
          cache: false,
          url: '<?php echo e(url("/updateagendabill")); ?>', 
          data: formData,
          success: function(response) {
              new Noty({
                  text: "Success Save",
                  timeout: 2000 
              }).show();
              $('#viewformbillingPokok').val(formatAngkaDenganKoma($('#viewformbillingPokok').val()))
              tblcustomer()
          },
          error: function(xhr, status, error) {
              new Noty({
                  text: error,
                  timeout: 2000 
              }).show();
          }
      });
  });
  var storeUserpinjam = DevExpress.data.AspNet.createStore({
                              key: 'AppointmentId',
                              loadUrl: '<?php echo e(url("getAgendaPinjam")); ?>',
                              updateUrl: '<?php echo e(url("putAgendaPinjam")); ?>',
                              onBeforeSend: function(method, ajaxOptions) {
                                  ajaxOptions.xhrFields = { withCredentials: true };
                                  ajaxOptions.headers = ajaxOptions.headers || {};
                                  ajaxOptions.headers['X-CSRF-Token'] = "<?php echo e(csrf_token()); ?>";
                                  ajaxOptions.data = ajaxOptions.data || {};
                                  ajaxOptions.data.userid = userid;
                                  ajaxOptions.cache = false;
                              }
                          });
  
  $('#userOut').dxDataGrid(getDataGridConfiguration(0))
  $('#userIn').dxDataGrid(getDataGridConfiguration(1))
  
  function switcheds(key,values){
    $('#loader').show()
    $.ajax({
      type: 'GET',
      cache: false,
      url: '<?php echo e(url("/getPokok?AppointmentId=")); ?>' + key, 
      success: function(agenda) {
          $('#loader').hide()
          if(agenda[0].Pokok <= 1 ){
              new Noty({
                  text: "Pokok Tidak Boleh Kosong",
                  timeout: 2000 
              }).show();
              return false
          }else{
            if(values.isUsed == 1){
                tempUserpinjam.push(key)
            }else{
                var index = tempUserpinjam.indexOf(key);
                if (index !== -1) {
                tempUserpinjam.splice(index, 1);
                }
            }
            storeUserpinjam.update(key, values).then(() => {
                storeUserpinjam.push([{
                    type: 'update', key, data: values,
                }]);
            });
          }
      },
      error: function(xhr, status, error) {
          new Noty({
              text: error,
              timeout: 2000 
          }).show();
          $('#loader').hide()
      }
    });
  }
  function onAdd(a) {
    var key = a.itemData.AppointmentId;
    var values = { isUsed: a.toData };
    if(values.isUsed == 0){
      Swal.fire({
        title: 'Apakah Kamu Yakin?',
        text: "Ingin Menghapus Tagihan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Tidak',
      }).then((result) => {
        if (result.isConfirmed) {
          switcheds(key,values)
        }
      })
    }else{
      switcheds(key,values)
    }
  }
  function getDataGridConfiguration(index) {
    var config = {
        height: 300,
        dataSource: {
            store: storeUserpinjam,
            reshapeOnPush: true,
        },
        searchPanel: { visible: true },
        showBorders: true,
        filterValue: ['isUsed', '=', index],
        rowDragging: {
            data: index,
            group: 'tasksGroup',
            onAdd,
        },
        scrolling: {
            mode: 'virtual',
        },
        columns: [{
            dataField: 'AppointmentId',
            dataType: 'string',
            visible: false,
        }, {
            dataField: 'Text',
            caption: 'Produk',
            dataType: 'string',
        }, {
            dataField: 'Pokok',
            dataType: 'number',
        }, {
            dataField: 'isUsed',
            dataType: 'number',
            visible: false,
        }],
    };

    // Tambahkan pengaturan seleksi ke konfigurasi jika diperlukan
    if (index === 0) {
        config.selection = {
            mode: 'single',
        };

        config.onSelectionChanged = function(selectedItems) {
            var selectedData = selectedItems.selectedRowsData[0].AppointmentId;
            $.ajax({
              type: 'GET',
              cache: false,
              url: '<?php echo e(url("/getPokok?AppointmentId=")); ?>' + selectedData, 
              success: function(agenda) {
                $('#viewformbillingKeterangan').val(agenda[0].description)
                $('#viewformbillingPokok').val(formatAngkaDenganKoma(agenda[0].Pokok))
                $('#viewformbillingBunga').val(agenda[0].BungaPercent)
                $('#viewformbillingFee').val(agenda[0].lateFeePercent)
                $('#viewformbillingProduk').val(agenda[0].description)
                $('#viewformbillingPK').val(agenda[0].AppointmentId)
              },
            });
        };
    }

    return config;
}

</script>

<?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/getView/viewFormbilling.blade.php ENDPATH**/ ?>