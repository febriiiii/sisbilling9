<div>        
    <div class="mt-4" id="viewproducttype-grid"></div>
</div>

<script>
$(() => {
  const dataGrid = $('#viewproducttype-grid').dxDataGrid({
    dataSource: {
      store: new DevExpress.data.CustomStore({
        key: "producttypeid",
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
            return $.getJSON('dataviewproducttype?stamp=' + new Date().getTime(), params);
        },
        insert: function(values) {
          return $.ajax({
            url: "{{ url('dataviewproducttypeInsert') }}",
            method: "POST",
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                _token: '{{ csrf_token() }}',
                values: values
            }
          });
        },
        update: function(key, values) {
          return $.ajax({
            url: "{{ url('dataviewproducttypeUpdate') }}",
            method: "POST",
            cache: false,
            data: {
                _token: '{{ csrf_token() }}',
                values: values,
                producttypeid: key
            }
          });
        },
        remove: function(key) {
          return $.ajax({
            url: "{{ url('dataviewproducttypeDelete') }}",
            method: "POST",
            cache: false,
            data: {
                _token: '{{ csrf_token() }}',
                producttypeid: key
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
    //   mode: 'popup',
      allowUpdating: true,
      allowAdding: true,
      allowDeleting: true,
      useIcons: true,
      popup: {
        title: 'Product Type',
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
                'productTypeName', 
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
            dataField: 'producttypeid',
            caption: "Product ID",
            dataType: "string", // atau "string", "date", dll.
            calculateCellValue: data => {
                return data.producttypeid;
            },
            visible: false 
        },
        {
            dataField: 'productTypeName',
            dataType: "string" 
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
