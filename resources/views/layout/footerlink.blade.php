{{-- MDB --}}
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
<!-- Google Fonts -->
<link href="{{asset('public/mdb/font.google.css')}}" rel="stylesheet" />
<!-- MDB -->
<link href="{{asset('public/mdb/mdb.min.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('public/mdb/mdb.min.js')}}" ></script>
{{-- css main --}}
<link rel="stylesheet" href="{{asset('public/css/main.css')}}">
{{-- lordicon --}}
<script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
{{-- SETUP --}}

<script>
  const asset = '{{asset('')}}'
  const CID = '{{isset($cid)?$cid:null}}'
  const csrf_token = '{{ csrf_token() }}'
  const firebaseSwJs = '{{url("/public/firebase-messaging-sw.js")}}'
  const PUSHER_APP_KEY = '{{config("app.PUSHER_APP_KEY")}}'
  const PUSHER_APP_CLUSTER = '{{config("app.PUSHER_APP_CLUSTER")}}'
  const URLchatimg = '{{asset("/public/storage/chatimg")}}'
  const URLviewpayment = '{{url("/viewpayment")}}'
  const URLreadchat = '{{url("/readchat")}}'
  const URLupdateDevice = '{{ route("updateDevice") }}'
  const URLserviceworker = '{{url("/service-worker.js")}}'
</script>
<script type="text/javascript" src="{{asset('public/js/footerscript.js')}}" ></script>
<script type="module" src="{{asset('public/js/module.js')}}" ></script>
