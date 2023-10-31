<div class="dropdown headericonX">
    <a href="#" class="notification" data-mdb-toggle="dropdown">
        {{-- <span><img src="{{asset('public/bell-ring.png')}}" width="30" height="30"></span> --}}
        <lord-icon
            src="https://cdn.lordicon.com/psnhyobz.json"
            trigger="click"
            colors="primary:#ffffff"
            style="width:30px;height:30px">
        </lord-icon>
        @php
            if(session('UIDGlob')->companyid != '' && session('UIDGlob')->scrb < 1){
                if(session('UIDGlob')->superadmin != 1){
                    $notif['count'] = $notif['count'] + 1;
                }
            }
        @endphp
        @if ($notif['count'] != 0)
            <span class="badge" style="background-color: whitesmoke;color:black; position: absolute; margin-left:-10px; margin-top:-7px">{{$notif['count']}}</span>
        @endif
    </a>
    <ul class="dropdown-menu" style="position: absolute; left:-170px; box-shadow:-3px 3px 6px rgb(221, 221, 221)">
        @if (session('UIDGlob')->companyid != '' && session('UIDGlob')->scrb < 1)
            @if (session('UIDGlob')->superadmin != 1)
                <div class="uk-alert-danger" uk-alert>
                    <p>Akun Anda Telah Habis Masa Aktif, Tolong Lakukan Pembayaran</p>
                    <p>Jika Butuh Bantuan Hubungi CS SisBilling.</p>
                </div>
            @endif
        @endif
        @foreach ($notif['myAgendda'] as $i)
            <li onclick=""><a class="dropdown-item card mt-1" href="#">{{$i->text}} </a></li>
        @endforeach
        @foreach ($notif['pengumuman'] as $p)
            @php
                if (strlen($p->judul) > 20) {
                    $limitedString = substr($p->judul, 0, 20) . '...';
                } else {
                    $limitedString = $p->judul;
                }
                if($p->isPengumumanCompany == 1){
                    $indexLi = 0;
                }else{
                    $indexLi = 2;
                    if(session('UIDGlob')->companyid != null){
                        $indexLi = 3;
                    }
                }
            @endphp
            <li onclick="showpengumuman('{{session('UIDGlob')->userid}}','{{$p->pengumumanid}}','{{$indexLi}}')"><a class="dropdown-item card mt-1" href="#">Pengumuman : {{$limitedString}}</a></li>
        @endforeach
        @foreach ($notif['chat'] as $c)
            @php
                if (strlen($c->nama) > 20) {
                    $limitedString = substr($c->nama, 0, 20) . '...';
                } else {
                    $limitedString = $c->nama;
                }
            @endphp
            <li onclick="opnchat({{$c->chatid}})"><a class="dropdown-item card mt-1" href="#">{{$c->total}} Pesan Dari {{$limitedString}} </a></li>
        @endforeach
        @foreach ($notif['invoice'] as $i)
            <li onclick="payment('{{$i->notrans}}')"><a class="dropdown-item card mt-1" href="#">Tagihan : {{$i->Text}} </a></li>
        @endforeach
        @foreach ($notif['invoiceReject'] as $i)
            <li onclick="payment('{{$i->notrans}}')"><a class="dropdown-item card mt-1" href="#">Reject {{$i->Text}} : {{$i->notrans}} </a></li>
        @endforeach
        @foreach ($notif['invoiceWaiting'] as $i)
            <li onclick="payment('{{$i->notrans}}')"><a class="dropdown-item card mt-1" href="#">Approval {{$i->Text}} : {{$i->notrans}} </a></li>
        @endforeach
    </ul>
</div>

<script>
    if(parseInt('{{count($notif["invoiceReject"])}}') > 0){
        loadbilling()
    }
    function showpengumuman(userid,pengumumanid,index) {
        UIkit.switcher('.uk-switcher').show(index);

        if (activeItem) {
            activeItem.classList.remove("active");
        }
        activeItem = menuItems[index] //untuk set aktiv variable global navbar Mobile (activeItem harus diperbarui valuenya)
        activeItem.classList.add("active")
        offsetMenuBorder(activeItem, menuBorder);
        // $('.navbarCustomIcon').css('background-color', 'rgb(180, 174, 174)');
        // $('.uk-subnav > li:eq('+index+') .navbarCustomIcon').css('background-color', 'aliceblue');

        if(index == 0){
            var targetDiv = $('#pengumumanCompany' + pengumumanid);
        }else{
            var targetDiv = $('#pengumumanForum' + pengumumanid);
        }
        var posisiLayar = window.scrollY || window.pageYOffset;
        var originalBackgroundColor = targetDiv.css('background-color');
        setTimeout(() => {
            $('html, body').stop().animate({
                    scrollTop: targetDiv.offset().top - 150
            }, 50 );
            window.scrollBy(0, 500)
            targetDiv.css('background-color', 'whitesmoke');
            setTimeout(() => {
                targetDiv.css('background-color', originalBackgroundColor);
            }, 2000);       
        }, 500);
        $.ajax({
            url: '{{url("/readpengumuman")}}',
            type: 'GET',
            cache: false,
            data: {userid,pengumumanid}
        });
    }



</script>