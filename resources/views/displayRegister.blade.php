@extends('layout.blank')
@section('content')
<button onclick="window.history.back()" class="btn btn-primary m-3" style="padding:5px 10px 5px 5px; border-radius:100%;"><i class="las la-backspace" style="font-size: 40px;"></i></button>
    <div class="container" style="padding-bottom: 15vh;"> 
        <form class="container" style="margin-top:8vh; z-index:3;" method="POST" action="{{url('register')}}">
            @csrf
            <center>
                <div style="max-width: 500px">
                    <h3>Pengguna Baru</h3>
                    <div class="form-outline mt-4">
                        <input value="{{ old('nama') }}" name="nama" type="text" id="displayRegister_Nama" class="form-control @error('nama') is-invalid @enderror" required />
                        <label class="form-label" for="displayRegister_Nama">Nama</label>
                        @error('nama')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-outline mt-3">
                        <input value="{{ old('email') }}" name="email" type="email" id="displayRegister_email" class="form-control @error('email') is-invalid @enderror" required/>
                        <label class="form-label" for="displayRegister_email">Email</label>
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row" style="margin:0;">
                        <div class="form-outline col mt-3">
                            <input name="password" type="password" id="displayRegister_password" class="form-control @error('password') is-invalid @enderror" required/>
                            <label class="form-label" for="displayRegister_password">Password</label>
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-1"></div>
                        <div class="form-outline col mt-3">
                            <input name="password2" type="password" id="displayRegister_password2" class="form-control @error('password2') is-invalid @enderror" required/>
                            <label class="form-label" for="displayRegister_password2">Confirm Password</label>
                            @error('password2')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-outline mt-3">
                        <input value="{{ old('hp') }}" name="hp" type="tel" id="displayRegister_HP" class="form-control @error('hp') is-invalid @enderror" required/>
                        <label class="form-label" for="displayRegister_HP">HP</label>
                        @error('hp')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-outline mt-3">
                        <input value="{{ old('alamatSingkat') }}" name="alamatSingkat" type="text" id="displayRegister_AlamatSingkat" class="form-control @error('alamatSingkat') is-invalid @enderror" required/>
                        <label class="form-label" for="displayRegister_AlamatSingkat">Alamat Singkat</label>
                        @error('alamatSingkat')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-outline mt-3">
                        <textarea name="alamatLengkap" id="displayRegister_AlamatLengkap" class="form-control @error('alamatLengkap') is-invalid @enderror" required>{{ old('alamatLengkap') }}</textarea>
                        <label class="form-label" for="displayRegister_AlamatLengkap">Alamat Lengkap</label>
                        @error('alamatLengkap')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-outline mt-3">
                        <textarea name="InfoTambahan" type="text" id="displayRegister_InfoTambahan" class="form-control @error('InfoTambahan') is-invalid @enderror" value="-"/>{{ old('InfoTambahan') }}</textarea>
                        <label class="form-label" for="displayRegister_InfoTambahan">Info Tambahan</label>
                        @error('InfoTambahan')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary col-12 mt-3" style="z-index: 3;">Daftar</button>
                </div>
            </center>
        </form>
    </div>
    <img src="{{asset('public/wave.svg')}}" style="bottom:0; position: fixed; z-index:-1;">
<script>
    $(document).ready(function() {
        $('body').css('background-color','transparent')
    });
</script>
@endsection
