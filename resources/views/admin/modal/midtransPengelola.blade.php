<label class="mt-2">Nama</label>
<input id="mid-companyid" type="hidden" value="{{$data['companyid']}}">
<input type="text" class="form-control" value="{{$data['nama']}}" readonly>
<label class="mt-2">Email</label>
<input type="text" class="form-control" value="{{$data['email']}}" readonly>
<label class="mt-2">Perusahaan</label>
<input type="text" class="form-control" value="{{$data['companyname']}}" readonly>
<label class="mt-2" for="mid-serverKey">Server Key</label>
<input type="text" id="mid-serverKey" class="form-control" value="{{$data['serverkey']}}">
<label class="mt-2" for="mid-clientKey">Client Key</label>
<input type="text" id="mid-clientKey" class="form-control" value="{{$data['clientkey']}}">
<label class="mt-2" for="mid-merchat">Merchat ID</label>
<input type="text" id="mid-merchat" class="form-control" value="{{$data['merchantid']}}">
<button onclick="updatemid()" class="btn btn-primary mt-2">Simpan</button>
<button onclick="midcheck()" class="btn btn-danger mt-2">Test Connection Midtrans</button>

<script>
    function updatemid(){
        var companyid = $('#mid-companyid').val()
        var serverkey = $('#mid-serverKey').val()
        var clientkey = $('#mid-clientKey').val()
        var merchantid = $('#mid-merchat').val()
        $.ajax({
            type: 'POST',
            cache: false,
            url: '{{url("/updateMidtrans")}}',
            data: {companyid,serverkey,clientkey,merchantid},
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(msg) {
                showNty(msg)
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
    function midcheck(){
        var companyid = $('#mid-companyid').val()
        $.ajax({
            type: 'GET',
            cache: false,
            url: '{{url("/checkMidtrans")}}',
            data:{companyid},
            success: function(msg) {
                showNty(msg,10000)
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
</script>