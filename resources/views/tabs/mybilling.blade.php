
<style>
    .ribbon-2 {
  --f: 10px; /* control the folded part*/
  --r: 15px; /* control the ribbon shape */
  --t: 10px; /* the top offset */
  color: white;
  position: absolute;
  inset: var(--t) calc(-1*var(--f)) auto auto;
  padding: 0 10px var(--f) calc(10px + var(--r));
  clip-path: 
    polygon(0 0,100% 0,100% calc(100% - var(--f)),calc(100% - var(--f)) 100%,
      calc(100% - var(--f)) calc(100% - var(--f)),0 calc(100% - var(--f)),
      var(--r) calc(50% - var(--f)/2));
  box-shadow: 0 calc(-1*var(--f)) 0 inset rgba(112, 112, 112, 0.333);
}


.box {
  max-width:700px;
  height:200px;
  margin:50px auto 0;
  background:lightblue;
  position:relative;
}
</style>


<div class="scedulerket row p-2">
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
    <div class="col-auto me-4">
      <div class="row">
        <div class="col-auto" style="padding:0">
          <div class="scedulerketDot" style="background-color: #08e7fb; height:20px; width:20px; border-radius:100%;"></div>
        </div>
        <div class="col" style="padding:0 0 0 5px;">
          <div>Menunggu Pembayaran</div>
        </div>
      </div>
    </div>
</div>
<div class="container" id="contentmybilling">
  
</div>
<script>
    function loadbilling(){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '{{url("/getbill")}}',
            success: function(data) {
                $('#contentmybilling').html("")
                if(data.length > 0){
                  data.forEach(e => {
                      var color = "#FD8A8A";
                      if(e.statusid == 6){
                          color = "#FFE569";
                      }else if(e.statusid == 11){
                        color = "#08e7fb";
                      }
                      var content = `<div class="card box" style="border-radius:15px; margin-top:0;margin-bottom:15px;">` +
                                      `<div class="ribbon-2" style="background:`+color+`">`+e.productName+`</div>` +
                                      `<div class="row">` +
                                          `<div onclick="payment('`+e.notrans+`')" class="col-auto p-2 btn" style="border-radius:15px 0 0 15px; background-color: `+color+`">` +
                                              `<img style="height:40px;width:40px;" src="{{asset('public/payment.png')}}">` +
                                          `</div>` +
                                          `<div class="col p-2">` +
                                              `<ul style="padding: 0;">` +
                                                  `<li style="list-style-type: none;">` +
                                                      `<strong style="display: inline-block;">`+e.notrans+`</strong>` +
                                                  `</li>` +
                                                  `<li style="list-style-type: none;" class="row">` +
                                                      `<span class="icon col-auto" style="margin-right:0px;">` +
                                                          `<img width="20" height="20" src="{{asset('public/checklist.png')}}" alt="checkmark--v1"/>` +
                                                      `</span>` +
                                                      `<div class="col"><strong style="display: inline-block;">Jatuh Tempo:</strong><span style="padding-left: 1em;">`+formatDate(e.jatuhTempoTagihan)+`</span></div>` +
                                                  `</li>` +
                                                  `<li style="list-style-type: none;" class="row">` +
                                                      `<span class="icon col-auto" style="margin-right:0px;">` +
                                                          `<img width="20" height="20" src="{{asset('public/checklist.png')}}" alt="checkmark--v1"/>` +
                                                      `</span>` +
                                                      `<div class="col"><strong style="display: inline-block;">Amount:</strong><span style="padding-left: 1em;">`+formater.format(e.Amount)+`</span></div>` +
                                                  `</li>` +
                                              `</ul>` +
                                          `</div>` +
                                      `</div>` +
                                  `</div>`;
                        $('#contentmybilling').append(content)
                  });
                }else{
                  var content = `<center>`+
                                  `<div class="alert alert-warning" role="alert">`+
                                    `<div class="d-flex align-items-center">`+
                                      `<i class="fas fa-exclamation-triangle me-2"></i>`+
                                      `<div>Anda Tidak Memiliki Tagihan</div>`+
                                    `</div>`+
                                  `</div>`+
                                `</center>`
                  $('#contentmybilling').append(content)
                }
            },
            error: function(xhr, status, error) {
                new Noty({
                    text: error,
                    timeout: 10000 
                }).show();
            }
        });
    }
</script>