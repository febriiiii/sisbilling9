@foreach ($data as $key => $val)
    <div class="card mt-2">
        <div class="card-header" style="font-weight:bold;">{{$key}}</div>
        <div class="card-body" >
            @if (count($val) != 0)
                @foreach ($val as $d)
                    <div class="p-1"><img style="margin-right: 20px; height:30px;width:30px; border-radius:100%;" src="{{asset('public/storage/'.$d->profileImg)}}"><span style="margin-top:4px; position: absolute; font-weight:bold;">{{$d->nama}}</span></div>    
                @endforeach
            @else
                <center>Belum Ada Yang Memilih</center>
            @endif
        </div>
    </div>
@endforeach