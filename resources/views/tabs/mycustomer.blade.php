<div>  
    <button onclick="changeGridCustomer()" class="btn btn-secondary" style="padding:10px; border-radius:100%; position: absolute; z-index:100;">
      <img style="width: 20px;height:20px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAECklEQVR4nO1Z34tUdRS/WZn9EgNrU3bnnu/dQWEfxNqCiij/gXqKoAcffKjMh4KEVSRaFR8KqW3Ye844aUgIWhsVQRSID770EOGLWaH0S4PWdS13zplZ+yHd+O6O8L1nZ7szu9+Z0ZgPXAbumXO+5/P9cc75nhsEXXTRxaLx+HByE8T8WLSv+oD7HohfMchXDMnvQHLaoHwyMJYsDa4V5GgqMsgj1kFDkhjid105IA/Nvq89KD8F1xIA5UvXQUD5XslfSslJPnDlxiU334Oys2UEDJaf0APmSpVVV+UR8QtpgjzUDAEgHvbmrN274cilFamXSXIDIH9Vm/0pID7cj9N97l9WlZLbzH7psefD/jZMAD3O/IwTyJ8ZkuODpeRmVxYWZQPE/GzvG8mtzdo18xLgUzYweHHeOgzIR519fMCL4cwV4CPBWHKjj0He1sZD5M0tJ0Azz+uLGiCK5Zk6e/ObfKHa65tASLLXkHyrVuEfoPKTCzIexpV7DcpvKoqcdaOMLwJQizZ9o9XVNleo8zCeL1xc3rRxQI5VSPsjjCvrfTl/lQCoUGmw+qAdS439ZlOGo9J0DpD/dI1ExNt9Oj/rrNQNlYD8qtpKlyOSexo2DCR7dAnQzhomPJgs01up8aQ2nCwxyL+mlIv8fNBmAMmL6iz83JCi3YOqvuGBeOKOoM1Ye2DyToNcTUWqRs6gId6hQudYWzyuA0Py8X/VUnVhHVZ777mgQ4h0MUh8OFMJiE+lE0z5oaBD6MfyI4rAyUwlQJl0lfIFvjvoEEKbTFVSy1TS8b+TV8B8IblFJ9NMJZ0FrZHguiKAfD61bOoS0k6Y/dKjotBEphIgf506xPvKDwfX0yE2yEdaUfv7CKOG+L1GlLanWcuHQYdgUD5SK7AtUyk3WrlfEZCeveO3B21GvnBxuSGppHNS5b5sTdtpID6nytktQZthkLeo2T9nfWtQWXareuiHdobT8GCybO4kNtFmsRmwzq2o7v5rRecM1IXG+tL0PdwgF1QEmDYo67TzVubT+X6qDgLyX2rst5o2lKOpu4DkgjrQp9eUeKXrvE8CfaPV1UD8i7qPTC64HoOiPK3Ogp2NE4bkNfedD+fzhWqvQfluzngxP7Uow4A8OpdE+vFBIETerO0CCnlpLdoPE60mYGHbls5Kf+6tP2pDKCCf8UVgJkmhvBxhedOcySI5DiSfLqRZPC/cA5tFwLbgo5gfBSqvtRdzV2YDwEyXG/lyrbo8bzvfWt/rHSTLeU0AqLJR7eN3Ut/SSETpb/Xm7EKc1wR0/gDiQ2mCfCxNkM96aaP7ApB8oeqo9125IdlVk/1ou22dvDDVhZ1x24Kf/bTKf9vejisPi5cgV+SBznnYRRf/L/wLvLYbEazThnQAAAAASUVORK5CYII=">
    </button>
    <div class="mt-4" id="mycustomer-grid" style="display: none;"></div>
    <div class="mt-4" id="myagenda-grid"></div>
</div>
<script>
  function changeGridCustomer(){
    $('#mycustomer-grid').slideToggle()
    $('#myagenda-grid').slideToggle()
  }
  function tblcustomer(){
    // var tblmycustomer = $('#mycustomer-grid').dxDataGrid("instance");
    // tblmycustomer.refresh();
    $('#mycustomer-grid').dxDataGrid({
        // dataSource: {
        //   store: new DevExpress.data.CustomStore({
        //     key: "userid",
        //     load: function(loadOptions) {
        //         var params = {};
        //         if (loadOptions.sort) {
        //             params.sort = JSON.stringify(loadOptions.sort);
        //         }
        //         if (loadOptions.filter) {
        //             params.filter = JSON.stringify(loadOptions.filter);
        //         }
        //         if (loadOptions.skip) {
        //             params.skip = loadOptions.skip;
        //         }
        //         if (loadOptions.take) {
        //             params.take = loadOptions.take;
        //         }
        //         return $.getJSON('dataMycustomer?stamp=' + new Date().getTime(), params);
        //     },
        //     insert: function(values) {
        //       return $.ajax({
        //         url: "{{ url('dataMycustomerInsert') }}",
        //         method: "POST",
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             values: values
        //         }
        //       });
        //     },
        //     update: function(key, values) {
        //       return $.ajax({
        //         url: "{{ url('dataMycustomerUpdate') }}",
        //         method: "POST",
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             values: values,
        //             userid: key
        //         }
        //       });
        //     },
        //     remove: function(key) {
        //       return $.ajax({
        //         url: "{{ url('dataMycustomerDelete') }}",
        //         method: "POST",
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             userid: key
        //         }
        //       });
        //     }
        //   })
        // },
        // remoteOperations: false,
        // columnsAutoWidth: true,
        // showBorders: true,
        // allowColumnResizing: true,
        // filterRow: {
        //   visible: true,
        //   applyFilter: 'auto',
        // },
        // filterPanel: { visible: true },
        // searchPanel: {
        //   visible: true,
        //   width: 240,
        //   placeholder: 'Pencarian . . .',
        // },
        // headerFilter: {
        //   visible: true,
        // },
        // editing: {
        //   mode: 'popup',
        //   allowUpdating: true,
        //   allowAdding: true,
        //   allowDeleting: true,
        //   useIcons: true,
        //   popup: {
        //     title: 'Customer',
        //     showTitle: true,
        //     width: 700,
        //     height: 525,
        //   },
        //   form: {
        //     items: [{
        //         itemType: 'group',
        //         colCount: 2,
        //         colSpan: 2,
        //         items: [
        //             'nama', 
        //             'hp',
        //             'email',
        //             'alamatSingkat', 
        //             {
        //                 dataField: 'alamatLengkap',
        //                 editorType: 'dxTextArea',
        //                 colSpan: 2,
        //                 editorOptions: {
        //                     height: 100,
        //                 },
        //             },
        //             {
        //                 dataField: 'infoTambahan',
        //                 editorType: 'dxTextArea',
        //                 colSpan: 2,
        //                 editorOptions: {
        //                     height: 100,
        //                 },
        //             },
        //         ],
        //     },
        //     {
        //       itemType: 'group',
        //       colCount: 2,
        //       colSpan: 2,
        //       caption: 'Informasi Tambahan',
        //       items: [  
        //         {
        //           dataField: 'InsertDT',
        //           editorOptions: {
        //             readOnly: true,
        //           },
        //         },  
        //         {
        //           dataField: 'UpdateDT',
        //           editorOptions: {
        //             readOnly: true,
        //           },
        //         },  
        //       ],
        //     }],
        //   },
        // },
        dataSource: {
          store: {
            type: 'odata',
            url: '{{url("/dataMycustomer")}}?stamp=' + new Date().getTime(),
            key: 'userid',
          },
        },
        remoteOperations: false,
        columnsAutoWidth: true,
        showBorders: true,
        allowColumnResizing: true,
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
        columns: [
            {
              caption: '',
              width:75,
              cellTemplate: function(container, options) {
                var additionalButton = $('<div>')
                  .addClass('btn btn-secondary p-1')
                  .appendTo(container)
                  .on('dxclick', function() {
                    var val = options.data
                    $.ajax({
                      url: '{{url("/viewformbilling")}}',
                      type: 'GET',
                      cache: false,
                      data: {val},
                      success: function(data) {
                        openmodal("Tagihan "+options.data.nama,data,options.data.userid)
                      },
                      error: function(xhr, status, error) {
                        showNty(error,10000)
                      }
                  });
                  });
                  $('<span>')
                .text('Tagihan')
                .appendTo(additionalButton);
              }
            },
            {
                dataField: 'userid',
                caption: "Customer ID",
                dataType: "number",
                visible: false,
            },
            {
                dataField: 'nama',
                dataType: "string" 
            },
            {
                dataField: 'hp', 
            },
            {
                dataField: 'alamatSingkat',
                dataType: "string" 
            },
            {
                dataField: 'alamatLengkap', 
                visible: false 
            },
            {
                dataField: 'infoTambahan', 
                visible: false 
            },
            {
                dataField: 'email', 
                visible: false 
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

      $('#myagenda-grid').dxDataGrid({
        dataSource: {
          store: {
            type: 'odata',
            url: '{{url("/dataMyagenda")}}?stamp=' + new Date().getTime(),
            key: 'AppointmentId',
          },
        },
        remoteOperations: false,
        columnsAutoWidth: true,
        showBorders: true,
        allowColumnResizing: true,
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
        columns: [
            {
              caption: '',
              width:88,
              cellTemplate: function(container, options) {
                var additionalButton = $('<div>')
                  .addClass('btn btn-secondary p-1')
                  .appendTo(container)
                  .on('dxclick', function() {
                    var val = options.data.AppointmentId
                    $.ajax({
                      url: '{{url("/viewformagenda")}}',
                      type: 'GET',
                      cache: false,
                      data: {val},
                      success: function(data) {
                        openmodal("Pengguna "+options.data.Text,data,options.data.AppointmentId)
                      },
                      error: function(xhr, status, error) {
                        showNty(error,10000)
                      }
                  });
                  });
                  $('<span>')
                .text('Pengguna')
                .appendTo(additionalButton);
              }
            },
            {
                dataField: 'AppointmentId',
                visible: false,
            },
            {
                dataField: 'Text',
            },
            {
                dataField: 'StartDate',
                caption:'Date',
                dataType: 'date',
            },
            {
                dataField: 'description',
            },
            {
                dataField: 'productName',
            },
            {
                dataField: 'frequency',
            },
            {
                dataField: 'pokok',
                dataType: 'number',
                customizeText: function (cellInfo) {
                  return formater.format(cellInfo.value)
                },
                alignment: 'right',
            },
        ],
      }).dxDataGrid('instance');
  }

</script>