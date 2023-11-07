
<div id="carouselExampleCaptions" class="carousel slide" data-mdb-ride="carousel">
    <div class="carousel-indicators">
        @php
            $i = 0;
        @endphp
        @foreach ($paket as $pkt)
        <button
            type="button"
            data-mdb-target="#carouselExampleCaptions"
            data-mdb-slide-to="{{ $i }}"
            class="{{ $i === 0 ? 'active' : '' }}"
            active aria-current="{{ $i === 0 ? 'true' : '' }}"
            aria-label="Slide {{ $i + 1 }}"
        ></button>
        @php
            $i++;
        @endphp
        @endforeach
    </div>
    <div class="carousel-inner">
        @php
            $i = 0;
        @endphp
        @foreach ($paket as $pkt)
        @php
            $i++;
            $warna = "rgb(255, 83, 83)";
            if($i % 2 == 0){
                $warna = "rgb(232, 62, 62)";
            }
            $active = "";
            if($i == 1){
                $active = "active";
            }
        @endphp
        <div class="carousel-item {{$active}} iklan">
            <div style="background-color: {{$warna}}; height:300px; width:100%; display: flex; justify-content: center; align-items: center; border-radius: 10px; ocerflow:hidden;">
                <div style="text-align: center;margin-top:-100px;">
                    <p class="mobile-font" style="margin: 0;color:white">Hemat Hingga {{$pkt->disc}}%<span style="font-size: .3em;">({{$pkt->rangeDuration}} {{$pkt->duration}})</span></p>
                </div>
            </div>        
            <div class="carousel-caption d-md-block" style="color: white;">
                <div>
                    <span style="display: inline-block;">{{$pkt->kataPromo}}</span>
                    <button class="btn btn-light mobile-font2" style="padding: 1px 10px 1px 10px; margin:0 0 2.5px 0;" onclick="subscrb('{{$pkt->productCode}}|{{$pkt->rangeDuration}} {{$pkt->duration}}')">Berlanganan {{$pkt->rangeDuration}} {{$pkt->duration}}</button>
                </div>            
            </div>
        </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-mdb-target="#carouselExampleCaptions" data-mdb-slide="prev">
        <i style="font-size: 3em;" class="las la-angle-left"></i>
    </button>
    <button class="carousel-control-next" type="button" data-mdb-target="#carouselExampleCaptions" data-mdb-slide="next">
        <i style="font-size: 3em;" class="las la-angle-right"></i>
    </button>
  </div>
<style>
    .mobile-font {
        font-size: 4em;
    }
    /* Mengubah ukuran font untuk layar dengan lebar kurang dari 768px (mode mobile) */
    @media screen and (max-width: 768px) {
        .mobile-font {
            font-size: 2em;
        }
    }
</style>
<script>
    function subscrb(produk){
        var productCode = produk.split('|')[0]
        var produkName = produk.split('|')[1]
        Swal.fire({
        title: "Berlanganan",
        text: produkName,
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak',
      }).then((result) => {
        if(result.isConfirmed){
            $('#loader').show('slow')
            $.ajax({
                type: 'POST',
                cache: false,
                url: '{{url("/subscribeIklan")}}',
                data: {productCode},
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                success: function(data) {
                    if(data == 'view'){
                        window.location.href = '{{url("/success")}}'
                    }else{
                        showNty(data)
                        $('#loader').hide('slow')
                    }
                },
                error: function(xhr, status, error) {
                    showNty(error,10000)
                    $('#loader').hide('slow')
                }
            });
        }
      })
    }
</script>