<div id="gridPengelola"></div>
<script>
    $(() => {
      const dataGrid = $('#gridPengelola').dxDataGrid({
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
                return $.getJSON('dataPengelola?stamp=' + new Date().getTime(), params);
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
                dataField: 'billAktif',
                dataType: "string" 
            },
            {
                dataField: 'isAktif',
                caption: 'Status',
                cellTemplate: function(container, options) {
                    var isAktif = options.data.isAktif;
                    var userid = options.data.userid;
                    var selectBox = $("<select class='form-select' style='padding:0 0 0 5px;font-size:.9em;'>");
                    selectBox.appendTo(container);

                    // Tambahkan opsi untuk select box
                    var activeOption = $("<option>");
                    activeOption.text("Aktif");
                    activeOption.val(1);
                    var inactiveOption = $("<option>");
                    inactiveOption.text("Tidak Aktif");
                    inactiveOption.val(0);

                    selectBox.append(activeOption);
                    selectBox.append(inactiveOption);

                    // Atur nilai default select box berdasarkan data
                    selectBox.val(isAktif);

                    // Tambahkan event handler untuk memperbarui data ketika select box berubah
                    selectBox.on("change", function(e) {
                        var val = parseInt($(e.target).val(), 10);
                        var desc = "menonaktifkan user";
                        var oldValue = 1;
                        if(val == 1){
                            desc = "mengaktifkan user";
                            oldValue = 0;
                        }
                        Swal.fire({
                            title: 'Apakah Kamu Yakin?',
                            text: "Ingin "+ desc,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya',
                            cancelButtonText: 'Tidak',
                        }).then((result) => {
                            if(result.isConfirmed){
                                $.ajax({
                                    type: 'GET',
                                    cache: false,
                                    url: '{{url("/updateisAktif")}}',
                                    data: {userid,val}
                                });
                            }else{
                                $(selectBox).val(oldValue);
                            }
                        })
                    });
                }
            },
            {
                caption: 'Action',
                cellTemplate: function(container, options) {
                    var editButton = $('<i class="las la-history"></i>');
                    editButton.css('font-size','1.5em');
                    editButton.css('cursor','pointer');
                    editButton.css('color','blue');
                    editButton.on('click', function() {
                        var data = options.data;
                        console.log(data);
                    });

                    var deleteButton = $('<i class="las la-file-invoice-dollar"></i>');
                    deleteButton.css('font-size','1.5em');
                    deleteButton.css('cursor','pointer');
                    deleteButton.css('color','green');
                    deleteButton.on('click', function() {
                        var data = options.data;
                        console.log(data);
                    });

                    container.append(editButton);
                    container.append(deleteButton);
                }
            }
        ],
      }).dxDataGrid('instance');
    });
    
    </script>