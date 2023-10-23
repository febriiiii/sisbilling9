<div class="container">
  {{-- <button class="btn btn-secondary mt-2 me-2" @if (count($countchat) == 1) onclick="opnchat({{$countchat[0]->chatid}})" @else onclick="opnheaderchat()" @endif>Pesan</button> --}}
  <button class="btn btn-secondary mt-2 me-2" onclick="opnheaderchat()">Pesan</button>
  <button class="btn btn-secondary mt-2 me-2" onclick="opnmdlpesanforum()">Pesan Forum</button>
  <div class="row justify-content-center" id="contentForum" style="padding-bottom: 20vh;">
    <div class="col-md-8" id="contentpengumuman">    
      @foreach ($tblpengumuman as $d)
        @if ($d->isPengumumanCompany != 1)
        <div id="pengumumanForum{{$d->pengumumanid}}" class="card mt-3">
          @php
              $statUser = " (Pengelola)";
              if($d->ispengelola == 0){
                $statUser = " (Umum)";
              }
          @endphp
          <div class="card-header" onclick="openpengumuman({{$d->userid}})" style="cursor: pointer;">
            <img src="{{asset('public/storage/'.$d->profileImg)}}" style="height:30px;width:30px;border-radius:100%;">
            <small style="width:100%;">{{$d->nama.$statUser}}</small>
            <div class="row text-end">
              <i style="font-size: 0.7em; position:absolute; margin-top:-10px; margin-left:-15px;">{{Carbon\Carbon::parse($d->InsertDT)->format('H:i d-M-Y')}}</i>
            </div>
          </div>

          <div class="card-body messages-container">
            <a class="messages">
                {!!$d->pengumuman!!}
            </a>
            @if ($d->polling != '')
              @php
                  $polling = json_decode($d->polling, true);
              @endphp
              <div class="card p-2" style="background-color: rgb(253, 255, 247); color:rgb(0, 0, 0); margin:0 -20px -20px -20px;">
                @php
                    $countUser = 0;
                    foreach ($polling as $p) {
                      $arryPolling = explode(';',$p);
                      $arrayuser = json_decode(isset($arryPolling[1]) ? $arryPolling[1] : null);
                      if (is_array($arrayuser) && $arrayuser !== null) {
                          $count = count($arrayuser);
                      } else {
                          $count = 0; 
                      }
                      $countUser = $countUser + $count;
                    }
                @endphp
                @foreach ($polling as $p)
                  @php
                    $checked = "";
                    $arryPolling = explode(';',$p);
                    $arrayuser = json_decode(isset($arryPolling[1]) ? $arryPolling[1] : null);
                    if (is_array($arrayuser)) {
                        if (in_array($UIDGlob->userid, $arrayuser)) {
                          $checked = "checked";
                        }
                        $count = count($arrayuser);
                    } else {
                        $count = 0; 
                    }
                    $pk = $d->pengumumanid.preg_replace('/\s+/', '',$arryPolling[0]);
                    $class = 'class'.$d->pengumumanid;
                  @endphp
                  <div class="row">
                    <div class="col-1">
                      <input {{$checked}} type="radio" id="{{$pk}}" pengumumanid="{{$d->pengumumanid}}" name="{{$class}}" class="uk-radio pollingclick" value="{{$arryPolling[0]}}" style="width:25px; height:25px; margin-top:10px;">
                    </div>
                    <label class="col-9" for="{{$pk}}" style="cursor: pointer;">
                      <small>{{$arryPolling[0]}}</small>
                      <span><input id="{{$pk}}range" type="range" class="uk-range {{$class}}" value="{{$count}}" max="{{$countUser}}" disabled></span>
                    </label>
                    <span class="col-2"><small id="{{$pk}}text" style="margin:12px 0 0 -20px; position:absolute; background-color: rgb(177, 177, 177); padding:3px; border-radius:10px 10px 10px 0; color:white">{{$count}}</small></span>
                  </div>
                @endforeach
                <center><small onclick='lihatpolling("{{$d->pengumumanid}}")' style="color:blueviolet; font-size:.8em;margin:0;padding:0; cursor:pointer;">Lihat Hasil Polling</small></center>
              </div>
            @endif
          </div>
          @if ($d->userid != $UIDGlob->userid)
            <div class="card-footer">
              <form class="send-message-form myforum-formsendpengumuman">
                <div class="input-group">
                  <input type="hidden" name="pengumumanid" value="{{$d->pengumumanid}}">
                  <input name="description" type="text" class="form-control myforum_descmsg" placeholder="Type your message" required>
                    <button class="btn btn-primary" type="submit" style="z-index: 0;">
                      <img width="18" height='18' src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAACXBIWXMAAAsTAAALEwEAmpwYAAAEdUlEQVR4nO2aTW/TWBSGLdggVsOSDWKFRpo/gBBL+A1sWLNlx441rNDsoapACNQWcCFVStqkJpA2bXHrxl83uLHDR1WVxmZgpEGiaDjIgbSJ61zf61x/xO2RzqZxrvWcnuQ9fnM47jAO48CE/O7ziZqxdXVZ3njJHZQAgKOaaV/QLWdcVDa+z1UboDVaE1zWQ1t3/kKmfRNZzpZm2lB+3YT8CwTKeutHs/nvn1xWWxxZzhVkOSKyHHBzVd+CvKDD1JwGK9omINPZ5LLa4siyv3XAkWXDvPgWJmeUNnyhYrT/rln2DS5rLY52oX9l7c1HKJTrwBfkNvzDqRVApg26Zf8vinCcy1KLI09WpfcwOavswo+MLYDaaP16vWGvctlpcacnFaMFsxWjDd6Bvz1WgWXlw9411udLXBZaHHlySd6AZ0V1H3y+rO1dZ9pfuSy0OOpKt7VL1fVd8G74B0+XQTf3rtUtm+eGucWRJ1fUTZgqab7wIxMVUIztnutTp/0aRYt3Z2eomZyRfeHdXJDe9b4vLdovU7a4NztDTTe4F/5ZSdlftCS1H0K2eG/uDTU4+Lu8+7m3e96bmPZrIVscN9Tg4N2s1T/uPyNO7ZcHbHHcUBME/0ps+s8HUWs/MGlx/FATBM/P1ED3OytK7dcYtXjQUBMEP8pX28rgdxZz7ZcZt3jQUBME76akb/U9k4n2QwQtTjLUkMALS43+5w6q/VpELU4y1JDAj+dX8WeH0X45whYnHWpI4EcnFl1fr+/ZobRfN52/kWXvRA2OG2pI4N1sW1u4e4TRftX8dEo3bTNKeNxQQwrfsbZwGVr71QiLgBtqSOE71hb2XoNqv8q4CEFDDSl8j7WFSSbarzIqQtBQQwrvtbZwyey5Xx2gCCRDDQ18j7WFbX/Gz/1qiCKQDDU08F5rC5eRPPerhEUgHWpo4P2sLcxnP7rnfjWgCKRDDQ28r7WFy6if+1XfIpAPNbTwftYWVm3i8PzVriLQDDW08H7WFv7LL0bPHzX/Ob0gvf9COtTsgxfw8H2trai1nyZyJW0niv88ztqKRftJQhCaxyYL7D/zWGsrTu0PimLVuBgFPM7ail37cSEsWddZwwdZW4lof78oLqw/Zg2PtbaS1H6/mK0Yayzhg6ytxLXfG9Nl1GIFH2RtpUb7aSSQFJ7I2kqT9pNIIA08ibWVGu0nkUAaeCJrK03aHySBNPCk1laqtB8ngTTwNNZWqrS/nwTSwhNbW2nT/k48L9e3w8Df4xe/TUxLht5oDfzbYqK7frnfEoiDvzM2D/efLv/3aFpayxWVW8J8fffbWm9+OTvQr09J7voJvyXQCz/yaP7Hw5zo8IW1F7k55ZogSH/gzhmkCInu+hWrxkUX/h6/uDOel0y+VHsyJWiXAeAI7Vlhi5Dorp8obp+cfWmeYXUeeuuc0037e+q1P8qg6YTM7PmHKcLQ7/kPXIRh3PNnWYSh2vNnXoRh2POPsgip3fOPqwip2/OPK+rmp/N6w5Ziu+FhcAczfgImbNaj6l8OQQAAAABJRU5ErkJggg==">
                    </button>
                </div>
              </form>
            </div>
          @endif
        </div>
        @endif
      @endforeach
    </div>
  </div>
</div>
  <script>

  function opnmdlpesanforum(){
      $.ajax({
          type: 'GET',
          cache: false,
          url: '{{url("/viewaddpesanforum")}}',
          success: function(data) {
              openmodal('Form Pengumuman',data)
          },
          error: function(xhr, status, error) {
            showNty(error,10000)
          }
      });
  }


    pollingClick()
    function pollingClick(){
      $('.pollingclick').unbind()
      $('.pollingclick').on('change',function(){
        var id = $(this).prop('id')
        var pengumumanid = $(this).attr('pengumumanid')
        var arraypolling = $(this).val()
        $.ajax({
            type: 'GET',
            cache: false,
            url: '{{url("/polling")}}',
            data: {pengumumanid,arraypolling,id},
            error: function(xhr, status, error) {
              showNty("Terjadi kesalahan server. Akan otomatis reload dalam waktu 4 detik.",4000)
              setTimeout(function() {
                location.reload();
              }, 4000);
            }
        });
      })
    }
    function generateRandomId() {
      const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      const length = 8;
      let randomId = '';

      for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * characters.length);
        randomId += characters.charAt(randomIndex);
      }

      return randomId;
    }
    function lihatpolling(pengumumanid){
      $.ajax({
          type: 'GET',
          cache: false,
          url: '{{url("/viewpolling?pengumumanid=")}}'+pengumumanid,
          success: function(data) {
              openmodal("Polling Informasi",data,pengumumanid)
          },
          error: function(xhr, status, error) {
            showNty(error,10000)
          }
      });
    }
    function createpolling(){
      var id = generateRandomId();
      var polling = `<div id='`+id+`' class="card p-2 m-2 mt-2" style="background-color: rgb(253, 255, 240)">`+
                    `<div class="row">`+
                      `<div class="col-9">`+
                        `<input required name='polling[]' type="text" class="form-control" placeholder="Pooling Name">`+
                        `<div class="range">`+
                          `<input disabled type="range" class="form-range" id="customRange1" value="110" min="0" max="100"/>`+
                        `</div>`+
                      `</div>`+
                      `<div class="col-3">`+
                        `<button onclick="rmvpolling('`+id+`')" type="button" class="btn btn-danger"><i style="font-size: 20px;" class="las la-trash-alt"></i></button>`+
                      `</div>`+
                    `</div>`+
                  `</div>`
      $('#pollingwrap').append(polling)
    }
    function rmvpolling(id){
      $('#'+id).remove()
    }
    function createpengumumanforum(d){
      var date = new Date(d.InsertDT);
      var options = {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
      };
      var time = date.toLocaleString('en-US', options);

      var day = date.getDate();
      var month = date.toLocaleString('en-US', { month: 'short' });
      var year = date.getFullYear();

      var DTh = time + ' ' + day + '-' + month + '-' + year;
      var statUser = " (Pengelola)";
      var contentpolling = "";
      var plg = 0;
      if (d.polling != '') {
        var polling = JSON.parse(d.polling)
        let countUser = 0;
        polling.forEach(p => {
          let arryPolling = p.split(';');
          let arrayuser = JSON.parse(arryPolling[1] || null);
          let count = Array.isArray(arrayuser) && arrayuser !== null ? arrayuser.length : 0;
          countUser += count;
        });
        polling.forEach(p => {
          let checked = "";
          let arryPolling = p.split(';');
          let arrayuser = JSON.parse(arryPolling[1] || null);
          let count = 0;
          let pk = d.pengumumanid + arryPolling[0].replace(/\s+/g, '');
          let classValue = 'class' + d.pengumumanid;

          if (Array.isArray(arrayuser)) {
            if (arrayuser.includes(auth().user.userid)) {
              checked = "checked";
            }
            count = arrayuser.length;
          } else {
            count = 0;
          }
          var contentpollingTemp = `<div class="row">
                                      <div class="col-1">
                                        <input ${checked} type="radio" id="${pk}" pengumumanid="${d.pengumumanid}" name="${classValue}" class="uk-radio pollingclick" value="${arryPolling[0]}" style="width:25px; height:25px; margin-top:10px;">
                                      </div>
                                      <label class="col-9" for="${pk}" style="cursor:pointer;">
                                        <small>${arryPolling[0]}</small>
                                        <span><input id="${pk}range" type="range" class="uk-range ${classValue}" value="${count}" max="${countUser}" disabled></span>
                                      </label>
                                      <span class="col-2"><small id="${pk}text" style="margin:12px 0 0 -20px; position:absolute; background-color: rgb(177, 177, 177); padding:3px; border-radius:10px 10px 10px 0; color:white">${count}</small></span>
                                    </div>`
          contentpolling = contentpolling + contentpollingTemp;
          plg++;
        });
      }
      hidden = '';
      if(plg == 0){
        hidden = 'hidden';
      }
      var hidFoot = `<div class="card-footer">` +
                        `<form class="send-message-form myforum-formsendpengumuman">` +
                          `<div class="input-group">` +
                            `<input type="hidden" name="pengumumanid" value="`+d.pengumumanid+`">` +
                            `<input name="description" type="text" class="form-control myforum_descmsg" placeholder="Type your message" required>` +
                              `<button class="btn btn-primary" type="submit" style="z-index: 0;">` +
                                `<img width="18" height='18' src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAACXBIWXMAAAsTAAALEwEAmpwYAAAEdUlEQVR4nO2aTW/TWBSGLdggVsOSDWKFRpo/gBBL+A1sWLNlx441rNDsoapACNQWcCFVStqkJpA2bXHrxl83uLHDR1WVxmZgpEGiaDjIgbSJ61zf61x/xO2RzqZxrvWcnuQ9fnM47jAO48CE/O7ziZqxdXVZ3njJHZQAgKOaaV/QLWdcVDa+z1UboDVaE1zWQ1t3/kKmfRNZzpZm2lB+3YT8CwTKeutHs/nvn1xWWxxZzhVkOSKyHHBzVd+CvKDD1JwGK9omINPZ5LLa4siyv3XAkWXDvPgWJmeUNnyhYrT/rln2DS5rLY52oX9l7c1HKJTrwBfkNvzDqRVApg26Zf8vinCcy1KLI09WpfcwOavswo+MLYDaaP16vWGvctlpcacnFaMFsxWjDd6Bvz1WgWXlw9411udLXBZaHHlySd6AZ0V1H3y+rO1dZ9pfuSy0OOpKt7VL1fVd8G74B0+XQTf3rtUtm+eGucWRJ1fUTZgqab7wIxMVUIztnutTp/0aRYt3Z2eomZyRfeHdXJDe9b4vLdovU7a4NztDTTe4F/5ZSdlftCS1H0K2eG/uDTU4+Lu8+7m3e96bmPZrIVscN9Tg4N2s1T/uPyNO7ZcHbHHcUBME/0ps+s8HUWs/MGlx/FATBM/P1ED3OytK7dcYtXjQUBMEP8pX28rgdxZz7ZcZt3jQUBME76akb/U9k4n2QwQtTjLUkMALS43+5w6q/VpELU4y1JDAj+dX8WeH0X45whYnHWpI4EcnFl1fr+/ZobRfN52/kWXvRA2OG2pI4N1sW1u4e4TRftX8dEo3bTNKeNxQQwrfsbZwGVr71QiLgBtqSOE71hb2XoNqv8q4CEFDDSl8j7WFSSbarzIqQtBQQwrvtbZwyey5Xx2gCCRDDQ18j7WFbX/Gz/1qiCKQDDU08F5rC5eRPPerhEUgHWpo4P2sLcxnP7rnfjWgCKRDDQ28r7WFy6if+1XfIpAPNbTwftYWVm3i8PzVriLQDDW08H7WFv7LL0bPHzX/Ob0gvf9COtTsgxfw8H2trai1nyZyJW0niv88ztqKRftJQhCaxyYL7D/zWGsrTu0PimLVuBgFPM7ail37cSEsWddZwwdZW4lof78oLqw/Zg2PtbaS1H6/mK0Yayzhg6ytxLXfG9Nl1GIFH2RtpUb7aSSQFJ7I2kqT9pNIIA08ibWVGu0nkUAaeCJrK03aHySBNPCk1laqtB8ngTTwNNZWqrS/nwTSwhNbW2nT/k48L9e3w8Df4xe/TUxLht5oDfzbYqK7frnfEoiDvzM2D/efLv/3aFpayxWVW8J8fffbWm9+OTvQr09J7voJvyXQCz/yaP7Hw5zo8IW1F7k55ZogSH/gzhmkCInu+hWrxkUX/h6/uDOel0y+VHsyJWiXAeAI7Vlhi5Dorp8obp+cfWmeYXUeeuuc0037e+q1P8qg6YTM7PmHKcLQ7/kPXIRh3PNnWYSh2vNnXoRh2POPsgip3fOPqwip2/OPK+rmp/N6w5Ziu+FhcAczfgImbNaj6l8OQQAAAABJRU5ErkJggg==">` +
                              `</button>` +
                          `</div>` +
                        `</form>` +
                      `</div>`
      if(d.userid == "{{$UIDGlob->userid}}"){
        hidFoot = ""
      }
      var content = `<div id="pengumumanForum`+d.pengumumanid+`" class="card mt-3"> ` +
                      `<div class="card-header" onclick="openpengumuman(`+d.userid+`)" style="cursor: pointer;">` +
                        `<img src="`+d.profileImg+`" style="height:30px;width:30px;border-radius:100%;">` +
                        `<small style="width:100%;">`+ d.nama + statUser +`</small>` +
                        `<div class="row text-end">` +
                          `<i style="font-size: 0.7em; position:absolute; margin-top:-10px; margin-left:-15px;">` + DTh +`</i>` +
                        `</div>` +
                      `</div>` +
              
                      `<div class="card-body messages-container">` +
                        `<a class="messages">` +
                            d.pengumuman +
                        `</a>`+
                        `<div `+hidden+` class="card p-2" style="background-color: rgb(253, 255, 247); color:rgb(0, 0, 0); margin:0 -20px -20px -20px;">`+ 
                          contentpolling+
                          `<center><small onclick='lihatpolling(`+d.pengumumanid+`)' style="color:blueviolet; font-size:.8em;margin:0;padding:0; cursor:pointer;">Lihat Hasil Polling</small></center>`+
                        `</div>`+
                      `</div>` +
              
                      hidFoot+
                    `</div>`
      if(d.isPengumumanCompany == 0){
        $('#contentpengumuman').prepend(content)
      }
      $('#val-pengumuman').val("")
      closemodal()
      pollingClick()
      submitreloadformsendpengumuman()
    }
    submitreloadformsendpengumuman()
    function submitreloadformsendpengumuman(){
      $('.myforum-formsendpengumuman').unbind().submit(function(g){
        g.preventDefault()
        var pengumumanid = $(this).serializeArray().find(item => item.name === 'pengumumanid').value
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            cache: false,
            url: '{{url("/replypengumuman")}}',
            data: $(this).serialize(),
            success: function(userid) {
              if(userid == -1){
                showNty("Tidak Bisa Membalas Pengumuman Anda Sendiri")
                return false;
              }
              openpengumuman(userid)
              $('.myforum_descmsg').val("")
            },
            error: function(xhr, status, error) {
              showNty(error,10000)
            }
        });
      })
    }
    function openpengumuman(userid){
      $.ajax({
            type: 'GET',
            cache: false,
            url: '{{url("/getchatid")}}',
            data: {userid},
            success: function(data) {
              if(data == 0){
                showNty("Tidak Bisa Membalas Pengumuman Anda Sendiri")
                return false
              }
              opnchat(data.chatid)
            },
            error: function(xhr, status, error) {
              showNty(error,10000)
            }
        });
    }
    function opnchat(chatid){
      $.ajax({
          type: 'GET',
          cache: false,
          url: '{{url("/viewchat")}}',
          success: function(data) {
              openmodal("",data,chatid)
          },
          error: function(xhr, status, error) {
            showNty(error,10000)
          }
      });
    }
    function opnheaderchat(){
      $.ajax({
            type: 'GET',
            cache: false,
            url: '{{url("/viewHeaderchat")}}',
            success: function(data) {
                openmodal("Pesan",data,"")
            },
            error: function(xhr, status, error) {
              showNty(error,10000)
            }
        });
    }
  </script>