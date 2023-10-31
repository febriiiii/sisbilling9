// PWA
// if ('serviceWorker' in navigator) {
//   window.addEventListener('load', function() {
//       navigator.serviceWorker.register(URLserviceworker).then(function(registration) {
//       }, function(error) {
//       console.log('Service Worker gagal didaftarkan:', error);
//       });
//   });
// }
//-------------------------------------------------------------------------------------------------------------------------------------------------------
const jsPDF = window.jspdf.jsPDF;
//-------------------------------------------------------------------------------------------------------------------------------------------------------
// Pusher
Pusher.logToConsole = false;
//-------------------------------------------------------------------------------------------------------------------------------------------------------
// SSE URLsse = '{{ url("/paymentWebHook") }}'
// const eventSource = new EventSource(URLsse);
// eventSource.onmessage = function (event) {
//     const data = JSON.parse(event.data);
//     console.log(data);
// };
document.addEventListener('keydown', function(event) {
  if (event.ctrlKey && event.key === 'c') {
      paymentsuccess();
  }
});
var transG = null
function paymentsuccess(){
  if(transG == null){
      return false;
  }
  $('#loader').show('slow')
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $.ajax({
      type: 'POST',
      cache: false,
      url: URLconfirmPembayaranMID,
      data: {'notrans' : transG},
      success: function(data) {
          if(data.msg == 'settlement'){
            showNty(data.msg)
          }
          renderlonceng()
          if (typeof querysaled === 'function') {
              querysaled()
          }
          if (typeof querysaledBil === 'function') {
              querysaledBil()
          }
          loadbilling()
          if(data.status == 407){
              snapToken = data.snapToken //update dari tbltrans terbaru 
              transG = data.transG //update dari tbltrans terbaru
              $('#transG').val(transG)
              $('#transGR').html(' : '+transG)
              $('#gatewayClose').show()
              $('#gatewayOpen').hide()
          }else if(data.status == 200){
              $('.onpay').html(`<center>
                                    <h3 class="mt-4" style="color:red;">LUNAS</h3>
                                </center>`)
          }else if(data.status == 201){
            $('#gatewayClose').hide()
            $('#gatewayOpen').show()
          }else if(data.status == 404){
            snapToken = data.snapToken
            transG = data.transG
          }
          $('#loader').hide('slow')
      },
      error: function(xhr, status, error) {
        showNty(error,10000)
        $('#loader').hide('slow')
      }
  });
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------
// payment
  function formatDate(dateString) {
    // Membuat objek Date dari string tanggal
    var date = new Date(dateString);

    // Array nama bulan
    var monthNames = [
      "Januari", "Februari", "Maret", "April", "Mei",
      "Juni", "Juli", "Agustus", "September", "Oktober",
      "November", "Desember"
    ];

    // Mendapatkan tanggal, bulan, dan tahun dari objek Date
    var day = date.getDate();
    var monthIndex = date.getMonth();
    var year = date.getFullYear();

    // Format tanggal ke format yang diinginkan
    var formattedDate = day + " " + monthNames[monthIndex] + " " + year;

    return formattedDate;
  }
function payment(notrans){
    var val = notrans
    $.ajax({
        url: URLviewpayment,
        type: 'GET',
        data: {val},
        success: function(data) {
          if(data != 0){
              openmodal2("Form Pembayaran",data)
          }else{
            showNty('Payment Error',10000)
          }
        },
        error: function(xhr, status, error) {
          showNty(error,10000) 
        }
    });
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------
// pusher config on-login
  var openChat = false;
  var openAddbillpengelola = false;
// pusher 
    const strcid = CID;
    const arrayCompany = strcid.split(',').map(item => parseInt(decodeURIComponent(item.trim().replace(/&#039;/g, ''))));
    var pusher = new Pusher(PUSHER_APP_KEY, {
      cluster: PUSHER_APP_CLUSTER
    });

    if (channel) {
        channel.unbind();
    }
    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        if(data.type == 'chat'){
          if(typeof chatid === 'undefined'){
            return false;
          }
          if(data.chatid == chatid){
              var position = "left";
              var name = "<i>"+data.nama+"</i><br>"
              if(UIDGlob.userid == data.authuser){
                  position = "right"
                  name = ""
              }
              if(data.description != "!@##@!IMG!@##@!"){
                  msg = data.description+"<small>"+data.InsertDT+"</small>"
              }else{
                  msg = `<div style="background-image: url('`+URLchatimg+`/`+data.id+`.png'); background-size: cover; width: 180px; height:130px;"></div>
                      <small style="display: block; text-align:end;">`+data.InsertDT+`</small>`;
              }
              var chat = "<li class='message item "+position+"'> " +
                              name+"<p>"+msg+"</p>" +
                          "</li>"
              contentchat.append(chat)
              scrolltoBottomChat()
              if(data.authuser != UIDGlob.userid){
                if(openChat){
                  $.ajax({
                      url: URLreadchat,
                      type: 'GET',
                      data: {chatid},
                      success: function() {
                        renderlonceng()
                      },
                  });
                }
              }
          }
        }if(data.type == 'komentarcompany'){
          if(typeof pengumumanid === 'undefined'){
            return false;
          }
          if(data.pengumumanid == pengumumanid){
              var urli = 'public/storage/'+data.profileImg
              var name = `<img src="`+asset+urli+`" style="border-radius:100%; width:20px; height:20px; margin-right:10px;"><b>`+data.nama+`</b><small> `+new Date(data.InsertDT).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })+`</small><br>`
              var komentar = "<li class='msgkmtr item'> " +
                              name+"<p style='margin-left:30px;'>"+data.pesan+"</p>" +
                          "</li>"
              contentkomentar.append(komentar)

              scrolltoBottomkomentar()
          }
        }if(data.type == 'pesancompany'){
          var data = data.data
          if (arrayCompany.includes(parseInt(data.companyid))) {
            var content = `<div id="pengumumanCompany`+data.pengumumanid+`" class="p-2 m-2" style="outline: 1px solid rgb(187, 178, 178);">` +
                            `<div class="row">` +
                              `<center><h6>`+data.judul+`</h6></center>` +
                              `<small style="text-align: justify;" class="col-12">`+data.pengumuman+`</small>` +
                              `<small class="col d-flex" style="font-weight:bold;">(`+data.companyname+`) `+ data.InsertDT+`</small>` +
                              `<small onclick="openkomentarpengumuman('`+data.pengumumanid+`','`+data.judul+`')" class="col-auto" style="color:rgb(98, 98, 233);cursor: pointer;"><i class="las la-comment-alt"></i>Komentar</small>` +
                            `</div>` +
                          `</div>`;
            $('#contentpengumumancompany').prepend(content);
          }
        }else if(data.type == 'polling'){
          $(`.${data.classmax}`).attr('max',data.countUser)
          $(`#${data.id.replace(/\s/g, "")}range`).val(parseInt($(`#${data.id.replace(/\s/g, "")}range`).val()) + parseInt(1))
          $(`#${data.id.replace(/\s/g, "")}text`).text(parseInt($(`#${data.id.replace(/\s/g, "")}text`).text()) + parseInt(1))
          if(data.idrmv != false){
            $(`#${data.idrmv.replace(/\s/g, "")}range`).val(parseInt($(`#${data.idrmv.replace(/\s/g, "")}range`).val()) - parseInt(1))
            $(`#${data.idrmv.replace(/\s/g, "")}text`).text(parseInt($(`#${data.idrmv.replace(/\s/g, "")}text`).text()) - parseInt(1))
          }
        }else if(data.type == 'notif'){
          if(data.authuser == UIDGlob.userid){
            renderlonceng()
          }else if(data.authuser == null){
            renderlonceng()
          }
        }else if(data.type == 'pengumumanforum'){
          createpengumumanforum(data.data)
        }else if(data.type == 'renderMyBilling'){
          if(data.authuser == UIDGlob.userid){
            loadbilling()
          }
        }else if(data.type == 'renderMyCustomer'){
          if(data.authuser == UIDGlob.userid){
            tblcustomer()
          }
        }else if(data.type == 'renderMyDashboard'){
          if(data.authuser == UIDGlob.userid){
            reloadDashboard()
          }
        }else if(data.type == 'renderGlobal'){
          if(data.authuser == UIDGlob.userid){
            reloadDashboard()
            loadbilling()
            tblcustomer()
            renderlonceng()
            if (typeof querysaled === 'function') {
              querysaled()
            }
            if (typeof querysaledBil === 'function') {
                querysaledBil()
            }
          }
        }else if(data.type == 'midtransHook'){
          if(data.authuser == UIDGlob.userid){
            transG = data.type.split('|')[1]
            if(data.msg == 'settlement'){
              showNty(data.msg)
            }
            renderlonceng()
            if (typeof querysaled === 'function') {
                querysaled()
            }
            if (typeof querysaledBil === 'function') {
                querysaledBil()
            }
            loadbilling()
            if(data.status == 407){
                snapToken = data.snapToken //update dari tbltrans terbaru 
                transG = data.transG //update dari tbltrans terbaru
                $('#transG').val(transG)
                $('#transGR').html(' : '+transG)
                $('#gatewayClose').show()
                $('#gatewayOpen').hide()
            }else if(data.status == 200){
                $('.onpay').html(`<center>
                                      <h3 class="mt-4" style="color:red;">LUNAS</h3>
                                  </center>`)
            }else if(data.status == 201){
              $('#gatewayClose').hide()
              $('#gatewayOpen').show()
            }else if(data.status == 404){
              snapToken = data.snapToken
              transG = data.transG
            }
          }
        }      
    });
//-------------------------------------------------------------------------------------------------------------------------------------------------------
    const formater = new Intl.NumberFormat("en-EN", { minimumFractionDigits: 0 })
    localStorage.setItem('back', null);
//-------------------------------------------------------------------------------------------------------------------------------------------------------
//  iframe 
function iframeLoadSrcScript(iframe){
  // Mengakses konten dalam iframe
  var iframeContent = iframe.contentDocument || iframe.contentWindow.document;
  
  // Mengeksekusi skrip yang dikembalikan oleh server
  var scriptElement = iframeContent.querySelector('script');
  if (scriptElement) {
    eval(scriptElement.innerText);
  }
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------
function showNty(msg,timeout){
  if(msg == 'Unauthorized'){
    window.location.href = URLlogout
  }else{
    new Noty({
      text: msg,
        timeout: timeout || 2000 
    }).show();
  }
}