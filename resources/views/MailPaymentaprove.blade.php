<div id="mid" style="border-bottom: 1px solid #EEE;min-height: 80px;">
    <div class="info" style="display: block;margin-left: 0;">
    <h2 style="font-size: 0.9em;">Ada Pembayaran membutuhkan persetujuan anda.</h2>
    <table cellspacing="10" cellpadding="0" style="margin-bottom:10px; font-size: 0.7em;color: #666;line-height: 1.2em;">
        <tr>
            <td>Nama </td>
            <td> : {{$trans->nama}}</td>
        </tr>
        <tr>
            <td>Alamat </td>
            <td> : {{$trans->alamatSingkat}}</td>
        </tr>
        <tr>
            <td>Jatuh Tempo </td>
            <td> : {{Carbon\Carbon::parse($trans->jatuhTempoTagihan)->format('Y-m-d')}}</td>
        </tr>
        <tr>
            <td>Invoice No </td>
            <td id="transGR"> : {{$trans->notrans}}</td>
        </tr>
        <tr>
            <td>Total </td>
            <td> : {{number_format($trans->Amount)}}</td>
        </tr>
        {{-- <tr>
            <td>Angsuran </td>
            <td> : {{$trans->angsuran}}/~</td>
        </tr> --}}
        <tr>
            <td>Pembayaran </td>
            <td> : <span id="pembayaranRecipt">{{$trans->paymentname}}</span></td>
        </tr>
    </table>
    </div>
    <br>
    <p>Mohon untuk melakukan persetujuan melalui aplikasi <a href="{{url('/')}}">SisBilling</a>.</p>
    <br> <br><strong>Email ini dikirimkan secara otomatis. Mohon tidak membalas email ini.</strong>
</div>

<center>
    <a style="font-size: 1.5em; font-weight:bold;" href="{{url('/')}}">Sis Billing</a>
</center>