<div class="card mt-2 p-1">
  <ul style="background-color: rgb(207, 164, 248);color:white; cursor: pointer;" onclick="$('#contentbill1').slideToggle()">My Billing</ul>
  <div id="contentbill1" style="display: none;">
    <div class="mt-3" id="tabeltransaction"  style="min-height: 300px; height:500px; resize: vertical; overflow: auto;"></div>
  </div>    
</div>
@if (session('UIDGlob')->companyid != '')
<div class="card mt-4 p-1">
  <ul style="background-color: rgb(192, 218, 151);color:white; cursor: pointer;" onclick="$('#contentbill2').slideToggle()">My Customer Billing</ul>
  <div id="contentbill2" style="display: nones;">
    <div class="mt-3" id="tabeltransactionCus" style="min-height: 300px; height:500px; resize: vertical; overflow: auto;"></div>
  </div>
</div>
@endif
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script> --}}
<script>
  var popup = $('#myModal').dxPopup('instance');
  popup.option("fullScreen", true);
  
  var scrollView = $("#primarymodal").dxScrollView({
        height: "100%",
        width: "100%",
    }).dxScrollView("instance");
  function opnpivotmybilling(title,type){
    $.ajax({
        type: 'GET',
        cache: false,
        url: '{{url("/viewpivotmybilling")}}',
        success: function(content) {
            openmodal2(title,content,type)
        },
        error: function(xhr, status, error) {
          showNty(error,10000)
        }
    });
  }
  function querysaled(){
    $('#tabeltransaction').dxDataGrid({
      dataSource: {
        store: {
          type: 'odata',
          cache: false,
          url: "{{url('')}}/gettransaction?type=m&stamp=" + new Date().getTime(),
          key: 'notrans',
          beforeSend(request) {
            request.params.SaleNo = $('#formsaleh-primary').val();
          },
        },
      },
      toolbar: {
        items: [
          'groupPanel',
          'exportButton',
          'columnChooserButton',
          'searchPanel',
          {
            widget: 'dxButton',
            options: {
              icon: 'chart',
              onClick(e) {
                opnpivotmybilling("My Billing Pivot","mybilling")
              },
            },
          },
        ],
      },
      columnHeadingEnabled: true,
      filterRow: {
        visible: true,
        applyFilter: 'auto',
      },
      headerFilter: {
        visible: true,
      },
      paging: {
        pageSize: 10,
      },
      pager: {
        showPageSizeSelector: true,
        allowedPageSizes: [10, 25, 50, 100],
      },
      remoteOperations: false,
      searchPanel: {
        visible: true,
        highlightCaseSensitive: true,
      },
      groupPanel: { visible: true },
      grouping: { autoExpandAll: true},
      allowColumnReordering: true,
      showBorders: true,  
      export: {
        enabled: true,
        formats: ['pdf','xlxs'],
        allowExportSelectedData: false,
      },
      onCellPrepared: function(e) {
        if(e.rowType === "data" && e.column.dataField === "ItemName") {
          e.cellElement.css("color","blueviolet");
          e.cellElement.css("cursor","pointer");
        }
      },
      onExporting(e) {
        if(e.format == 'xlxs'){
          const workbook = new ExcelJS.Workbook();
          const worksheet = workbook.addWorksheet('transaction');
          DevExpress.excelExporter.exportDataGrid({
            component: e.component,
            worksheet,
            autoFilterEnabled: true,
          }).then(() => {
            workbook.xlsx.writeBuffer().then((buffer) => {
              saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'sisbilling{{Carbon\Carbon::now(config("app.GMT"))->format("Y-m-d H:mm")}}.xlsx');
            });
          });
          e.cancel = true;
        }else if(e.format == 'pdf'){
          const doc = new jsPDF();
          DevExpress.pdfExporter.exportDataGrid({
            jsPDFDocument: doc,
            component: e.component,
            indent: 5,
          }).then(() => {
            doc.save('sisbilling{{Carbon\Carbon::now(config("app.GMT"))->format("Y-m-d H:mm")}}.pdf');
          });
        }
      },
      scrolling: {
        mode: "standard" // or "virtual" | "infinite" | standard
      },
      columnChooser: {
        enabled: true,
        mode: 'select',
      },
      columnAutoWidth: true,
      filterPanel: { visible: true },
      allowColumnResizing: true,
      columns: [
        {
          caption: '',
          width:50,
          cellTemplate: function(container, options) {
            var additionalButton = $('<div>')
              .addClass('btn btn-secondary p-1')
              .appendTo(container)
              .on('dxclick', function() {
                var val = options.data.notrans
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
              $('<span>')
            .text('Bill')
            .appendTo(additionalButton);
          }
        },
      {
        dataField: 'statusid',
        visible: false 
      },
      {
        dataField: 'nama',
        caption: 'Name',
        visible: false 
      },
      {
        dataField: 'notrans',
        caption: 'Invoice',
      },
      {
        dataField: 'transdate',
        caption: 'trans date',
      },
      {
        dataField: 'paymentname',
        caption: 'Payment',
      },
      {
        dataField: 'jatuhTempoTagihan',
        dataType: 'date',
      },
      {
        dataField: 'productName',
        caption: 'Nama Produk',
      },
      {
        dataField: 'deskripsi',
        caption: 'Status',
      },
      {
        dataField: 'Amount',
        caption: 'Amount',
        dataType: 'number',
        format: "#,##0.##",
        alignment: 'right',
        summaryType: "custom",
        calculateCustomSummary: function(options) {
            console.log(options);
            if (options.name === "sum" && options.summaryProcess === "start") {
                options.totalValue = 0;
            }
            if (options.name === "sum" && options.summaryProcess === "calculate" && options.data.statusid === 5) {
                options.totalValue += options.value;
            }
            if (options.name === "sum" && options.summaryProcess === "finalize") {
                options.totalValue = Number(options.totalValue.toFixed(2));
            }
        }
      },
      ],
      summary: {
        totalItems: [
          {
            column: "notrans",
            summaryType: "count"
          },
          {
            column: "Amount",
            summaryType: "sum",
            customizeText: function(data) {
              return "Total: " + formater.format(data.value);
            },
          },
        ],
        groupItems:[
          {
            column: 'Amount',
            summaryType: 'sum',
            showInGroupFooter: false,
            alignByColumn: true,
            customizeText: function(data) {
                return " Total : " + formater.format(data.value);
            },
          },
        ]
      },
    });
  }
  function querysaledBil(){
    $('#tabeltransactionCus').dxDataGrid({
      dataSource: {
        store: {
          type: 'odata',
          cache: false,
          url: "{{url('')}}/gettransaction?type=c&stamp=" + new Date().getTime(),
          key: 'notrans',
          beforeSend(request) {
            request.params.SaleNo = $('#formsaleh-primary').val();
          },
        },
      },
      toolbar: {
        items: [
          'groupPanel',
          'exportButton',
          'columnChooserButton',
          'searchPanel',
          {
            widget: 'dxButton',
            options: {
              icon: 'chart',
              onClick(e) {
                opnpivotmybilling("My Customer Billing Pivot","mycustomerbilling")
              },
            },
          },
        ],
      },
      columnHeadingEnabled: true,
      filterRow: {
        visible: true,
        applyFilter: 'auto',
      },
      headerFilter: {
        visible: true,
      },
      paging: {
        pageSize: 10,
      },
      pager: {
        showPageSizeSelector: true,
        allowedPageSizes: [10, 25, 50, 100],
      },
      remoteOperations: false,
      searchPanel: {
        visible: true,
        highlightCaseSensitive: true,
      },
      groupPanel: { visible: true },
      grouping: { autoExpandAll: true},
      allowColumnReordering: true,
      showBorders: true,  
      export: {
        enabled: true,
        formats: ['pdf','xlxs'],
        allowExportSelectedData: false,
      },
      onCellPrepared: function(e) {
        if(e.rowType === "data" && e.column.dataField === "ItemName") {
          e.cellElement.css("color","blueviolet");
          e.cellElement.css("cursor","pointer");
        }
      },
      onExporting(e) {
        if(e.format == 'xlxs'){
          const workbook = new ExcelJS.Workbook();
          const worksheet = workbook.addWorksheet('transaction');
          DevExpress.excelExporter.exportDataGrid({
            component: e.component,
            worksheet,
            autoFilterEnabled: true,
          }).then(() => {
            workbook.xlsx.writeBuffer().then((buffer) => {
              saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'sisbilling{{Carbon\Carbon::now(config("app.GMT"))->format("Y-m-d H:mm")}}.xlsx');
            });
          });
          e.cancel = true;
        }else if(e.format == 'pdf'){
          const doc = new jsPDF();
          DevExpress.pdfExporter.exportDataGrid({
            jsPDFDocument: doc,
            component: e.component,
            indent: 5,
          }).then(() => {
            doc.save('sisbilling{{Carbon\Carbon::now(config("app.GMT"))->format("Y-m-d H:mm")}}.pdf');
          });
        }
      },
      scrolling: {
        mode: "standard" // or "virtual" | "infinite" | standard
      },
      columnChooser: {
        enabled: true,
        mode: 'select',
      },
      columnAutoWidth: true,
      filterPanel: { visible: true },
      allowColumnResizing: true,
      columns: [
        {
          caption: '',
          width:50,
          cellTemplate: function(container, options) {
            var additionalButton = $('<div>')
              .addClass('btn btn-secondary p-1')
              .appendTo(container)
              .on('dxclick', function() {
                payment(options.data.notrans)
              });
              $('<span>')
            .text('Bill')
            .appendTo(additionalButton);
          }
        },
      {
        dataField: 'statusid',
        visible: false 
      },
      {
        dataField: 'notrans',
        caption: 'Invoice',
        visible: false 
      },
      
      {
        dataField: 'transdate',
        caption: 'trans date',
      },
      {
        dataField: 'paymentname',
        caption: 'Payment',
      },
      {
        dataField: 'nama',
        caption: 'Name',
      },
      {
        dataField: 'jatuhTempoTagihan',
        dataType: 'date',
      },
      {
        dataField: 'productName',
        caption: 'Nama Produk',
      },
      {
        dataField: 'deskripsi',
        caption: 'Status',
      },
      {
        dataField: 'Amount',
        caption: 'Amount',
        dataType: 'number',
        format: "#,##0.##",
        alignment: 'right',
        summaryType: "custom",
        calculateCustomSummary: function(options) {
            console.log(options);
            if (options.name === "sum" && options.summaryProcess === "start") {
                options.totalValue = 0;
            }
            if (options.name === "sum" && options.summaryProcess === "calculate" && options.data.statusid === 5) {
                options.totalValue += options.value;
            }
            if (options.name === "sum" && options.summaryProcess === "finalize") {
                options.totalValue = Number(options.totalValue.toFixed(2));
            }
        }
      },
      ],
      sortByGroupSummaryInfo: [{
        summaryItem: 'count',
      }],
      summary: {
        totalItems: [
          {
            column: "notrans",
            summaryType: "count"
          },
          {
            column: 'Amount',
            summaryType: 'sum',
            showInGroupFooter: true,
            customizeText: function(data) {
              return "Grand Total : "+formater.format(data.value);
            }
          },
        ],
        groupItems:[
          {
            column: 'Amount',
            summaryType: 'sum',
            showInGroupFooter: false,
            alignByColumn: true,
            customizeText: function(data) {
              // console.log(data);
              // var dataSource = $('#tabeltransactionCus').dxDataGrid('instance').getDataSource();
              // var group = dataSource && dataSource.group();
              // var groupName = group && group[data.groupIndex];
              // if(group.length > 1){
                return " Total : " + formater.format(data.value);
              // }
              // return " Total "+group[0].selector+" : " + data.value;
            },
          },
        ]
      },
    });
  }
    
  var group2 = -1;
</script>
