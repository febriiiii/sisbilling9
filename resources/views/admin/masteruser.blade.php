<div id="gridPengelola"></div>

<script>
    loadlistpengelola()
    function loadlistpengelola(){
    $('#gridPengelola').dxDataGrid({
        dataSource: {
          store: new DevExpress.data.CustomStore({
            key: "userid",
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
                return $.getJSON('datamasteruser?stamp=' + new Date().getTime(), params);
            },
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
        filterPanel: { visible: true },
        columns: [
            {
                dataField: 'userid',
                dataType: "string", // atau "string", "date", dll.
                calculateCellValue: data => {
                    return data.userid;
                },
                visible:false
            },
            {
                dataField: 'nama',
                dataType: "string" 
            },
            {
                dataField: 'emailU',
                dataType: "string" 
            },
            {
                dataField: 'alamatU',
                dataType: "string" 
            },
            {
                dataField: 'companyname',
                caption: 'Nama P',
                dataType: "string" 
            },
            {
                dataField: 'emailP',
                dataType: "string" 
            },
            {
                dataField: 'alamatP',
                dataType: "string" 
            },
            {
                dataField: 'hp',
                dataType: "string" 
            },
            {
                dataField: 'perusahaanTerkait',
                dataType: "string",
                cellTemplate: function(container, options) {
                    var comp = options.data.perusahaanTerkait ? options.data.perusahaanTerkait.split(',') : [];
                    comp.forEach(c => {
                        var historyButton = $('<span class="badge badge-info rounded-pill d-inline">'+c+'<span>');
                        container.append(historyButton);                    
                    });
                } 
            },
            {
                dataField: 'statusBayar',
                caption:'Status Paket',
                dataType: "string" 
            },
        ],
      }).dxDataGrid('instance');
    }

    
    </script>