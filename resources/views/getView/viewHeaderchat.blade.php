<div id="contentchatheader" class="container">
    <div class="row p-1">
        <div class="col me-2" id="searchBox"></div>
        <button onclick="createChatHeader()" class="col-auto btn btn-secondary">Chat</button>
    </div>
    @foreach ($tblchat as $c)
        <div class="mt-2" onclick="opnchat({{$c->chatid}})" style="border-radius:5px; height: 70px; overflow:hidden; cursor: pointer; background-color: rgb(239, 239, 239)">
            <div class="row">
                <div class="col-auto" style="margin:0; padding:15px;">
                    <img src="{{asset('public/storage/'.$c->profileImg)}}" width="40" height="40" style="border-radius:100%;">
                </div>
                <div class="col-9">
                    <div class="d-flex">
                        <small class="normal col-auto">{{$c->nama}}</small>
                        <small class="col" style="text-align: end;">{{Carbon\Carbon::parse($c->InsertDT)->format('H:i d-M-Y')}}</small>
                    </div>
                    <hr class="normal">
                    @php
                        $lastC = ($c->latestChat == "!@##@!IMG!@##@!")?"Mengirim Gambar":$c->latestChat;
                    @endphp
                    <p>{!!$lastC!!}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
    function createChatHeader(){
        userid = $('#searchBox').dxSelectBox('option', 'value');
        if(userid == null){
            showNty("Tolong Pilih User")
            return false
        }
        $.ajax({
          type: 'GET',
          cache: false,
          url: '{{url("/getchatLawan")}}',
          data:{userid},
          success: function(chatid) {
            opnchat(chatid)
          },
          error: function(xhr, status, error) {
            showNty(error,10000)
          }
      });
    }
    
    $.ajax({
        url: '{{ url("/chatHeader") }}?stamp=' + new Date().getTime(),
        method: 'GET',
        success: function (data) {
            $('#searchBox').dxSelectBox({
                inputAttr: { 'aria-label': 'Product userid' },
                dataSource: new DevExpress.data.ArrayStore({
                    data: data,
                    key: 'userid',
                }),
                displayExpr: 'nama',
                valueExpr: 'userid',
                searchEnabled: true,
                // value: '2',
            });
        }
    });
    
</script>