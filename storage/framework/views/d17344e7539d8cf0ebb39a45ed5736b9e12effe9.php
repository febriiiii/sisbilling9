
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
<!-- Google Fonts -->
<link href="<?php echo e(asset('public/mdb/font.google.css')); ?>" rel="stylesheet" />
<!-- MDB -->
<link href="<?php echo e(asset('public/mdb/mdb.min.css')); ?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo e(asset('public/mdb/mdb.min.js')); ?>" ></script>

<link rel="stylesheet" href="<?php echo e(asset('public/css/main.css')); ?>">

<script src="https://cdn.lordicon.com/bhenfmcm.js"></script>


<script>
  const asset = '<?php echo e(asset('')); ?>'
  const CID = '<?php echo e(isset($cid)?$cid:null); ?>'
  const csrf_token = '<?php echo e(csrf_token()); ?>'
  const firebaseSwJs = '<?php echo e(url("/public/firebase-messaging-sw.js")); ?>'
  const PUSHER_APP_KEY = '<?php echo e(config("app.PUSHER_APP_KEY")); ?>'
  const PUSHER_APP_CLUSTER = '<?php echo e(config("app.PUSHER_APP_CLUSTER")); ?>'
  const URLchatimg = '<?php echo e(asset("/public/storage/chatimg")); ?>'
  const URLviewpayment = '<?php echo e(url("/viewpayment")); ?>'
  const URLreadchat = '<?php echo e(url("/readchat")); ?>'
  const URLupdateDevice = '<?php echo e(route("updateDevice")); ?>'
  const URLserviceworker = '<?php echo e(url("/service-worker.js")); ?>'
  const URLsse = '<?php echo e(url("/paymentWebHook")); ?>'
  const URLconfirmPembayaranMID = '<?php echo e(url("/confirmPembayaranMID")); ?>'
  const URLlogout = '<?php echo e(url("/logout")); ?>'
</script>
<script type="text/javascript" src="<?php echo e(asset('public/js/footerscript.js')); ?>" ></script>
<script type="module" src="<?php echo e(asset('public/js/module.js')); ?>" ></script>
<?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/layout/footerlink.blade.php ENDPATH**/ ?>