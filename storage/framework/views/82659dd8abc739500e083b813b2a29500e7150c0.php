
  <!-- Fullscreen Modal -->
  <div class="modal fade" id="displayAdministrator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content" id="AdminContent">
        
      </div>
    </div>
  </div>

  <script>
    $('#displayAdministrator').on('shown.bs.modal', function () {
        if ($('#displayAdministrator').hasClass('show')) {
            $.ajax({
                type: 'GET',
                cache: false,
                url: '<?php echo e(url("/adminindex")); ?>',
                success: function(data) {
                    $('#AdminContent').html(data)
                }
            });
        }
    });
  </script><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/admin/administrator.blade.php ENDPATH**/ ?>