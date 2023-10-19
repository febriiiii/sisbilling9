<form id="formctu" action="{{ url('/companytouser') }}" target="contentsuksesctu">
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
            <input type="text" class="form-control" name="tokenid" value="{{ session('UIDGlob')->tokenid }}" readonly />
        </div>
        <center>
            {!! QrCode::size(150)->generate(url('/companytouser?tokenid=').session('UIDGlob')->tokenid) !!}
        </center>
        {{-- <video id="video" width="300" height="200" autoplay></video> --}}
        <button type="submit" class="btn btn-primary">Simpan</button>
    <iframe class="col-12" name="contentsuksesctu" style="height: 25vh;"></iframe>
</form>
<script>
    function selectComp(id,name){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '{{url("/selectComp")}}',
            data: {id,name},
            success: function(data) {
                openmodalSelect('Pilih Pengelola',data)
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
</script>