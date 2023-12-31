<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="apple-touch-startup-image" href="{{asset('public/icon.png')}}">
        <link rel="icon" href="{{ asset('public/logo.png') }}" type="image/x-icon">

        <title>Sis Billing</title>
        @include('layout.headerlink')
        <style>body{margin:0 !important;padding:0 !important;}</style>
        @php
            $UIDGlob = session('UIDGlob');
        @endphp
        <script>
            const UIDGlob = JSON.parse(`{!! $UIDGlob !!}`);
            if(UIDGlob == null){
                window.location.href = '{{url("/logout")}}';
            }
        </script>
    </head>
    <body style="overflow-y: scroll; height: auto;">
        <header style="position: fixed; top:0;left:0;right:0; z-index:500;">
            @include('layout.header')
        </header>
        {{-- MASTER INCLUDE --}}
        @include('modal.mainModal')
        @include('modal.mainModal2')
        @include('modal.mainModalSelect') 
        @if ($UIDGlob->companyid != '' && session('UIDGlob')->scrb < 1)
            @if (session('UIDGlob')->superadmin != 1)
                <div class="uk-alert-danger" uk-alert style="position: fixed; top:50px; right:5px;vw;z-index:99999">
                    <a href class="uk-alert-close" uk-close></a>
                    <p>Akun Anda Telah Habis Masa Aktif, Tolong Lakukan Pembayaran</p>
                    <p>Jika Butuh Bantuan Hubungi Suport Center.</p>
                </div>
            @endif
        @endif
        {{-- HATI HATI MENGINCLUDE FILE, TES SUBMIT FORM APAKAH BEKERJA, CONTOH FORM PADA PENGATURAN->PERUSAHAAN --}}
        <div class="body" style="padding-bottom:20vh; padding-top:30px;">
            <div class="container">
                @include('loader')
                <ul class="uk-switcher switcher-navbarCustom uk-margin">
                    <li>@include('tabs.mydashboard')</li>
                    @if (($UIDGlob->companyid != '' && session('UIDGlob')->scrb > 0) || session('UIDGlob')->superadmin == 1)
                    <li>@include('tabs.mycustomer')</li>
                    @endif
                    <li>@include('tabs.mybilling')</li>
                    <li>@include('tabs.myforum')</li>
                    <li>@include('tabs.myprofile')</li>
                </ul>
            </div>
        </div>
        {{-- TUTOR --}}
        @if ($UIDGlob->isTutor == 1)
            @include('tutor')
        @endif
        
        @include('layout.navbarMobile')
        @include('layout.footer')
        @include('layout.footerlink')
    </body>
    {{-- <script>
        if('{{session("track")}}' == 'mybilling'){
            UIkit.switcher('.uk-switcher').show(1)
            if (activeItem) {
                activeItem.classList.remove("active");
            }
            activeItem = menuItems[1] //untuk set aktiv variable global navbar Mobile (activeItem harus diperbarui valuenya)
            activeItem.classList.add("active")
            offsetMenuBorder(activeItem, menuBorder);
            loadbilling()
            $.ajax({
                url: '{{ url("/track") }}',
                method: 'GET',
                cache: false,
            });

        }
    </script> --}}
</html>
