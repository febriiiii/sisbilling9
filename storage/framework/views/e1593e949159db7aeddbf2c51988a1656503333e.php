<div class="container">
    <div class="row mb-2">
        <div class="col-sm mt-2"><h6>Daftar Customer</h6><div id="userOut"></div></div>
        <div class="col-sm mt-2"><h6>Daftar Pengguna</h6><div id="userIn"></div></div>
    </div>
    <hr>
    <div class="card" style="background-color: rgb(252, 253, 244)">
        <form id="formAgendaBill">
            <div class="row mt-2 p-2">
                <div class="col-12">
                    <label for="">Keterangan</label>
                    <textarea name="description" class="form-control" cols="10" rows="1" required><?php echo e($agenda->description); ?></textarea>
                </div>
                <div class="col-sm-3">
                    <label for="">Pokok</label>
                    <input type="text" name="Pokok" id="viewformagendaPokok" class="numericInput form-control" value="<?php echo e($agenda->Pokok); ?>" required>
                </div>
                <div class="col-sm-3">
                    <label for="">Bunga</label>
                    <input type="number" name="bungaPercent" class="form-control" value="<?php echo e($agenda->BungaPercent); ?>" required>
                </div>
                <div class="col-sm-3">
                    <label for="">Fee</label>
                    <input type="number" name="lateFeePercent" class="form-control" value="<?php echo e($agenda->lateFeePercent); ?>" required>
                </div>
                <div class="col-sm-3">
                    <label for="">Produk</label>
                    <input type="text" name="productCode" class="form-control" value="<?php echo e($produk); ?>" disabled>
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
        formData += '&AppointmentId=' + "<?php echo e($agenda->AppointmentId); ?>";
        $.ajax({
            type: 'POST',
            cache: false,
            url: '<?php echo e(url("/updateagendabill")); ?>', 
            data: formData,
            success: function(response) {
                showNty('Success Save')
                $('#viewformagendaPokok').val(formatAngkaDenganKoma($('#viewformagendaPokok').val()))
                tblcustomer()
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    });
    var storeUserpinjam = DevExpress.data.AspNet.createStore({
                                key: 'userid',
                                loadUrl: '<?php echo e(url("getUserPinjam")); ?>?stamp=' + new Date().getTime(),
                                updateUrl: '<?php echo e(url("putUserPinjam")); ?>?stamp=' + new Date().getTime(),
                                onBeforeSend: function(method, ajaxOptions) {
                                    ajaxOptions.xhrFields = { withCredentials: true };
                                    ajaxOptions.headers = ajaxOptions.headers || {};
                                    ajaxOptions.headers['X-CSRF-Token'] = "<?php echo e(csrf_token()); ?>";
                                    ajaxOptions.data = ajaxOptions.data || {};
                                    ajaxOptions.data.AppointmentId = "<?php echo e($agenda->AppointmentId); ?>";
                                }
                            });
    
    $('#userOut').dxDataGrid(getDataGridConfiguration(0))
    $('#userIn').dxDataGrid(getDataGridConfiguration(1))
    
    function switcheds(key,values){
        $('#loader').show()
        $.ajax({
            type: 'GET',
            url: '<?php echo e(url("/getPokok?AppointmentId=").$agenda->AppointmentId); ?>', 
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
        isAdding = true;
        var values = { isUsed: a.toData };
        if(a.itemData.length == 0){
            return false;
        }
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
                    a.itemData.forEach(data => {
                        switcheds(data.userid,values)
                    });
                }
            })
        }else{
            a.itemData.forEach(data => {
                switcheds(data.userid,values)
            });
        }
    }
    var isAdding = false;
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
                onDragStart: function (e) {
                    const selectedData = e.component.getSelectedRowsData().sort((a, b) => a.OrderIndex > b.OrderIndex ? 1 : -1);
                    e.itemData = selectedData 
                },
                dragTemplate: function(dragData) {
                    const itemsContainer = $("<table>").addClass("drag-container");
                    dragData.itemData.forEach((rowData => {
                        const itemContainer = $("<tr>");
                        for (field in rowData) {
                            if(field != 'userid' && field != 'isUsed'){
                                itemContainer.append($("<td>").text(rowData[field]));
                            }
                        }
                        itemsContainer.append(itemContainer);
                    }));
                    return $("<div>").append(itemsContainer);
                },
                onDragEnd: function(e) {
                    isAdding = false;
                    setTimeout(() => {
                        if(isAdding){
                            e.component.clearSelection();
                        }
                    }, 2000);
                },
                onAdd,
            },
            selection: { mode: "multiple" },
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
</script><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/getView/viewformagenda.blade.php ENDPATH**/ ?>