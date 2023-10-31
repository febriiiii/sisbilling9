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
        {{-- MASTER INCLUDE --}}
        @include('modal.mainModal')
        @include('modal.mainModal2')
        @include('modal.mainModalSelect') 

        
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg">
                <!-- Container wrapper -->
                <div class="container-fluid">
                <!-- Toggle button -->
                <button
                    class="navbar-toggler"
                    type="button"
                    data-mdb-toggle="collapse"
                    data-mdb-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Navbar brand -->
                    <a class="navbar-brand mt-2 mt-lg-0" href="#">
                    <img
                        src="{{asset('public/icon.png')}}"
                        alt="SissBilling"
                        loading="lazy"
                        style="height: 30px;"
                    />
                    </a>
                    <!-- Left links -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link navAdministrator" id="adminlistpengelola" href="#" onclick="CallAdminPage('adminlistpengelola')" style="color: blue">List Pengelola</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navAdministrator" id="admintagihan" href="#" onclick="CallAdminPage('admintagihan')">Tagihan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navAdministrator" id="adminpembayaran" href="#" onclick="CallAdminPage('adminpembayaran')">Pembayaran</a>
                    </li>
                    </ul>
                    <!-- Left links -->
                </div>
                <!-- Collapsible wrapper -->

                <!-- Right elements -->
                <div class="d-flex align-items-center">
                    <a type="button" class="btn-close" href="{{url('/')}}"></a>
                </div>
                <!-- Right elements -->
                </div>
                <!-- Container wrapper -->
            </nav>
            <!-- Navbar -->
            <div class="mt-2 p-2" id="contentAdminRplc">
                
            </div>

            <script>
                CallAdminPage('adminlistpengelola')
                function CallAdminPage(link){
                    $('.navAdministrator').css('color','rgb(100, 100, 100)');
                    $('.navAdministrator').css('font-weight','normal');
                    $(`#${link}`).css('color','blue');
                    $(`#${link}`).css('font-weight','bold');
                    $.ajax({
                        type: 'GET',
                        cache: false,
                        url: '{{url("")}}/' + link,
                        success: function(data) {
                            $('#contentAdminRplc').html(data)
                        }
                    });
                }
            </script>

        @include('layout.footer')
        @include('layout.footerlink')
    </body>
</html>





    