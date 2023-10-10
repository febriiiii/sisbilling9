<form action="<?php echo e(url('/usertocomp')); ?>" target="contentsuksesutc">
    <div class="mb-3">
        <label class="form-label" for="myprofile_customeraddE">Email Customer</label>
        <input type="email" id="myprofile_customeraddE" class="form-control" name="email" required autocomplete="off"/>
    </div>
    <div class="mb-3">
        <label class="form-label" for="myprofile_customeraddE">My ID</label>
        <input type="text" class="form-control" name="tokenid" value="<?php echo e(session('UIDGlob')->tokenid); ?>" readonly />
    </div>
    <center>
        <?php echo QrCode::size(150)->generate(url('/companytouser?tokenid=').session('UIDGlob')->tokenid); ?>

    </center>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <iframe name="contentsuksesutc" class="col-12" style="height: 25vh;"></iframe>
</form><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/getView/viewFormaddcustomer.blade.php ENDPATH**/ ?>