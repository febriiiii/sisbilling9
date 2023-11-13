@extends('layout.blank')
@section('content')
<style>
    input,select{
    border:none;
    color: rgb(88, 137, 204);
    }

    .input{
    color: rgb(117, 115, 115);
    border-bottom: .5px solid rgb(215, 226, 243);
    margin-left: 0px;
    margin-bottom: 0px;
    max-width: 100%;
    }

    .validate{
    color: red;
    font-size: 12px;
    }
    input:focus, select:focus{
    color: rgb(88, 137, 204);
    border:none;
    outline: none;
    /* border-bottom: 1px solid rgb(173, 162, 162); */
    }
</style>
<div class="container">
    <div class="container row" style="margin-top:20vh;">
        <div class="col-lg-4 col-1"></div>
        <div class="col">
            <center>
                <img src="{{asset('/public/Sisbilling_final.png')}}" style="height:90px;">
            </center>
            {{-- <center>
                <img src="{{asset('/public/logo.png')}}" style="position: absolute; z-index:-1; margin-top:-200px;">
                <img src="{{asset('/public/logoText.png')}}" style="height:70px; margin-left:70px; margin-top:20px;">
            </center> --}}

            {{-- <img src="{{asset('/public/logo.png')}}" style="position: absolute; z-index:-1; margin-top:-180px; margin-left:70px;">
            <h2 class="blueFont text-end">Selamat Datang</h2>
            <img src="{{asset('/public/logoText.png')}}" style="float: right; height:55px;"> --}}

            {{-- <img src="{{asset('/public/Sisbilling_final.png')}}" style="float: right; height:70px;"> --}}
        </div>
        <div class="col-lg-4 col-1"></div>
    </div>
    <div class="container row" style="margin-top:5vh;">
        <div class="col-lg-4"></div>
        <form style="padding:0;" class="col" method="POST" action="{{url('/auuten')}}">
            @csrf
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="row mt-3">
                <label for="displayLogin-email" class="col-xl-4 col-lg-4 col-md-3 col-sm-3 col-3">Email</label>
                <label for="displayLogin-email" class="col-auto" style="padding-right:0;">:</label>
                <input id="displayLogin-email" name="email" type="email" class="d-flex col form input" >
            </div>
            <div class="row mt-3">
                <label for="displayLogin-password" class="col-xl-4 col-lg-4 col-md-3 col-sm-3 col-3">Password</label>
                <label for="displayLogin-password" class="col-auto" style="padding-right:0;">:</label>
                <input id="displayLogin-password" name="password" type="password" class="input d-flex col form" >
            </div>
            <div class="row mt-3">
                <div class="col-1"></div>
                <button class="col-10 btn btn-primary">Login</button>
                <div class="col-1"></div>
            </div>
            <div class="row mt-2">
                <div class="col-6 blueFont">
                    <a href="{{url('/forgot')}}">lupa Password?</a>
                </div>
                <div class="col-6 blueFont text-end">
                    <a href="{{url('/registerView')}}">Pengguna Baru</a>
                </div>
            </div>
        </form>
        <div class="col-lg-4"></div>
    </div>
</div>
{{-- <img src="{{asset('public/wave.svg')}}" style="bottom:0; position: fixed; z-index:-1"> --}}
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" style="bottom:0; position: fixed; z-index:-1">
    <path fill="#0099ff" fill-opacity="1" d="M0,288L1440,64L1440,320L0,320Z"></path>
</svg>

<script>
    // if (caches && caches.keys) {
    //     caches.keys().then(function(names) {
    //     names.forEach(function(name) {
    //         caches.delete(name);
    //     });
    //     });
    // }

  // Membersihkan localStorage
  localStorage.clear();
</script>
@endsection
    