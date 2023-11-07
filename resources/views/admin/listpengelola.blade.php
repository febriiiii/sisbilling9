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
                cellTemplate: function(container, options) {
                    var bA = options.data.billAktif
                    if(options.data.billAktif == null){
                        bA = "Tidak Ada"
                    }
                    var historyButton = $('<span class="badge badge-success rounded-pill d-inline">'+bA+'<span>');
                    historyButton.css('cursor','pointer');
                    historyButton.on('click', function() {
                        var val = options.data.billAktif
                        if(val == null){
                            return false;
                        }
                        $.ajax({
                        url: '{{url("/viewpayment")}}',
                        type: 'GET',
                        cache: false,
                        data: {val},
                        success: function(data) {
                            if(data != 0){
                                openmodal2("Form Pembayaran",data)
                            }else{
                                showNty("Payment Error")
                            }
                        },
                        error: function(xhr, status, error) {
                            showNty(error,10000)
                        }
                        });
                    });

                    container.append(historyButton);
                } 
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
                    var historyButton = $('<i class="las la-history me-2"></i>');
                    historyButton.css('font-size','1.5em');
                    historyButton.css('cursor','pointer');
                    historyButton.css('color','blue');
                    historyButton.on('click', function() {
                        var data = options.data;
                        $.ajax({
                            type: 'GET',
                            cache: false,
                            url: '{{url("/modalbill?userid=")}}'+data.userid,
                            success: function(content) {
                                GModal('Tagihan Pengelola',content)
                            },
                            error: function(xhr, status, error) {
                            showNty(error,10000)
                            }
                        });
                    });
                    var invoiceButton = $('<i class="las la-file-invoice-dollar me-2"></i>');
                    invoiceButton.css('font-size','1.5em');
                    invoiceButton.css('cursor','pointer');
                    invoiceButton.css('color','green');
                    invoiceButton.on('click', function() {
                        var data = options.data;
                        $.ajax({
                            type: 'GET',
                            cache: false,
                            url: '{{url("/adminpembayaran?userid=")}}'+data.userid,
                            success: function(content) {
                                GModal('Pembayaran Pengelola',content)
                            },
                            error: function(xhr, status, error) {
                            showNty(error,10000)
                            }
                        });
                    });
                    var midButton = $('<i class="las la-credit-card me-2"></i>');
                    midButton.css('font-size','1.5em');
                    midButton.css('cursor','pointer');
                    midButton.css('color','green');
                    midButton.on('click', function() {
                        var data = options.data;
                        console.log(data);
                        $.ajax({
                            type: 'GET',
                            cache: false,
                            url: '{{url("/modalmidtrans?userid=")}}'+data.userid,
                            success: function(content) {
                                GModal('Midtrans Key Update',content)
                            },
                            error: function(xhr, status, error) {
                            showNty(error,10000)
                            }
                        });
                    });

                    container.append(historyButton);
                    container.append(invoiceButton);
                    container.append(midButton);
                }
            }
        ],
      }).dxDataGrid('instance');
    }

    
    </script>