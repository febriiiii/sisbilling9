<div>        
    <div class="mt-4" id="viewmaster-grid"></div>
</div>

<script>
$(() => {
  const dataGrid = $('#viewmaster-grid').dxDataGrid({
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
            return $.getJSON('dataviewmaster?stamp=' + new Date().getTime(), params);
        },
        insert: function(values) {
          return $.ajax({
            url: "<?php echo e(url('dataviewmasterInsert')); ?>",
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
            url: "<?php echo e(url('dataviewmasterUpdate')); ?>",
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
            url: "<?php echo e(url('dataviewmasterDelete')); ?>",
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
      mode: 'popup',
      allowUpdating: true,
      allowAdding: true,
      allowDeleting: true,
      useIcons: true,
      popup: {
        title: 'Master Product',
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
                // {
                //   dataField: 'productCode',
                //   validationRules: [{ type: 'required', message: 'Product Code is required' }],
                // },
                'productName', 
                {
                  dataField: 'producttypeid',
                  validationRules: [{ type: 'required', message: 'Product Type is required' }],
                },
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
            dataType: "string" 
        },
        {
            dataField: 'producttypeid', 
            caption: 'Product Type',
            lookup: {
              dataSource: DevExpress.data.AspNet.createStore({
                key: 'producttypeid',
                loadUrl: `<?php echo e(url('producttype')); ?>?stamp=` + new Date().getTime(),
                onBeforeSend(method, ajaxOptions) {
                  ajaxOptions.xhrFields = { withCredentials: true };
                },
              }),
              displayExpr: 'productTypeName',
              valueExpr: 'producttypeid',
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

</script>
<?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/getView/viewMasterProduct.blade.php ENDPATH**/ ?>