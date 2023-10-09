<style>
    .navbarCustom{
        /* From https://css.glass */
        background: rgb(77,103,170);
        border-radius: 16px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(4.6px);
        -webkit-backdrop-filter: blur(4.6px);
        border: 1px solid rgba(140, 151, 221, 0.08);
        padding: 0px 0px 0 0px;
        opacity: 0.8;
    }
    .navbarCustomIcon{
        background-color: rgb(180, 174, 174);
        padding: 5px;
        border-radius: 15px;
        width:40px;
        cursor: pointer;
    }
    .textnavbarcustom{
        display: none;
        margin-top:-7px;
        font-size: 12px;
        font-weight: bold;
        color: white;
    }
</style>

<div style="position: fixed; margin:0px; bottom: 2vh; width: 100%;" class="row justify-content-center navbar">
    <div class="col-auto navbarCustom">
        <ul style="margin:0; padding:0;" class="uk-subnav uk-subnav-pill" uk-switcher="animation: uk-animation-scale-up, uk-animation-fade; connect: .switcher-navbarCustom ">
            <li style="margin: 0; padding:0">
                <center class="btn" style="box-shadow:none;">
                    <div title="Sis Billing" class="navbarCustomIcon" style="background-color: aliceblue;">
                        <img src="{{asset('public/app.png')}}">
                    </div>
                </center>
                <div class="text-center textnavbarcustom">M-Billing</div>
            </li>
            @if (session('UIDGlob')->companyid != '')
            <li style="margin: 0; padding:0">
                <center class="btn" style="box-shadow:none;">
                    <div title="Customer" class="navbarCustomIcon">
                        <img src="{{asset('public/customer.png')}}">
                    </div>
                </center>
                <div class="text-center textnavbarcustom">My Customer</div>
            </li>
            @endif
            <li style="margin: 0; padding:0">
                <center class="btn" style="box-shadow:none;">
                    <div title="My Billing" class="navbarCustomIcon">
                        <img src="{{asset('public/bill.png')}}">
                    </div>
                </center>
                <div class="text-center textnavbarcustom">My Billing</div>
            </li>
            <li style="margin: 0; padding:0">
                <center class="btn" style="box-shadow:none;">
                    <div title="Forum" class="navbarCustomIcon">
                        <img src="{{asset('public/discussion.png')}}">
                    </div>
                </center>
                <div class="text-center textnavbarcustom">My Forum</div>
            </li>
            <li style="margin: 0; padding:0">
                <center class="btn" style="box-shadow:none;">
                    <div title="Profile" class="navbarCustomIcon">
                        <img src="{{asset('public/user.png')}}">
                    </div>
                </center>
                <div class="text-center textnavbarcustom">Profile</div>
            </li>
        </ul>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.switcher-navbarCustom').on('shown.uk.switcher', function() {
            var activeIndex = $(this).find('.uk-active').index();
            $('.navbarCustomIcon').css('background-color', 'rgb(180, 174, 174)');
            $('.uk-subnav > li:eq(' + activeIndex + ') .navbarCustomIcon').css('background-color', 'aliceblue');
            var title = $('.uk-subnav > li:eq(' + activeIndex + ') .navbarCustomIcon').attr('title')
            if(title == 'My Billing'){
                loadbilling()
            }else if(title == "Customer"){
                tblcustomer()
            }else if(title == "Sis Billing"){
                reloadDashboard()
            }
            $('title').text(title);
            $('#title').text(title);
        });
    });


</script>
  


  
