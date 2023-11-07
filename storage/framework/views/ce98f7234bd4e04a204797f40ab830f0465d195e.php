<div id="gridTagihan"></div>
<script>
    $(() => {
        const dataGrid = $('#gridTagihan').dxDataGrid({
            dataSource: {
            store: new DevExpress.data.CustomStore({
                key: "productCode",
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
                    return $.getJSON('dataTagihan?stamp=' + new Date().getTime(), params);
                },
                insert: function(values) {
                return $.ajax({
                    url: "<?php echo e(url('dataTagihanInsert')); ?>",
                    method: "POST",
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        values: values
                    },
                    success: function(data) {
                    if (data == 0) {
                        showNty("Kode Produck (Product Code) Telah Digunakan")
                        return false
                    }
                    }
                });
                },
                update: function(key, values) {
                return $.ajax({
                    url: "<?php echo e(url('dataTagihanUpdate')); ?>",
                    method: "POST",
                    cache: false,
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        values: values,
                        productCode: key
                    }
                });
                },
                remove: function(key) {
                return $.ajax({
                    url: "<?php echo e(url('dataTagihanDelete')); ?>",
                    method: "POST",
                    cache: false,
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        productCode: key
                    }
                });
                }
            })
            },
            allowColumnResizing: true,
            remoteOperations: false,
            columnsAutoWidth: true,
            showBorders: true,
            filterRow: {
            visible: true,
            applyFilter: 'auto',
            },
            headerFilter: {
            visible: true,
            },
            editing: {
                allowUpdating: true,
                allowAdding: true,
                allowDeleting: true,
                useIcons: true,
            },
            columns: [
                {
                    dataField: 'productCode',
                    caption: "Product Code",
                    dataType: "string", // atau "string", "date", dll.
                    calculateCellValue: data => {
                        return data.productCode;
                    },
                    visible:false
                },
                {
                    dataField: 'productName',
                    caption: 'Nama Tagihan',
                    dataType: "string" 
                },
                {
                    dataField: 'price',
                    dataType: "number",
                },
                {
                    dataField: 'disc',
                    dataType: "number",
                },
                {
                    dataField: 'rangeDuration',
                    caption: 'Jangka Waktu',
                    dataType: "number" 
                },
                {
                    dataField: 'duration', 
                    caption: 'Durasi',
                    lookup: {
                    dataSource: [
                        { duration: 'Hari', durationName: 'Hari' },
                        { duration: 'Minggu', durationName: 'Minggu' },
                        { duration: 'Bulan', durationName: 'Bulan' },
                        { duration: 'Tahun', durationName: 'Tahun' },
                    ],
                    displayExpr: 'durationName',
                    valueExpr: 'duration',
                    },
                },
            ],
        }).dxDataGrid('instance');
        });    
</script><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/admin/tagihan.blade.php ENDPATH**/ ?>