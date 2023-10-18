@include('loading')
<div class="demo-container FirstShow">
  <div id="showscheduler"></div>
  <div class="scedulerket row p-2">
    <div class="col-auto me-4">
      <div class="row">
        <div class="col-auto" style="padding:0">
          <div class="scedulerketDot" style="background-color: yellow; height:20px; width:20px; border-radius:100%;"></div>
        </div>
        <div class="col" style="padding:0 0 0 5px;">
          <div>Hari Ini</div>
        </div>
      </div>
    </div>
    <div class="col-auto me-4">
      <div class="row">
        <div class="col-auto" style="padding:0">
          <div class="scedulerketDot" style="background-color: #337AB7; height:20px; width:20px; border-radius:100%;"></div>
        </div>
        <div class="col" style="padding:0 0 0 5px;">
          <div>My Reminder</div>
        </div>
      </div>
    </div>
    <div class="col-auto me-4">
      <div class="row">
        <div class="col-auto" style="padding:0">
          <div class="scedulerketDot" style="background-color: #7AA874; height:20px; width:20px; border-radius:100%;"></div>
        </div>
        <div class="col" style="padding:0 0 0 5px;">
          <div>Sudah Bayar</div>
        </div>
      </div>
    </div>
    <div class="col-auto me-4">
      <div class="row">
        <div class="col-auto" style="padding:0">
          <div class="scedulerketDot" style="background-color: #FFE569; height:20px; width:20px; border-radius:100%;"></div>
        </div>
        <div class="col" style="padding:0 0 0 5px;">
          <div>Sedang Proses</div>
        </div>
      </div>
    </div>
    <div class="col-auto me-4">
      <div class="row">
        <div class="col-auto" style="padding:0">
          <div class="scedulerketDot" style="background-color: #FD8A8A; height:20px; width:20px; border-radius:100%;"></div>
        </div>
        <div class="col" style="padding:0 0 0 5px;">
          <div>Belum Bayar</div>
        </div>
      </div>
    </div>
  </div>
  <div class="container card">
    <button class="btn btn-secondary mt-2" type="button" disabled>Pengumuman</button>
      <div class="mt-2" id="contentpengumumancompany">
          @foreach ($tblpengumuman as $p)
            @if ($p->isPengumumanCompany == 1)
              <div id="pengumumanCompany{{$p->pengumumanid}}" class="p-2 m-2" style="outline: 1px solid rgb(187, 178, 178);">
                <div class="row">
                  <center><h6>{{$p->judul}}</h6></center>
                  <small style="text-align: justify;" class="col-12">{!!$p->pengumuman!!}</small>
                  <small class="col d-flex" style="font-weight:bold;">({{$p->companyname}}) {{Carbon\Carbon::parse($p->InsertDT)->format("Y-m-d H:i")}}</small>
                  <small onclick="openkomentarpengumuman('{{$p->pengumumanid}}','{{$p->judul}}')" class="col-auto" style="color:rgb(98, 98, 233);cursor: pointer;"><i class="las la-comment-alt"></i>Komentar</small>
                </div>
              </div>
            @endif
          @endforeach
      </div>
  </div>
</div>
<script>
  const holidays = [
                    { day: 1, month: 1, name: 'Tahun Baru' },
                    { day: 12, month: 2, name: 'Tahun Baru Imlek (Cap Go Meh)' },
                    { day: 1, month: 3, name: 'Hari Kehutanan Sedunia' },
                    { day: 21, month: 3, name: 'Hari Hutan Internasional' },
                    { day: 6, month: 4, name: 'Hari Nelayan Nasional' },
                    { day: 21, month: 4, name: 'Hari Kartini' },
                    { day: 22, month: 4, name: 'Hari Bumi' },
                    { day: 1, month: 5, name: 'Hari Buruh Internasional (May Day)' },
                    { day: 2, month: 5, name: 'Hari Pendidikan Nasional' },
                    { day: 5, month: 5, name: 'Hari Sumpah Pemuda' },
                    { day: 10, month: 5, name: 'Hari Kebangkitan Nasional' },
                    { day: 20, month: 5, name: 'Hari Kebangkitan Nasional Aceh' },
                    { day: 21, month: 5, name: 'Hari Raja Keraton Surakarta' },
                    { day: 27, month: 5, name: 'Hari Agraria Nasional' },
                    { day: 1, month: 6, name: 'Hari Lahir Pancasila' },
                    { day: 5, month: 6, name: 'Hari Lingkungan Hidup Sedunia' },
                    { day: 30, month: 6, name: 'Hari Bhinneka Tunggal Ika' },
                    { day: 6, month: 7, name: 'Hari Bhayangkara (HUT Polri)' },
                    { day: 20, month: 7, name: 'Hari Ulang Tahun Kabupaten Lombok Barat' },
                    { day: 17, month: 8, name: 'Hari Kemerdekaan Republik Indonesia (HUT RI)' },
                    { day: 21, month: 8, name: 'Hari Pers Nasional' },
                    { day: 23, month: 9, name: 'Hari Santri Nasional' },
                    { day: 27, month: 9, name: 'Hari Pariwisata Sedunia' },
                    { day: 5, month: 10, name: 'Hari Batik Nasional' },
                    { day: 10, month: 11, name: 'Hari Pahlawan Nasional' },
                    { day: 25, month: 12, name: 'Hari Raya Natal' },
                  ];
  function openkomentarpengumuman(pengumumanid,judul){
    $.ajax({
        type: 'GET',
        cache: false,
        url: '{{url("/viewkomentarpengumuman")}}',
        data: {pengumumanid},
        success: function(data) {
          openmodal(judul,data,pengumumanid)
        },
        error: function(xhr, status, error) {
            new Noty({
                text: error,
                timeout: 10000 
            }).show();
        }
    });
  }
  const url = '{{url('')}}';

  // DATA WARNA DASHBOARD
  var dataWarna
  
  $('.FirstShow').hide()
  setTimeout(() => {
    $('.loading-container').hide()
    $('.FirstShow').fadeToggle('slow')
    reloadDashboard()
  }, 1000);
  function reloadDashboard(){
    $.ajax({
        type: 'GET',
        cache: false,
        url: '{{url("/dataStatus")}}',
        success: function(response) {
          dataWarna = response;
          dxsceduler()
        },
        error: function(xhr, status, error) {
            new Noty({
                text: "Color Status Error",
                timeout: 10000 
            }).show();
        }
    });
  }
  var tempUserpinjam = [];
  var getproductdata
  
  function dxsceduler(){
      $.ajax({
        url: '{{ url("/getproduct") }}?stamp=' + new Date().getTime(),
        method: 'GET',
        success: function (data) {
          getproductdata = data
        }
    });
    $(() => {
        const scheduler = $('#showscheduler').dxScheduler({
          timeZone: 'Asia/Jakarta',
          dataSource: DevExpress.data.AspNet.createStore({
            key: 'AppointmentId',
            loadUrl: `${url}/getAgenda`,
            insertUrl: `${url}/insertAgenda`,
            updateUrl: `${url}/putAgenda`,
            deleteUrl: `${url}/deleteAgenda`,
            onBeforeSend(method, ajaxOptions) {
              ajaxOptions.xhrFields = { withCredentials: true };
              ajaxOptions.headers = ajaxOptions.headers || {};
              ajaxOptions.headers['X-CSRF-Token'] = "{{csrf_token()}}";
              ajaxOptions.cache = false;
            },
          }),
          editing: {
            allowAdding: true,
            allowDeleting: true,
            allowUpdating: true,
            allowResizing: true,
            allowDragging: true,
          },
          // resources: [
          //   {
          //     fieldExpr: 'productCode',
          //     allowMultiple: false,
          //     dataSource: DevExpress.data.AspNet.createStore({
          //       key: 'productCode',
          //       loadUrl: '{{url("getproduct")}}',
          //       onBeforeSend: function(method, ajaxOptions) {
          //         ajaxOptions.xhrFields = { withCredentials: true };
          //       }
          //     }),
          //     label: 'Product Code',
          //   },
          // ],
          // adaptivityEnabled: true,
          // allowMultipleCellSelection: false, //mematikan multi select cell
          // focusStateEnabled: false,
          // allowDrag: false,
          allowDragging: false,
          selectionMode: "none",
          remoteFiltering: true,
          dateSerializationFormat: 'yyyy-MM-ddTHH:mm:ssZ',
          views: ['week','month','agenda'],
          currentView: 'month',
          currentDate: new Date(),
          // startDayHour: 8,
          // endDayHour: 9,
          height: 600,
          textExpr: 'Text',
          startDateExpr: 'StartDate',
          endDateExpr: 'EndDate',
          allDayExpr: 'all_day',
          recurrenceRuleExpr: 'RecurrenceRule',
          recurrenceExceptionExpr: 'RecurrenceException',
          dataCellTemplate(cellData, index, container) {
            const startDateString = cellData.startDate;
            const currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0); // Menghapus jam, menit, detik, dan milidetik
            startDateString.setHours(0, 0, 0, 0);
            const isToday = startDateString.getTime() === currentDate.getTime();
            const wrapper = $('<div>').appendTo(container);
            const cell = $('<div>')
              .text(cellData.text)
              .addClass('day-cell');
            const nowMonth = currentDate.getMonth() + 1;
            const nowDay = currentDate.getDate();
            const startMonth = startDateString.getMonth() + 1;
            const startDay = startDateString.getDate();

            if (isToday) {
              // for (var i = 0; i < holidays.length; i++) {
              //   if (nowDay === holidays[i].day && nowMonth === holidays[i].month) {
              //     cell.prepend($('<marquee style="z-index:-1;width:78%; font-size:.7em;">').text(holidays[i].name));
              //     break; // Jika hari besar sudah ditemukan, hentikan pencarian.
              //   }
              // }
              cell.css('background-color', 'yellow');
            }
            for (var i = 0; i < holidays.length; i++) {
              if (startDay === holidays[i].day && startMonth === holidays[i].month) {
                cell.prepend($('<marquee style="z-index:-1;width:78%; font-size:.7em;">').text(holidays[i].name));
                break; // Jika hari besar sudah ditemukan, hentikan pencarian.
              }
            }
            

            wrapper.append(cell);
          },
          onAppointmentFormOpening(e){
            var AppointmentId = e.appointmentData.AppointmentId;
            // tempUserpinjam = [];
            e.popup.option({
              showTitle: true,
              maximized: true,
              dragEnabled: true,
              closeOnOutsideClick: true,
              title: e.appointmentData.Text ? e.appointmentData.Text : 'Create a new appointment'
            });
            let form = e.form,
            items = e.form.option("items"),
            firstGroupItems = form.itemOption('mainGroup').items;
            if(items.length == 2){
              let Billing = {
                colSpan: 1,
                label: { text: "Billing" },
                editorType: "dxSwitch",
                dataField: "Billing",
                // value: false,
                editorOptions: {
                  onValueChanged: function(f) {
                    if(f.value == true){
                      var swBil = 1
                    }else{
                      var swBil = 0
                    }
                    // form.itemOption("SisaPok", "visible", f.value);
                    form.itemOption("Pokok", "visible", f.value);
                    // form.itemOption("userIn", "visible", f.value);
                    // form.itemOption("userOut", "visible", f.value);
                    // form.itemOption("bolehTungak", "visible", f.value);
                    form.itemOption("lateFeePercent", "visible", f.value);
                    form.itemOption("BungaPercent", "visible", f.value);
                    form.itemOption("productCode", "visible", f.value);
                    e.form.option("formData").isBilling = swBil
                  }
                }
              };
              // const storeUserpinjam = DevExpress.data.AspNet.createStore({
              //                             key: 'userid',
              //                             loadUrl: '{{url("getUserPinjam")}}',
              //                             updateUrl: '{{url("putUserPinjam")}}',
              //                             onBeforeSend: function(method, ajaxOptions) {
              //                                 ajaxOptions.xhrFields = { withCredentials: true };
              //                                 ajaxOptions.headers = ajaxOptions.headers || {};
              //                                 ajaxOptions.headers['X-CSRF-Token'] = "{{csrf_token()}}";
              //                                 ajaxOptions.data = ajaxOptions.data || {};
              //                                 ajaxOptions.data.AppointmentId = AppointmentId;
              //                             }
              //                         });
                                      
              // function onAdd(a) {
              //   var key = a.itemData.userid;
              //   var values = { isUsed: a.toData };
              //   if(values.isUsed == 1){
              //     tempUserpinjam.push(key)
              //   }else{
              //     var index = tempUserpinjam.indexOf(key);
              //     if (index !== -1) {
              //       tempUserpinjam.splice(index, 1);
              //     }
              //   }
              //   var data = e.form.option("formData");
              //   data.tempUserpinjam = tempUserpinjam;
              //   storeUserpinjam.update(key, values).then(() => {
              //       storeUserpinjam.push([{
              //           type: 'update', key, data: values,
              //       }]);
              //   });
              // }
              // function getDataGridConfiguration(index) {
              //   return {
              //       height: 300,
              //       dataSource: {
              //           store : storeUserpinjam,
              //           reshapeOnPush: true,
              //       },
              //       searchPanel: { visible: true },
              //       showBorders: true,
              //       filterValue: ['isUsed', '=', index],
              //       rowDragging: {
              //           data: index,
              //           group: 'tasksGroup',
              //           onAdd,
              //       },
              //       scrolling: {
              //           mode: 'virtual',
              //       },
              //       columns: [{
              //           dataField: 'userid',
              //           dataType: 'string',
              //           visible: false,
              //       },{
              //           dataField: 'nama',
              //           dataType: 'string',
              //       },{
              //           dataField: 'email',
              //           dataType: 'string',
              //       },{
              //           dataField: 'isUsed',
              //           dataType: 'number',
              //           visible: false,
              //       }],
              //   };
              // }
              // let userOut = {
              //   colSpan: 1,
              //   label: { text: "Pilih User" },
              //   dataField: "userOut",
              //   visible: false,
              //   template: function (data, container) {
              //     $('<div id="userOut">')
              //       .dxDataGrid(getDataGridConfiguration(0))
              //       .appendTo(container);
              //   }
              // };
              // let userIn = {
              //   colSpan: 1,
              //   label: { text: "User Used" },
              //   dataField: "userIn",
              //   visible: false,
              //   template: function (data, container) {
              //     $('<div id="userIn">')
              //       .dxDataGrid(getDataGridConfiguration(1))
              //       .appendTo(container);
              //   }
              // };
              // let sisaPok = {
              //   colSpan: 1,
              //   label: { text: "Total Tagihan" },
              //   editorType: "dxNumberBox",
              //   dataField: "SisaPok",
              //   editorOptions: { 
              //     format: { type: 'currency', currency: 'IDR', precision: 2 },
              //   },
              //   visible: false,
              //   validationRules: [
              //     { type: "required", message: "Total Tagihan is required" },
              //     { type: "range", min: 1, message: "Total Tagihan > 1" }
              //   ],
              // };
              let Pokok = {
                colSpan: 1,
                label: { text: "Total Tagihan" },
                editorType: "dxNumberBox",
                dataField: "Pokok",
                editorOptions: { 
                  format: { type: 'currency', currency: 'IDR', precision: 2 },
                },
                visible: false,
                validationRules: [
                  { type: "required", message: "Total Tagihan is required" },
                  { type: "range", min: 1, message: "Total Tagihan > 1" }
                ],
              };
              // let bolehTungak = {
              //   colSpan: 1,
              //   label: { text: "Boleh Tungak" },
              //   editorType: "dxSwitch",
              //   dataField: "bolehTungak",
              //   visible: false,
              // };
              
              let productCode = {
                colSpan: 1,
                label: { text: "Product" },
                editorType: "dxSelectBox",
                visible: false,
                validationRules: [
                  { type: "required", message: "Product is required" },
                ],
                editorOptions: {
                  inputAttr: { 'aria-label': 'Product productCode' },
                  dataSource: new DevExpress.data.ArrayStore({
                      data: getproductdata,
                      key: 'productCode',
                  }),
                  displayExpr: "productName",
                  valueExpr: "productCode",
                },
                dataField: "productCode",
              };
              let lateFeePercent = {
                colSpan: 1,
                label: { text: "Late Fee Percent" },
                editorType: "dxNumberBox",
                dataField: "lateFeePercent",
                visible: false,
                validationRules: [
                  { type: "required", message: "Late Fee Percent is required" },
                  { type: "range", min: 0, max: 100, message: "Late Fee Percent must be between 0 and 100" }
                ],
              };
    
              let bungaPercent = {
                colSpan: 1,
                label: { text: "Bunga Percent" },
                editorType: "dxNumberBox",
                dataField: "BungaPercent",
                visible: false,
                validationRules: [
                  { type: "required", message: "Bunga Percent is required" },
                  { type: "range", min: 0, max: 100, message: "Bunga Percent must be between 0 and 100" }
                ],
              };
              if(UIDGlob.companyid != null){ // Menutup customer agar appoinment tidak ada billing (create function)
                firstGroupItems.push(Billing);
              }
              // items.push(userOut,userIn,sisaPok,Pokok,lateFeePercent,bolehTungak,bungaPercent,productCode);
              items.push(Pokok,lateFeePercent,bungaPercent,productCode);
              form.itemOption('mainGroup', 'items', firstGroupItems);
              form.option("items", items);
            }

            if (e.appointmentData.userid != undefined && e.appointmentData.userid !== "{{session('UIDGlob')->userid}}") {
              new Noty({
                text: "Tidak Diizinkan",
                timeout: 2000 
              }).show();
              e.cancel = true; // Prevent opening appointment form
            }

            setTimeout(function() {
              var data = e.form.option("formData");
              data.all_day = true;
              if(e.appointmentData.isBilling != undefined){
                data.Billing = e.appointmentData.isBilling == 1
                data.isBilling = e.appointmentData.isBilling
              }
              e.form.updateData(data);
            }, 100);
          },
          onAppointmentTooltipShowing:function(e){
            setTimeout(function() {
              var scrollContent = document.querySelector('.dx-scrollview-content');
              if (scrollContent) {
                var childElements = scrollContent.getElementsByClassName('dx-tooltip-appointment-item-marker-body');
                // Manipulate the child elements as needed
                for (var i = 0; i < childElements.length; i++) {
                  var contentDate = new Date(e.appointments[i].currentAppointmentData.StartDate)
                  var appointmentIDcontent = e.appointments[i].appointmentData.AppointmentId
                  var stopIteration = false;
                  dataWarna.forEach(w => {
                    if (stopIteration) {
                      return; // Menghentikan iterasi
                    }
                    if(w.id == appointmentIDcontent){
                      childElements[i].style.backgroundColor = '#FD8A8A';
                      if(new Date(contentDate) < new Date(w.date)){
                        childElements[i].style.backgroundColor = '#7AA874';
                      }
                      if (w.statusid == 6) {
                        if (formatDate(contentDate) == formatDate(w.date)) {
                          childElements[i].style.backgroundColor = '#FFE569';
                          stopIteration = true;
                          return;
                        }
                      }
                    }
                  });
                }
              }
            }, 200); 
          },
          onOptionChanged:function(e){
            var schedulerInstance = $("#showscheduler").dxScheduler("instance");
            var focusedCells = schedulerInstance.$element().find(".dx-state-focused");
            // focusedCells.removeClass("dx-state-focused");
            // focusedCells.removeClass("dx-scheduler-focused-cell");
          },
          // onCellDragging: function(e) {
          //   console.log("onCellDragging");
          // },
          // appointmentTooltipRender:function(e){
          //   alert(e)
          // },
          // onTooltipShown:function(e){
          //   alert('onTooltipShown')
          // },
          // onAppointmentDblClick: function(e){
          //   alert('onAppointmentDblClick')
          // },
          // onAppointmentDeleted: function(e){
          //   alert('onAppointmentDeleted')
          // },
          // onAppointmentUpdated: function(e){
          //   alert('onAppointmentUpdated')
          // },
          // onCellClick: function(e){
          //   alert('click')
          // },
          // onSelectionChanged: function(e){
          //   var selectedCells = e.selectedCells;
          //   console.log(selectedCells);
          // },
          // onAppointmentClick : function (e) {
          //   var appointmentElement = $(e.appointmentElement[0]);
          //   var currentBgColor = appointmentElement.css('background-color');
          //   setTimeout(() => {
          //     $('.dx-list-item .dx-tooltip-appointment-item-marker-body').css('background-color',currentBgColor)
          //   }, 400);
          // },
          // appointmentTemplate: function(data) {
          //   console.log(data);
          //   var startDate = data.appointmentData.StartDate;
          //   var endDate = data.appointmentData.EndDate;
          //   var title = data.appointmentData.Text;
      
          //   // Apply custom logic to determine the background color based on the start date
          //   var bgColor = startDate > new Date() ? 'black' : 'black';
      
          //   // Generate the HTML markup for the appointment
          //   var html = '<div class="custom-appointment" style="background-color: ' + bgColor + ';">' +
          //     '<div class="custom-appointment-title">' + title + '</div>' +
          //     '<div class="custom-appointment-details">' + startDate + ' - ' + endDate + '</div>' +
          //     '</div>';
          //   return html;
          // },
          // onAppointmentAdded: function(e){
          //   alert('onAppointmentAdded')
          // },
          onAppointmentRendered: function(e){
            // note if == harus date format, jika lebih kecil maka pakai new Date()
            dataWarna.forEach(w => {
              var dateContent = new Date(e.targetedAppointmentData.displayStartDate)
              var dateData = new Date(w.date)
              if(w.id == e.appointmentData.AppointmentId){
                $(e.appointmentElement[0]).css('background-color', '#FD8A8A');
                if(dateContent < dateData){
                  setTimeout(() => {
                    $(e.appointmentElement[0]).css('background-color', '#7AA874');
                  }, 200);
                }
                if(w.statusid == 6){ // sedang proses
                  if(formatDate(dateContent) == formatDate(dateData)){
                    setTimeout(() => {
                      $(e.appointmentElement[0]).css('background-color', '#FFE569');
                    }, 250);
                  }
                }
              }
            });
          },
          allDayPanelMode: 'all',
          onContentReady(e) {
            // $('.addschedulerInject').remove()
            // $("<div>").appendTo($("#showscheduler .dx-toolbar-after .dx-buttongroup-wrapper"))
            // .dxButton({
            //   icon: "add",
            //   onClick: function() {
            //     scheduler.showAppointmentPopup();
            //   },
            //   elementAttr: {
            //     class: "addschedulerInject"
            //   }
            // });
          },
          // onContentReady(e) {
          //   $.ajax({
          //       type: 'GET',
          //       url: '{{url("/dataStatus")}}',
          //       success: function(dataWarna) {
          //         // console.log('dataWarna:',dataWarna);
          //         var appointmentArray = [];
          //         schedulerInstance = e.component;
          //         // Mendapatkan semua data appointment yang ditampilkan dalam view month
          //         const appointments = schedulerInstance.getAppointmentsInstance().option('items');
      
          //         // Menghitung jumlah data appointment
          //         const count = appointments.length;
          //         // console.log('Jumlah Data Appointment:', count);
      
          //         appointments.forEach(e => {
          //           var title = e.itemData.Text;
          //           var appointmentElements = $(`.dx-scheduler-appointment:contains(${title})`);
          //           // console.log(appointmentElements);
          //           var index = 0;
          //           e.settings.forEach(dt => {
          //             appointmentArray.push(dt.info.appointment.startDate);
          //             dataWarna.forEach(w => {
          //               if(w.title == title){
          //                 $(appointmentElements[index]).css('background-color', 'red');
          //                 if(w.statusid == 6){// Sedang Proses
          //                   if(new Date(dt.info.appointment.startDate) < new Date(w.date)){
          //                     $(appointmentElements[index]).css('background-color', 'yellow');
          //                   }
          //                 }
          //                 if(w.statusid == 7){// Paid
          //                   if(new Date(dt.info.appointment.startDate) < new Date(w.date)){
          //                     $(appointmentElements[index]).css('background-color', 'green');
          //                   }
          //                 }
          //               }
          //             });
          //             index++;
          //           });
          //         });
          //         // console.log(appointmentArray);
          //       },
          //       error: function(xhr, status, error) {
          //           new Noty({
          //               text: "Color Status Error",
          //               timeout: 10000 
          //           }).show();
          //       }
          //   });
          // },
        }).dxScheduler('instance');
    });
  }

 

</script>







