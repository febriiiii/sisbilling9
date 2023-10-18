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
            <h2 class="blueFont text-end">Selamat Datang</h2>
            <h4 class="blueFont text-end">Sis Billing</h4>
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
<img src="{{asset('public/wave.svg')}}" style="bottom:0; position: fixed; z-index:-1">

<script>
    if (caches && caches.keys) {
        caches.keys().then(function(names) {
        names.forEach(function(name) {
            caches.delete(name);
        });
        });
    }

  // Membersihkan localStorage
  localStorage.clear();
</script>
@endsection
    