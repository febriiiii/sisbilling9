<div id="contentchatheader" class="container">
    <div class="row p-1">
        <div class="col me-2" id="searchBox"></div>
        <button onclick="createChatHeader()" class="col-auto btn btn-secondary">Chat</button>
    </div>
    <?php $__currentLoopData = $tblchat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="mt-2" onclick="opnchat(<?php echo e($c->chatid); ?>)" style="border-radius:5px; height: 70px; overflow:hidden; cursor: pointer; background-color: rgb(239, 239, 239)">
            <div class="row">
                <div class="col-auto" style="margin:0; padding:15px;">
                    <img src="<?php echo e(asset('public/storage/'.$c->profileImg)); ?>" width="40" height="40" style="border-radius:100%;">
                </div>
                <div class="col-9">
                    <div class="d-flex">
                        <small class="normal col-auto"><?php echo e($c->nama); ?></small>
                        <small class="col" style="text-align: end;"><?php echo e(Carbon\Carbon::parse($c->InsertDT)->format('H:i d-M-Y')); ?></small>
                    </div>
                    <hr class="normal">
                    <?php
                        $lastC = ($c->latestChat == "!@##@!IMG!@##@!")?"Mengirim Gambar":$c->latestChat;
                    ?>
                    <p><?php echo $lastC; ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<script>
    function createChatHeader(){
        userid = $('#searchBox').dxSelectBox('option', 'value');
        if(userid == null){
            new Noty({
                  text: "Tolong Pilih User",
                  timeout: 2000 
              }).show();
            return false
        }
        $.ajax({
          type: 'GET',
          cache: false,
          url: '<?php echo e(url("/getchatLawan")); ?>',
          data:{userid},
          success: function(chatid) {
            opnchat(chatid)
          },
          error: function(xhr, status, error) {
              new Noty({
                  text: error,
                  timeout: 10000 
              }).show();
          }
      });
    }
    $(() => {
        const searchBox = $('#searchBox').dxSelectBox({
            dataSource: {
                store: {
                    type: 'odata',
                    url: "<?php echo e(url('')); ?>/chatHeader?stamp=" + new Date().getTime(),
                    key: 'userid',
                },
            },
            displayExpr: 'nama',
            inputAttr: { 'aria-label': 'Product' },
            valueExpr: 'userid',
            searchEnabled: true,
        }).dxSelectBox('instance');
    })
</script><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/getView/viewHeaderchat.blade.php ENDPATH**/ ?>