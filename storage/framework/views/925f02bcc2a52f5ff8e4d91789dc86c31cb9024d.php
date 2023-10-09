<form id="formctu" action="<?php echo e(url('/companytouser')); ?>" target="contentsuksesctu">
        <div class="mb-3">
            <div class="input-group mb-3">
                <input disabled id="myprofile_companyaddEName"
                    type="text"
                    class="form-control"
                    placeholder="Pilih Pengelola"
                    aria-label="Pilih Pengelola"
                    aria-describedby="basic-addon2"
                />
                <button type="button" class="btn btn-info" onclick="selectComp('myprofile_companyaddE','myprofile_companyaddEName')">search</button>
            </div>
            <input type="hidden" id="myprofile_companyaddE" class="form-control" name="companyemail" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="myprofile_companyaddE">My ID</label>
            <input type="text" class="form-control" name="tokenid" value="<?php echo e(session('UIDGlob')->tokenid); ?>" readonly />
        </div>
        <center>
            <?php echo QrCode::size(150)->generate(url('/companytouser?tokenid=').session('UIDGlob')->tokenid); ?>

        </center>
        
        <button type="submit" class="btn btn-primary">Simpan</button>
    <iframe class="col-12" name="contentsuksesctu" style="height: 25vh;"></iframe>
</form>
<script>
    function selectComp(id,name){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '<?php echo e(url("/selectComp")); ?>',
            data: {id,name},
            success: function(data) {
                openmodalSelect('Pilih Pengelola',data)
            },
            error: function(xhr, status, error) {
                new Noty({
                    text: error,
                    timeout: 10000 
                }).show();
            }
        });
    }
</script><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/getView/viewFormaddpengelola.blade.php ENDPATH**/ ?>