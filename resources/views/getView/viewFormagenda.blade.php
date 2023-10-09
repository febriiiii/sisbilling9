<div class="container">
    <div class="row mb-2">
        <div class="col-sm mt-2"><h5 style="position: absolute; z-index:100;">Daftar Customer</h5><div id="userOut"></div></div>
        <div class="col-sm mt-2"><h5 style="position: absolute; z-index:100;">Daftar Pengguna</h5><div id="userIn"></div></div>
    </div>
    <hr>
    <div class="card" style="background-color: rgb(252, 253, 244)">
        <form id="formAgendaBill">
            <div class="row mt-2 p-2">
                <div class="col-12">
                    <label for="">Keterangan</label>
                    <textarea name="description" class="form-control" cols="10" rows="1" required>{{$agenda->description}}</textarea>
                </div>
                <div class="col-sm-3">
                    <label for="">Pokok</label>
                    <input type="text" name="Pokok" id="viewformagendaPokok" class="numericInput form-control" value="{{$agenda->Pokok}}" required>
                </div>
                <div class="col-sm-3">
                    <label for="">Bunga</label>
                    <input type="number" name="bungaPercent" class="form-control" value="{{$agenda->BungaPercent}}" required>
                </div>
                <div class="col-sm-3">
                    <label for="">Fee</label>
                    <input type="number" name="lateFeePercent" class="form-control" value="{{$agenda->lateFeePercent}}" required>
                </div>
                <div class="col-sm-3">
                    <label for="">Produk</label>
                    <input type="text" name="productCode" class="form-control" value="{{$produk}}" disabled>
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
    $(document).ready(function(){
        $('#viewformagendaPokok').val(formatAngkaDenganKoma($('#viewformagendaPokok').val()))
    })
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

    $('#formAgendaBill').submit(function(event){
        $('#viewformagendaPokok').val(formatAngkaTanpaKoma($('#viewformagendaPokok').val()))
        event.preventDefault();
        var formData = $(this).serialize();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        formData += '&_token=' + csrfToken;
        formData += '&AppointmentId=' + "{{$agenda->AppointmentId}}";
        $.ajax({
            type: 'POST',
            cache: false,
            url: '{{url("/updateagendabill")}}', 
            data: formData,
            success: function(response) {
                new Noty({
                    text: "Success Save",
                    timeout: 2000 
                }).show();
                $('#viewformagendaPokok').val(formatAngkaDenganKoma($('#viewformagendaPokok').val()))
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
                                key: 'userid',
                                loadUrl: '{{url("getUserPinjam")}}',
                                updateUrl: '{{url("putUserPinjam")}}',
                                onBeforeSend: function(method, ajaxOptions) {
                                    ajaxOptions.xhrFields = { withCredentials: true };
                                    ajaxOptions.headers = ajaxOptions.headers || {};
                                    ajaxOptions.headers['X-CSRF-Token'] = "{{csrf_token()}}";
                                    ajaxOptions.data = ajaxOptions.data || {};
                                    ajaxOptions.data.AppointmentId = "{{$agenda->AppointmentId}}";
                                }
                            });
    
    $('#userOut').dxDataGrid(getDataGridConfiguration(0))
    $('#userIn').dxDataGrid(getDataGridConfiguration(1))
                                      
    function onAdd(a) {
        $.ajax({
            type: 'GET',
            url: '{{url("/getPokok?AppointmentId=").$agenda->AppointmentId}}', 
            success: function(agenda) {
                if(agenda[0].Pokok <= 1 ){
                    new Noty({
                        text: "Pokok Tidak Boleh Kosong",
                        timeout: 2000 
                    }).show();
                    return false
                }else{
                    var key = a.itemData.userid;
                    var values = { isUsed: a.toData };
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
            }
        });
    }
    function getDataGridConfiguration(index) {
        return {
            height: 300,
            dataSource: {
                store : storeUserpinjam,
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
                dataField: 'userid',
                dataType: 'string',
                visible: false,
            },{
                dataField: 'nama',
                dataType: 'string',
            },{
                dataField: 'email',
                dataType: 'string',
            },{
                dataField: 'isUsed',
                dataType: 'number',
                visible: false,
            }],
        };
    }
</script>