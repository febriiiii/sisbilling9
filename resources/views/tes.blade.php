<div class="row">
    <div class="col-sm"><div id="grid1"></div></div>
    <div class="col-sm"><div id="grid2"></div></div>
</div>


      <script>
        const store = DevExpress.data.AspNet.createStore({
            key: 'userid',
            loadUrl: '{{url("getUserPinjam")}}',
            updateUrl: '{{url("putUserPinjam")}}',
            onBeforeSend(method, ajaxOptions) {
                ajaxOptions.xhrFields = { withCredentials: true };
                ajaxOptions.headers = ajaxOptions.headers || {};
                ajaxOptions.headers['X-CSRF-Token'] = "{{csrf_token()}}";
                ajaxOptions.data = ajaxOptions.data || {};
                ajaxOptions.data.AppointmentId = 1;
                ajaxOptions.cache = false;
            },
        });

        function getDataGridConfiguration(index) {
            return {
                height: 200,
                dataSource: {
                    store,
                    reshapeOnPush: true,
                },
                headerFilter: { visible: true },
                filterRow: { visible: true },
                searchPanel: { visible: true },
                showBorders: true,
                filterValue: ['isUsed', '=', index],
                rowDragging: {
                    data: index,
                    group: 'tasksGroup',
                    onAdd,
                },
                scrolling: {
                    mode: 'virtual',
                },
                columns: [{
                    dataField: 'userid',
                    dataType: 'string',
                    visible: false,
                },{
                    dataField: 'nama',
                    dataType: 'string',
                },{
                    dataField: 'email',
                    dataType: 'string',
                },{
                    dataField: 'isUsed',
                    dataType: 'number',
                    visible: false,
                }],
            };
        }

        $('#grid1').dxDataGrid(getDataGridConfiguration(0));
        $('#grid2').dxDataGrid(getDataGridConfiguration(1));

        function onAdd(e) {
            const key = e.itemData.userid;
            const values = { isUsed: e.toData };

            store.update(key, values).then(() => {
                store.push([{
                    type: 'update', key, data: values,
                }]);
            });
        }
      </script>
