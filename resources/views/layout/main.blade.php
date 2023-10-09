<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{asset('public/icon.png')}}">
        <link rel="apple-touch-startup-image" href="{{asset('public/icon.png')}}">

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
        
        {{-- TUTOR --}}
        @if ($UIDGlob->isTutor == 1)
            @include('tutor')
        @endif

        <div class="body" style="padding-bottom:20vh; padding-top:30px;">
            <div class="container">
                @include('loader')
                
                <ul class="uk-switcher switcher-navbarCustom uk-margin">
                    <li>@include('tabs.mydashboard')</li>
                    @if ($UIDGlob->companyid != '')
                    <li>@include('tabs.mycustomer')</li>
                    @endif
                    <li>@include('tabs.mybilling')</li>
                    <li>@include('tabs.myforum')</li>
                    <li>@include('tabs.myprofile')</li>
                </ul>
            </div>
        </div>
        {{-- <script>
                const mobileMediaQuery = window.matchMedia("(max-width: 767px)");
                var name = "navbarMobile"
                if (mobileMediaQuery.matches) {
                    name = "navbarMobile"
                }
                $.ajax({
                    type: 'GET',
                    url: '{{url("/Getnavbar")}}',
                    data:{name},
                    success: function(data) {
                        $('#navbarSwitches').html(data)
                    },
                    error: function(xhr, status, error) {
                        new Noty({
                            text: "Navigation Error",
                            timeout: 10000 
                        }).show();
                    }
                });
        </script>
        <div id="navbarSwitches">
            
        </div> --}}

        {{-- @include('layout.navbar') --}}
        
        @include('layout.navbarMobile')
        @include('layout.footer')
        @include('layout.footerlink')
    </body>
</html>
