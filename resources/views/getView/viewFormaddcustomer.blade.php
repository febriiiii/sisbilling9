<form action="{{ url('/usertocomp') }}" target="contentsuksesutc">
    <div class="mb-3">
        <label class="form-label" for="myprofile_customeraddE">Email Customer</label>
        <input type="email" id="myprofile_customeraddE" class="form-control" name="email" required autocomplete="off"/>
    </div>
    <div class="mb-3">
        <label class="form-label" for="myprofile_customeraddE">My ID</label>
        <input type="text" class="form-control" name="tokenid" value="{{ session('UIDGlob')->tokenid }}" readonly />
    </div>
    <center>
        {!! QrCode::size(150)->generate(url('/companytouser?tokenid=').session('UIDGlob')->tokenid) !!}
    </center>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <iframe name="contentsuksesutc" class="col-12" style="height: 25vh;"></iframe>
</form>