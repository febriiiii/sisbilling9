<div>        
  <div class="mt-4" id="viewselectcomp-grid"></div>
</div>

<script>
$(() => {
    $('#viewselectcomp-grid').dxDataGrid({
        dataSource: {
        store: {
          type: 'odata',
          url: "{{url('/getcomp')}}?stamp=" + new Date().getTime(),
          key: 'email',
        },
      },
      columnHeadingEnabled: true,
      filterPanel: { visible: true },
      filterRow: {
        visible: true,
        applyFilter: 'auto',
      },
      paging: {
        pageSize: 10,
      },
      selection: {
        mode: 'single',
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
      allowColumnReordering: true,
      showBorders: true,  
      
      onCellPrepared: function(e) {
        if(e.rowType === "data") {
          e.cellElement.css("cursor","pointer");
        }
      },
      onSelectionChanged(selectedItems) {
        const data = selectedItems.selectedRowsData[0];
        if (data) {
          $(`#{{$data['id']}}`).val(data.email)
          $(`#{{$data['name']}}`).val(data.companyname)
          // new Noty({
          //     text: data.email+" Dipilih",
          //     timeout: 2000 
          // }).show();
        }
      },
      //  onCellClick(e) {
      //   $(`#{{$data['id']}}`).val(e.row.key)
      //   $(`#{{$data['name']}}`).val(e.row.data['companyname'])
      //   new Noty({
      //       text: e.row.data['companyname']+" Dipilih",
      //       timeout: 2000 
      //   }).show();
      //   // closemodal()
      // },
      scrolling: {
          mode: "standard" // or "virtual" | "infinite" | standard
      },
      columnAutoWidth: true,
      allowColumnResizing: true,
      columns: [
        {
          dataField: 'companyname',
          caption: 'Company Name',
          dataType: 'string',
        },
        {
          dataField: 'email',
          caption: 'EMail',
          dataType: 'string',
        },
        {
          dataField: 'companyaddress',
          caption: 'Address',
          dataType: 'string',
        },
      ],
    });
  });

</script>
