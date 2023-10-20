<div class="container">
  <div class="row mb-2">
      <div class="col-sm mt-2"><h6>Daftar Produk</h6><div id="userOut"></div></div>
      <div class="col-sm mt-2"><h6>Penggunaan {{explode(" ", $nama)[0]}}</h6><div id="userIn"></div></div>
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
      showNty("Tolong Pilih Produk Pada Dafta Produk")
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
          url: '{{url("/updateagendabill")}}', 
          data: formData,
          success: function(response) {
            showNty("Success Save")
            $('#viewformbillingPokok').val(formatAngkaDenganKoma($('#viewformbillingPokok').val()))
            tblcustomer()
          },
          error: function(xhr, status, error) {
            showNty(error,10000)
          }
      });
  });
  var storeUserpinjam = DevExpress.data.AspNet.createStore({
                              key: 'AppointmentId',
                              loadUrl: '{{url("getAgendaPinjam")}}?stamp=' + new Date().getTime(),
                              updateUrl: '{{url("putAgendaPinjam")}}?stamp=' + new Date().getTime(),
                              onBeforeSend: function(method, ajaxOptions) {
                                  ajaxOptions.xhrFields = { withCredentials: true };
                                  ajaxOptions.headers = ajaxOptions.headers || {};
                                  ajaxOptions.headers['X-CSRF-Token'] = "{{csrf_token()}}";
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
      url: '{{url("/getPokok?AppointmentId=")}}' + key, 
      success: function(agenda) {
          if(agenda[0].Pokok <= 1 ){
            showNty("Pokok Tidak Boleh Kosong")
          }else if(agenda[0].RecurrenceRule == ''){
            showNty("Anda Belum Menentukan Jadwal Tagihan di Agenda")
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
          $('#loader').hide()
      },
      error: function(xhr, status, error) {
        showNty(error,10000)
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
              url: '{{url("/getPokok?AppointmentId=")}}' + selectedData, 
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
{{-- <div> 
    <div id="viewFormbilling-info" style="display: none;">
        <h6>Informasi Tagihan Produk</h6>  
        <div class="row">
            <div class="col-sm">
                <label for="">Billing</label>
                <input type="text" id="viewFormbilling-text" class="form-control mt-2" readonly>
                <label for="">description</label>
                <textarea class="form-control mt-2" id="viewFormbilling-description" cols="30" rows="3" readonly></textarea>
                <label for="">Product Name</label>
                <input type="text" id="viewFormbilling-productName" class="form-control mt-2" readonly>
            </div>
            <div class="col-sm">
                <label for="">Jatuh Tempo</label>
                <input type="date" id="viewFormbilling-StartDate" class="form-control mt-2" disabled>
            </div>
        </div>
        <hr>
    </div>     
    <h6>Daftar Product</h6> 
    <div class="mt-4" id="viewmaster-grid"></div>
</div>

<script>
var scrollView = $("#primarymodal").dxScrollView({
      height: "100%",
      width: "100%",
  }).dxScrollView("instance");
$(() => {
  const dataGrid = $('#viewmaster-grid').dxDataGrid({
    dataSource: {
      store: new DevExpress.data.CustomStore({
        key: "billingid",
        load: function(loadOptions) {
            var params = {};
            if (loadOptions.sort) {
                params.sort = JSON.stringify(loadOptions.sort);
            }
            if (loadOptions.filter) {
                params.filter = JSON.stringify(loadOptions.filter);
            }
            if (loadOptions.skip) {
                params.skip = loadOptions.skip;
            }
            if (loadOptions.take) {
                params.take = loadOptions.take;
            }
            return $.getJSON('dataBill?userid='+$('#primarymodal').attr('val'), params);
        },
        insert: function(values) {
          return $.ajax({
            url: "{{ url('dataBillInsert') }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                _token: '{{ csrf_token() }}',
                values: values,
                userid: $('#primarymodal').attr('val')
            },
            success: function(){
              $('#viewFormbilling-info').slideUp('slow');
              if (typeof querysaled === 'function') {
                  querysaled()
              }
              if (typeof querysaledBil === 'function') {
                  querysaledBil()
              }
            }
          });
        },
        update: function(key, values) {
          return $.ajax({
            url: "{{ url('dataBillUpdate') }}",
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                values: values,
                billingid: key,
                userid: $('#primarymodal').attr('val')
            },
            success: function(){
              $('#viewFormbilling-info').slideUp('slow');
              querysaled()
            }
          });
        },
        remove: function(key) {
          return $.ajax({
            url: "{{ url('dataBillDelete') }}",
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                billingid: key,
                userid: $('#primarymodal').attr('val')
            },
            success: function(){
              $('#viewFormbilling-info').slideUp('slow');
              querysaled()
            }
          });
        },
      })
    },
    allowColumnResizing: true,
    useIcons: true,
    groupPanel: {
      visible: true,
    },
    remoteOperations: false,
    columnsAutoWidth: true,
    showBorders: true,
    filterRow: {
      visible: true,
      applyFilter: 'auto',
    },
    filterPanel: { visible: true },
    searchPanel: {
      visible: true,
      width: 240,
      placeholder: 'Pencarian . . .',
    },
    headerFilter: {
      visible: true,
    },
    editing: {
      mode: 'form',
      allowUpdating: true,
      allowAdding: true,
      allowDeleting: true,
      useIcons: true,
      popup: {
        title: 'Billing',
        showTitle: true,
        width: 700,
        height: 525,
      },
      form: {
        items: [{
            itemType: 'group',
            colCount: 2,
            colSpan: 2,
            items: [
                'AppointmentId',
                'SisaPok',
            ],
        },{
          itemType: 'group',
          colCount: 2,
          colSpan: 2,
          caption: 'Informasi Tambahan',
          items: [
            {
              dataField: 'InsertDT',
              editorOptions: {
                readOnly: true,
              },
            },  
            {
              dataField: 'UpdateDT',
              editorOptions: {
                readOnly: true,
              },
            },  
          ],
        }],
      },
    },
    onEditorPrepared: function (options) {  
        if (options.parentType == 'dataRow' && options.dataField == 'AppointmentId') {  
            options.editorElement.dxSelectBox('instance').option('onValueChanged', function (e) {  
                $.ajax({
                    type: 'GET',
                    url: '{{url("/appoinmentbillInfo")}}',
                    data:{AppointmentId : e.value},
                    success: function(data) {
                        var date = new Date(data.StartDate);
                        var year = date.getFullYear();
                        var month = ('0' + (date.getMonth() + 1)).slice(-2);
                        var day = ('0' + date.getDate()).slice(-2);
                        var formattedDate = year + '-' + month + '-' + day;
                        $('#viewFormbilling-AppointmentId').val(data.AppointmentId);
                        $('#viewFormbilling-text').val(data.text);
                        $('#viewFormbilling-description').val(data.description);
                        $('#viewFormbilling-productName').val(data.productName);
                        $('#viewFormbilling-StartDate').val(formattedDate);
                        $('#viewFormbilling-info').slideDown('slow');
                        $('.dx-link-cancel').click(function(){
                            cv
                        })
                    },
                    error: function(xhr, status, error) {
                      showNty(error,10000)
                    }
                });
                var newValue = e.value; // Replace with your desired new value
                options.setValue(newValue);
            });  
        }  
    },
    columns: [
        {
            dataField: 'AppointmentId', 
            caption: 'Product',
            lookup: {
              dataSource: DevExpress.data.AspNet.createStore({
                key: 'AppointmentId',
                loadUrl: `{{url('appoinmentbill')}}`,
                onBeforeSend(method, ajaxOptions) {
                  ajaxOptions.xhrFields = { withCredentials: true };
                },
              }),
              displayExpr: 'text',
              valueExpr: 'AppointmentId',
              searchEnabled: true,
            },
        },
        {
            dataField: 'billingid',
            dataType: "string",
            visible: false 
        },
        {
            dataField: 'userid',
            dataType: "string",
            visible: false 
        },
        {
            dataField: 'SisaPok',
            caption: "Total Pokok",
            dataType: 'number',
            customizeText: function (cellInfo) {
              return formater.format(cellInfo.value)
            },
        },
        {
            dataField: 'InsertDT', 
            caption: "Tgl Dibuat",
            dataType: 'date',
            visible: false 
        },
        {
            dataField: 'UpdateDT', 
            caption: "Tgl Diubah",
            dataType: 'date',
            visible: false 
        },
    ],
  }).dxDataGrid('instance');
});
</script> --}}
