<style>
    .headericon{
        background-color: white;
        border-radius: 7px;
        padding:3px;
        opacity: 0.8px;
    }
</style>
<header>
    <nav class="navbar navbar-expand-lg blueBack" style="padding: 10px 0 0 0;">
      <div class="container-fluid row">
        <div class="col-4" style="display: flex; flex-direction: column; align-items: start;">
            <a class="headericonX" onclick="opnhome()">
                
                <lord-icon
                    src="https://cdn.lordicon.com/icxqolmx.json"
                    trigger="click"
                    colors="primary:#ffffff"
                    style="width:30px;height:30px">
                </lord-icon>
            </a>
        </div>
        <div class="col-4">
            <center>
                <a id="title" class="whiteFont" href="#" style="font-weight: bold; font-size:1.1em">Sis Billing</a>
            </center>
        </div>
        <div class="col-4">
            <div style="display: flex; justify-content: flex-end; margin-right:-30px;">
                <div id="contentlonceng">
                    
                </div>
                <a href="<?php echo e(url('/logout')); ?>" class="ms-3 headericonX">
                    
                    <lord-icon
                        src="https://cdn.lordicon.com/nhfyhmlt.json"
                        trigger="click"
                        colors="primary:#ffffff"
                        style="width:30px;height:30px">
                    </lord-icon>
                </a>
            </div>
        </div>
      </div>
    </nav>
  </header>

  <script>
    renderlonceng()
    function renderlonceng(){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '<?php echo e(url("/viewlonceng")); ?>',
            success: function(data) {
                $('#contentlonceng').html(data)
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
    function opnhome(){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '<?php echo e(url("/viewhome")); ?>',
            success: function(data) {
                openmodal("Report",data)
                $('#contentbill1').hide()
                $('#contentbill1').slideDown('slow')
                querysaled()
                querysaledBil()
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
  </script>
  <?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/layout/header.blade.php ENDPATH**/ ?>