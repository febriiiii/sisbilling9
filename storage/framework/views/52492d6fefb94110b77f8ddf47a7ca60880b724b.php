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
            <a class="headericonX">
                
                <lord-icon onclick="opnhome()" class="me-2"
                    src="https://cdn.lordicon.com/icxqolmx.json"
                    trigger="click"
                    colors="primary:#ffffff"
                    style="width:30px;height:30px">
                </lord-icon>
                <?php if(session('UIDGlob')->superadmin == 1): ?>
                    <lord-icon data-mdb-toggle="modal" onclick="window.location.href = '<?php echo e(url('/admin')); ?>'">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAADEUlEQVR4nO2ZXYgNYRjHZ9EiRb6yXJy1iXLho1yIZBdbLiiR0ha5lnvLJlnWti0X1jraK7WojZRahHbryOaCrNo7SbIrHxEuSL7WT+96p54e7zlnzpk59kzNv6ameT7e5z8z53n+7xzPS5AgQYJYA1gArLKHOa/wyh3AQqADGOZfjABngBqv3ABMAI4B38iP70ALMNErBwCTgV5HoR+BB8Aje65xw8SWA4HzqrD7QL28w+YcqAMyyrdb+KwBGgMcDUBlVMXvUAWdNK9TDv8KoFnF7LS2RcBPgmEIqI7ivX/iupvWfgB4BbwGDipbl4h76j8t4BbBkQlLwDxyH5+AWcK2zbHgdmGfAbwXtnX2ei3QluPosE3Ax5IwBI6LRF3KdtpBoFP5pIXtRAHrDoi42jAELolEu5Vtn4PAfuVjfow+egpYNyPi6sIQuC0SbVa2SuC6sN/UncN2Kh/940HgqkjUkMVnsXlPXTIC2CXir40HgRaR6FwR8Z0ivnU8CGwUib4AcwqInQ18FvH1BcQO6u4VZg48y9aJ8gwzOb2fizlwCujLcTwUcaNAVdEEHJ0EK+jyTeJ2FTPWwYAU8IvgSIcqXhR1WSW+Z4acw281cFf5XhH27oCFj9oZMjUqAlMcEsDcyQ3CZ71D59wxseLJbLKtNddh8syPpHBFYpLtSj9EgUeF/bC4bnxaTYxXbgAuiEKbxfUjrpYJrAgooRtLIqdV8eYV+C0K3ZqFwBgxYCnwleIwFFpOq+JnAi/FAr3K7iJg3ucwyERJwGzWfbwD5gUgUJNHOreVVE7nUKYjeiq7CIRYayASOa2SptQGpV/tiaMkkIlECzkSb7FDxseeWBEwAC66Co0FAWAa8EYk3xs3Ak0i8bAvE0pAYDASOe1I/FYkPhugjS7LI537Si6nVZHmM6IPM5EPlXiQpSMr3hZUBTxWi5gBtxZ4Ia41OnZ0hWA0UjmtSEy3MyAbzNfr5dZ3bgD5XP9f5LTjk0qPo/gPZlZ4cQB/98vtYrCZ8Z/y4gagGlgZi7+XEiRIkMCLEn8AhcqGdgEc/9oAAAAASUVORK5CYII=">                
                    </lord-icon>
                <?php endif; ?>
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