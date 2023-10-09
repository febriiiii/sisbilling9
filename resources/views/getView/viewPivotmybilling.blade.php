<style>
    #pivotgrid {
    margin-top: 20px;
  }
  
  .currency {
    text-align: center;
  }
  </style>
  <body class="dx-viewport">
    <div class="demo-container">
      <div id="pivotgrid-demo">
        <div id="pivotgrid-chart"></div>
        <div id="pivotgrid"></div>
        <div id="drilldown-pivot"></div>
      </div>
    </div>
  </body>
  <script>
    var type = $('#primarymodal2').attr('val')
    var scrollView = $("#primarymodal2").dxScrollView({
        height: "100%",
        width: "100%",
    }).dxScrollView("instance");

    $(() => {
    var pivotGridChart = $('#pivotgrid-chart').dxChart({
      commonSeriesSettings: {
        type: 'bar',
      },
      export: {
        enabled: true,
      },
      onPointClick(e) {
        e.target.select();
      },
      size: {
        height: 200,
      },
    }).dxChart('instance');
  
    var pivotGrid = $('#pivotgrid').dxPivotGrid({
      allowSortingBySummary: true,
      allowFiltering: true,
      showBorders: true,
      showColumnGrandTotals: false,
      showRowGrandTotals: false,
      showRowTotals: false,
      showColumnTotals: false,
      fieldChooser: {
        enabled: true,
        // height: 400,
      },
      export: {
        enabled: true,
      },
      dataSource: {
        fields: [
            {
                dataField: 'nama',
                dataType: 'string',
                area: 'row',
            },{
                dataField: 'productName',
                dataType: 'string',
                area: 'row',
            },{
                caption: 'Payment Type',
                dataField: 'payment_type',
                area: 'row',
            },{
                caption: 'notrans',
                width: 120,
                dataField: 'notrans',
                area: 'row',
                // sortBySummaryField: 'Total',
            },{
                dataField: 'tglBayar',
                dataType: 'date',
                groupInterval: 'month',
            },{
                dataField: 'jatuhTempoTagihan',
                dataType: 'date',
                groupInterval: 'month',
                area: 'column',
            },{
                caption: 'TotalTagihan',
                dataField: 'TotalTagihan',
                dataType: 'number',
                summaryType: 'sum',
                format: "#,##0.##",
            },{
                caption: 'Tagihan',
                dataField: 'TotalTagihanBank',
                dataType: 'number',
                summaryType: 'sum',
                format: "#,##0.##",
            },{
                caption: 'Pembayar',
                dataField: 'TotalBayar',
                dataType: 'number',
                summaryType: 'sum',
                format: "#,##0.##",
                area: 'data',
            }
        ],
        store: {
          type: 'odata',
          url: "{{url('')}}/pivot?stamp=" + new Date().getTime(),
          key: 'notrans',
          beforeSend(request) {
            request.params.type = type;
          },
        },
      },
      onCellClick(e) {
        if (e.area === 'data') {
            const pivotGridDataSource = e.component.getDataSource();
            const rowPathLength = e.cell.rowPath.length;
            const rowPathName = e.cell.rowPath[rowPathLength - 1];
            const popupTitle = `${rowPathName || 'Total'} Drill Down Data`;

            drillDownDataSource = pivotGridDataSource.createDrillDownDataSource(e.cell);
            pivotPopup.option('title', popupTitle);
            if (DevExpress.devices.current().deviceType === "phone" || DevExpress.devices.current().deviceType === "tablet") {
                pivotPopup.option("fullScreen", true);
            }
            pivotPopup.show();
        }
      },
      onExporting(e) {
        var workbook = new ExcelJS.Workbook();
        var worksheet = workbook.addWorksheet('Sales');
  
        DevExpress.excelExporter.exportPivotGrid({
          component: e.component,
          worksheet,
        }).then(() => {
          workbook.xlsx.writeBuffer().then((buffer) => {
            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Sales.xlsx');
          });
        });
        e.cancel = true;
      },
    }).dxPivotGrid('instance');
  
    pivotGrid.bindChart(pivotGridChart, {
      dataFieldsDisplayMode: 'splitPanes',
      alternateDataFields: false,
    });
  
    function expand() {
      var dataSource = pivotGrid.getDataSource();
      dataSource.expandHeaderItem('row', ['North America']);
      dataSource.expandHeaderItem('column', [2013]);
    }
  
    setTimeout(expand, 0);

    const pivotPopup = $('#drilldown-pivot').dxPopup({
                            showCloseButton: true,
                            contentTemplate(contentElement) {
                            $('<div />')
                                .addClass('drill-down')
                                .dxDataGrid({
                                columnAutoWidth: true,
                                filterPanel: { visible: true },
                                filterRow: {
                                    visible: true,
                                    applyFilter: 'auto',
                                },
                                headerFilter: {
                                    visible: true,
                                },
                                columns: [
                                    {dataField: 'notrans',caption: 'Invoice.No'},
                                    {dataField: 'tglBayar',dataType: 'date'},
                                    {dataField: 'jatuhTempoTagihan',dataType: 'date'},
                                    {dataField: 'TotalTagihanBank',caption: 'Tagihan'},
                                    {dataField: 'TotalBayar',caption: 'Pembayaran'},
                                ],
                                summary: {totalItems: [
                                            {
                                                column: 'TotalTagihan',
                                                summaryType: 'sum',
                                                showInGroupFooter: true,
                                                customizeText: function(data) {
                                                    return "Total : "+formater.format(data.value);
                                                }
                                            },
                                            {
                                                column: 'TotalTagihanBank',
                                                summaryType: 'sum',
                                                showInGroupFooter: true,
                                                customizeText: function(data) {
                                                    return "Total : "+formater.format(data.value);
                                                }
                                            },
                                            {
                                                column: 'TotalBayar',
                                                summaryType: 'sum',
                                                showInGroupFooter: true,
                                                customizeText: function(data) {
                                                    return "Total : "+formater.format(data.value);
                                                }
                                            },
                                        ],
                                },
                                }).appendTo(contentElement);
                            },
                            onShowing() {
                            $('.drill-down')
                                .dxDataGrid('instance')
                                .option('dataSource', drillDownDataSource);
                            },
                            onShown() {
                            $('.drill-down')
                                .dxDataGrid('instance')
                                .updateDimensions();
                            },
                        }).dxPopup('instance');

  });

  </script>