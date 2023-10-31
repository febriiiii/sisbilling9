<style>
  .badge{
    cursor: pointer;
  }
</style>
<h6>Informasi</h6>
<div class="card p-3">
    <div class="row">
        <div class="col-6 row">
          <div class="col-4">
            Nama Lengkap 
          </div>
          <div class="col-auto">
            : <b>{{$data->namaU}}</b>
          </div>
        </div>
        <div class="col-6 row">
          <div class="col-4">
            Nama Perusahaan
          </div>
          <div class="col-auto">
            : <b>{{$data->companyname}}</b>
          </div>
        </div>
        <div class="col-6 row">
          <div class="col-4">
            Alamat Akun 
          </div>
          <div class="col-auto">
            : <b>{{$data->alamatU}}</b>
          </div>
        </div>
        <div class="col-6 row">
          <div class="col-4">
            Alamat Perusahaan
          </div>
          <div class="col-auto">
            : <b>{{$data->companyaddress}}</b>
          </div>
        </div>
        <div class="col-6 row">
          <div class="col-4">
            Email Akun
          </div>
          <div class="col-auto">
            : <b>{{$data->emailU}}</b>
          </div>
        </div>
        <div class="col-6 row">
          <div class="col-4">
            Email Perusahaan
          </div>
          <div class="col-auto">
            : <b>{{$data->emailP}}</b>
          </div>
        </div>
    </div>
</div>

<h6 class="mt-4">Buat Tagihan</h6>
<div class="card">
    <div class="row m-3">
        <div class="col-5">
            <label for="">Tagihan</label>
            <select class="form-select" id="addbillpengelolaProduk" style="font-size: .85em">
                @foreach ($produk as $p)
                    <option value="{{$p->productCode}}">{{$p->productName}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-5">
            <label for="">Deskripsi</label>
            <input type="text" id="addbillpengelolaDeskripsi" class="form-control" style="z-index: ">
        </div>
        <div class="col-1 mt-3">
            <button onclick="addbillpengelola()" class="btn btn-info">add</button>
        </div>
    </div>

</div>
<h6 class="mt-4">Daftar Tagihan</h6>
<div class="card">
    <table class="table align-middle mb-0 bg-white">
        <thead class="bg-light">
          <tr>
            <th>Nama Tagihan</th>
            <th>Aktif</th>
            <th>Tgl Mulai</th>
            <th>Tgl Selesai</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="addbillpengelolatbody">
          @if (count($tagihan) != 0)
            @foreach ($tagihan as $t)
            <tr id="TR{{$t->AppointmentId}}">
              <td>
                  <p class="fw-bold mb-1">{{$t->productName}}</p>
                  <p class="text-muted mb-0">{{$t->description}}</p>
              </td>
              <td>
                <span class="badge badge-success rounded-pill d-inline" onclick="openVP('{{$t->notrans}}')">{{$t->Aktif}}</span>
              </td>
              <td>{{Carbon\Carbon::parse($t->jatuhTempoTagihan)->format('j F Y')}}</td>
              <td>{{Carbon\Carbon::parse($t->FinishDate)->format('j F Y')}}</td>
              <td>
                <button type="button" class="btn btn-link btn-sm btn-rounded addbillpengelolaDelTrans" onclick="unsubscribe('{{$t->AppointmentId}}')">
                  Delete
                </button>
              </td>
            </tr>
          @endforeach
          @else
          <tr>
            <td colspan="5">
              <center><b>Tidak Ada Data</b></center>
            </td>
          </tr>
          @endif
          
        </tbody>
      </table>
</div>


<script>
  openAddbillpengelola = true;
  function openVP(notrans){
    var val = notrans
    if(val == null){
        return false;
    }
    $.ajax({
    url: '{{url("/viewpayment")}}',
    type: 'GET',
    cache: false,
    data: {val},
    success: function(data) {
        if(data != 0){
            openmodal2("Form Pembayaran",data)
        }else{
            showNty("Payment Error")
        }
    },
    error: function(xhr, status, error) {
        showNty(error,10000)
    }
    });
  }
    function addbillpengelola(){
      var productCode = $('#addbillpengelolaProduk').val();
      var Deskripsi = $('#addbillpengelolaDeskripsi').val();
      var userid = '{{$data->userid}}';
      if(productCode == ''){
        return false
      }
      $.ajax({
        type: 'POST',
        cache: false,
        url: '{{url("/subscribe")}}',
        data: {productCode,Deskripsi,userid},
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        },
        success: function(data) {
          description = data[0].description;
          if(data[0].description == null){
            description = '';
          }
          var tr = `<tr id="TR`+data[0].AppointmentId+`">
                    <td>
                        <p class="fw-bold mb-1">`+data[0].productName+`</p>
                        <p class="text-muted mb-0">`+description +`</p>
                    </td>
                    <td>
                      <span class="badge badge-danger rounded-pill d-inline" onclick="openVP(`+data[0].notrans+`)">`+data[0].Aktif+`</span>
                    </td>
                    <td>`+formatDate(data[0].jatuhTempoTagihan)+`</td>
                    <td>`+formatDate(data[0].FinishDate)+`</td>
                    <td>
                      <button type="button" class="btn btn-link btn-sm btn-rounded addbillpengelolaDelTrans" onclick="unsubscribe(`+data[0].AppointmentId+`)">
                        Delete
                      </button>
                    </td>
                  </tr>`
          if('{{count($tagihan)}}' != '0'){
            $('#addbillpengelolatbody').append(tr)
          }else{
            $('#addbillpengelolatbody').html(tr)
          }
          showNty('success')
        },
        error: function(xhr, status, error) {
          showNty(error,10000)
        }
      });
    }
    
    function unsubscribe(AppointmentId){
        var userid = '{{$data->userid}}';
        $.ajax({
          type: 'POST',
          cache: false,
          url: '{{url("/unsubscribe")}}',
          data: {AppointmentId,userid},
          beforeSend: function(xhr) {
              xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
          },
          success: function(data) {
            $(`#TR${AppointmentId}`).remove()
            showNty('success')
          },
          error: function(xhr, status, error) {
            showNty(error,10000)
          }
        });
    }
</script>