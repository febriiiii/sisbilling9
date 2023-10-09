<div>        
    <div class="mt-4" id="viewpaymentmethod-grid"></div>
</div>

<script>
$(() => {
  const dataGrid = $('#viewpaymentmethod-grid').dxDataGrid({
    dataSource: {
      store: new DevExpress.data.CustomStore({
        key: "paymentid",
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
            return $.getJSON('dataviewpaymentmethod?stamp=' + new Date().getTime(), params);
        },
        insert: function(values) {
          return $.ajax({
            url: "<?php echo e(url('dataviewpaymentmethodInsert')); ?>",
            method: "POST",
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                values: values
            }
          });
        },
        update: function(key, values) {
          return $.ajax({
            url: "<?php echo e(url('dataviewpaymentmethodUpdate')); ?>",
            method: "POST",
            cache: false,
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                values: values,
                paymentid: key
            }
          });
        },
        remove: function(key) {
          return $.ajax({
            url: "<?php echo e(url('dataviewpaymentmethodDelete')); ?>",
            method: "POST",
            cache: false,
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                paymentid: key
            }
          });
        }
      })
    },
    allowColumnResizing: true,
    // groupPanel: {
    //   visible: true,
    // },
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
      mode: 'popup',
      allowUpdating: true,
      allowAdding: true,
      allowDeleting: true,
      useIcons: true,
      popup: {
        title: 'Payment Method',
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
                'paymentName', 
                'RekTujuan', 
                'AtasNama', 
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
    columns: [
        {
            dataField: 'paymentid',
            caption: "Product ID",
            dataType: "string", // atau "string", "date", dll.
            calculateCellValue: data => {
                return data.paymentid;
            },
            visible: false 
        },
        {
            dataField: 'paymentName',
            dataType: "string" 
        },
        {
            dataField: 'RekTujuan',
            dataType: 'string',
        },
        {
            dataField: 'AtasNama',
            dataType: 'string',
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

</script>
<?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/getView/viewPaymentMethod.blade.php ENDPATH**/ ?>