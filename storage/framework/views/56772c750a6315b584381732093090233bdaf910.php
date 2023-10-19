<div>        
  <div class="mt-4" id="viewselectcomp-grid"></div>
</div>

<script>
$(() => {
    $('#viewselectcomp-grid').dxDataGrid({
        dataSource: {
        store: {
          type: 'odata',
          url: "<?php echo e(url('/getcomp')); ?>?stamp=" + new Date().getTime(),
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
          $(`#<?php echo e($data['id']); ?>`).val(data.email)
          $(`#<?php echo e($data['name']); ?>`).val(data.companyname)
        }
      },
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
<?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/getView/selectCompany.blade.php ENDPATH**/ ?>