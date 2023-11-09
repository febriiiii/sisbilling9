<div class="container" style="padding-bottom: 20vh">
    <center>
        <style>
            .avatar-upload {
                position: relative;
                max-width: 205px;
                margin: 50px auto;
            }
            .avatar-edit {
                position: absolute;
                right: 50px;
                z-index: 1;
                top: 0px;
                
            }
            .avatar-edit input {
                display: none;
                + label {
                    display: inline-block;
                    width: 34px;
                    height: 34px;
                    margin-bottom: 0;
                    border-radius: 100%;
                    background: #FFFFFF;
                    border: 1px solid transparent;
                    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
                    cursor: pointer;
                    font-weight: normal;
                    transition: all .2s ease-in-out;
                    &:hover {
                        background: #f1f1f1;
                        border-color: #d6d6d6;
                    }
                    &:after {
                        /* content: "\f040";
                        font-family: 'FontAwesome'; */
                        color: #757575;
                        position: absolute;
                        top: 5px;
                        left: 0;
                        right: 0;
                        text-align: center;
                        margin: auto;
                    }
                }
            }
            .avatar-preview {
                width: 100px;
                height: 100px;
                position: relative;
                border-radius: 100%;
                border: 6px solid #F8F8F8;
                box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
                background-color: #ccc4c4;
            }
            .avatar-preview > div {
                width: 100%;
                height: 100%;
                border-radius: 100%;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
            }
        </style>
        <div class="uploadimg">
            <form class="avatar-upload" id="myprofile-formimg">
                <div class="avatar-edit">
                    <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                    <label for="imageUpload"><i class="las la-pencil-alt" style="font-size: 1.2em;margin-top:5px;"></i></label>
                </div>
                <div class="avatar-preview">
                    <div id="imagePreview" style="background-image: url({{asset('public/storage/'.session('UIDGlob')->profileImg)}});">
                    </div>
                </div>
                <button class="btn btn-primary mt-2" style="display: none;" type="submit" id="myprofile-saveimage">Simpan Perubahan</button>
            </form>
        </div>
        <form style="max-width: 500px" id="myprofile-formprofile">
            <div class="form-outline">
                <input type="text" id="myprofile_nama" class="form-control" value="{{session('UIDGlob')->nama}}" required/>
                <label class="form-label" for="myprofile_nama">Nama</label>
            </div>
            <div class="form-outline mt-3">
                <input type="text" id="myprofile_Email" class="form-control" value="{{session('UIDGlob')->email}}" required/>
                <label class="form-label" for="myprofile_Email">Email</label>
            </div>
            <div class="form-outline mt-3">
                <input type="number" id="myprofile_hp" class="form-control" value="{{session('UIDGlob')->hp}}" required/>
                <label class="form-label" for="myprofile_hp">HP</label>
            </div>
            <div class="form-outline mt-3">
                <input type="text" id="myprofile_alamatSingkat" class="form-control" value="{{session('UIDGlob')->alamatSingkat}}" required/>
                <label class="form-label" for="myprofile_alamatSingkat">Alamat Singkat</label>
            </div>
            <div class="form-outline mt-3">
                <textarea type="text" id="myprofile_alamatLengkap" class="form-control" required>{{session('UIDGlob')->alamatLengkap}}</textarea>
                <label class="form-label" for="myprofile_alamatLengkap">Alamat Lengkap</label>
            </div>
            <div class="form-outline mt-3">
                <input type="text" id="myprofile_infoTambahan" class="form-control" value="{{session('UIDGlob')->infoTambahan}}" required/>
                <label class="form-label" for="myprofile_infoTambahan">Info Tambahan</label>
            </div>
            <button class="btn btn-primary mt-3">Simpan Perubahan</button>
        </form>
        <div style="max-width: 500px">
            <hr>
            <h4>Ubah Password</h4>
            <div id="alertpass" style="display:none;" class="alert alert-danger">Password Tidak Sama</div>
            <div class="form-outline mt-3">
                <input type="password" id="myprofile_Passwordold" class="form-control" />
                <label class="form-label" for="myprofile_Passwordold">old Password</label>
            </div>
            <div class="form-outline mt-3">
                <input type="password" id="myprofile_Password" class="form-control" />
                <label class="form-label" for="myprofile_Password">New Password</label>
            </div>
            <div class="form-outline mt-3">
                <input type="password" id="myprofile_Password2" class="form-control" />
                <label class="form-label" for="myprofile_Password2">Confirm New Password</label>
            </div>
            <button id="myprofile_savepass" type="button" class="btn btn-primary mt-2" style="right:0;" disabled>Konfirmasi Password</button>
        </div>
        <div class="p-2 m-3 ">
            @if (session('UIDGlob')->companyid != '')
                @if ($tblcomp['Server_Key'] == 1)
                    <div class="row card p-2" style="width: fit-content;">
                        <div class="image-grid" style="display: grid; grid-template-columns: 70% 30%; grid-gap: 50px;">
                            <img src="{{ asset('public/midtrans.png') }}" style="height: 40px; width: 100%;">
                            <img style="height: 35px; width:50px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAEaUlEQVR4nO1ZzW9bRRB/7X8AiBbvmohDb5UQnDghUAWUNP1QWxnuSFA+eufAoYhLkeCUponJ231tihpRVC40ggMVFLWqhBDUsR07Tl9b7zoprWigoWm+7HiqWduJX/0cr9d+SZA80kr22m/fb2Z+Mzuza1kd6UhH2iJd/eKJ6u/Uzh0iTEwSLnL4ufo3MjT5lHUMtlqbQbafcbcRLkYpl0C5/DNki9cpExHKRKE8B5SLPGFif8gRByr/JUzE8dmNxm9RJpxVoCuAl2vmmCj6zLF1Bxx25G7C5eeUi/fCtnyTcLlUq4DeIFwuEJ7dG7LlUVwT1wsUPOW5bl9LtmswXDvXvc50afcQPEAF5OXgFZAXg6ANo0z+RJicD1oBwuVCyVCCt0wnDKpAOc8bxwQmDWMFStlmg8DzskeYPG6sAKa3jVaA2uKIsQKUZXvWD+gtINEJoPZN77yT22NaHgyqgAqW40CiLpDeBETOT0Dk2zSQkykvhUob5Sn9suMYbMU6JXBuR13o6ovDxxezkPr7IXzys4BQ3xhQlq0TCyKuVQBipRg0VUInkvDhDzdgcmYRZhYKcPDcOJCBjPLIWs+GbfmklhMIE7FgrH4dXnKScEXOAMrd2SV47euUmteg2zX97OOIA/6LZJUF1WhgrRqun0zDkRFXWRzln7k8vDo0pqiks0ZT+wGxxT6/DYz0j0PPcBp2n03DC3YSQr1xBYwM3qyvECtx+4urk1CR2aUC9AyntMFjeU64eEsLfJjLg9iA1KPAiywBv9y6r4BMz+XhQmYa3h9xoetEvBZQGbz9x50V8EUAeOf763q04Z61CpTlDje2PraADYIQ096nlyQsFRBOSab+W1SBWZ1J0Duf/SqhWnp/u63mjWKIi1zrClQ4PZCB/d+k4d/5vAfgyMQ07OhPKAtHzmdgeVVHiN2ZhWf7Es3FD/e8VzZUAN3k7WfXyiouvHw6CX89WPQo8fvUA3g+GgN3en5lDr2168xY7U7LdYfII7214oA44m3fvraOEq8MJeHenNcTlWxTkS+vTpVyvZnli5hYtMArLzjZXU1xM+rCnuE0LOSXwU9wp8Vd15g6XAKmdn0FmLjWdIANZODojzd8FcBYUKnWEDwtlRIxPfqYlhJqs0rBd6l7HvCXsvdLmakF8LQ8Hj88a38xx7Kw86vESjxgAsKNzzxw5aoHuBi1ALZoeQFLVyxhTc58MH2+e8GFQrEIQ7G7NeWx2dmRGHyG337aalawmTB6af84PNc3umZ53IRXeyxTIVx8YP5i84xDqwa2teYKMHm8HSA2rKkPb4JjlRATb1itSDkOTlEurwTeI3Nl8Xk8RMPDtJbOhHyVwYUDt7q83FbQXgUEWwfaOP/r4/Vwu2lT74KDcPkR5uhWDnyJ2ihz3Xj6hmu2HLAmgrtkLTi/Utz32smxNtMlH1aMeJmH10aevlr1syJSvgBUlS4+s30zXPIpAdjyeKWI3RO2p37XrOq/uoVZRzrSEWsteQSvy7fNY6MAtQAAAABJRU5ErkJggg==">
                        </div>
                    </div>
                @else
                    <div class="row card" style="background-color:#332D2D; width:fit-content">
                        <div class="col p-2" style="color: white;font-size:1.1em;">
                            Midtrans Tidak Digunakan, Hub Suport Center Via 
                            <button onclick="chatCS()" class="btn btn-dark" style="padding:0px;">
                                <img style="height:30px; width:30px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAABOUlEQVR4nO2XQWrDMBBFdYWSiKwME7rwtUqwN71Al+2mJ0ilQ4SCTxCsbnKQ7pvEFnTrMm0KJditiqXgD/NgdkL+bzRgSSlBEITJcm3eMzL+mYxvl9Z3seq0X0W2yZOGXxr/FjN4T+35O0kEuPOJw3/XJpVA1LEZHCfrmyQCF+p+xyUCfcgJWBmhccgI2fAR0qXrqbqdF66arbY5qID7qqLeX928ZLgCJUu4DbhA3WALlO7/f2sRsGHdp/UR+wSyx1dggfWhW9zu8AToqfns/CIwfDQBsu39+brQAGNLjRXoCw8jQAPhIQTol/CTF6A/wk9bwPiHkHWTFQiF7+3QAvPCVdACs9U250cHrADDLyZ+dPC9HVIgJrpwd9ACQxIKDX0moRDRPyQUKvokoZDRZR10KxAEQVAX5wMxV/Fz2PxQkQAAAABJRU5ErkJggg==">
                            </button>
                            <a href="https://api.whatsapp.com/send?phone={{$tblcomp['hp']}}" target="_blank" class="btn btn-dark" style="padding:0px;">
                                <img style="height:30px; width:30px;" src="data:image/png;base64,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">
                            </a>
                        </div>
                    </div>
                @endif
            @endif
        </div>
        <script>
            function chatCS(){
                userid = 1;
                if(userid == null){
                    showNty("Tolong Pilih User")
                    return false
                }
                $.ajax({
                    type: 'GET',
                    cache: false,
                    url: '{{url("/getchatLawan")}}',
                    data:{userid},
                    success: function(chatid) {
                        opnchat(chatid)
                    },
                    error: function(xhr, status, error) {
                        showNty(error,10000)
                    }
                });
            }
        </script>
        {{-- @if (session('UIDGlob')->companyid != 'X') 
        <div style="max-width: 500px">
            <hr>
            <h4>Midtrans (Gateway)</h4>
            <div class="form-outline mt-3">
                <input type="password" id="clientKey" class="form-control seemid" value="{{$tblcomp['Client_Key']}}" readonly/>
                <label class="form-label" for="clientKey">Client Key</label>
            </div>
            <div class="form-outline mt-3">
                <input type="password" id="ServerKey" class="form-control seemid" value="{{$tblcomp['Server_Key']}}" readonly/>
                <label class="form-label" for="ServerKey">Server Key</label>
            </div>
            <div class="form-outline mt-3">
                <input type="password" id="IDMerchat" class="form-control seemid" value="{{$tblcomp['Merchant_ID']}}" readonly/>
                <label class="form-label" for="IDMerchat">Merchant ID</label>
            </div>
            <button onclick="toggleSeeMID()" class="btn btn-info mt-2" id="seemid">Lihat</button> <!-- Tombol untuk mengganti tipe input -->
        </div>
        @endif --}}
    </center>
    <hr>
    <h4>Pengaturan</h4>
    <button class="btn btn-secondary mt-2 me-2" data-mdb-toggle="modal" data-mdb-target="#myprofile_companySetting">Perusahaan</button>
    @if (session('UIDGlob')->companyid != '')
    <button class="btn btn-secondary mt-2 me-2" onclick="opnMasterProduct()">Produk</button>
    <button class="btn btn-secondary mt-2 me-2" onclick="opnProductType()">Tipe Produk</button>
    <button class="btn btn-secondary mt-2 me-2" onclick="opnPaymentMethod()">Metode Pembayaran</button>
    <button class="btn btn-secondary mt-2 me-2" onclick="opnmdlcustomer()">Tambah Customer</button>
    @endif
    {{-- <button class="btn btn-secondary mt-2 me-2" onclick="opnmdlpengelola()">Tambah Pengelola</button> --}}
    @if (session('UIDGlob')->companyid != '')
    <div class="mt-4 card p-2">
        @include('iklan')
    </div>
    @endif
    <!-- Modal popup -->
    <div class="modal fade" id="myprofile_companySetting" tabindex="-1" aria-labelledby="myprofile_companySettingLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id='myprofile-formcompany'>
                <input type="hidden" id='myprofile-companyidP' name="companyid" value="{{$tblcomp['companyid']}}">
                <div class="modal-header">
                    <h5 class="modal-title" id="myprofile_companySettingLabel">Perusahaan</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session('UIDGlob')->companyid == '')
                    <div class='mt-3'>
                        <label class='form-label' for='myprofile_companynameP'>Subsribe</label>
                        <select name="subscribe" id="myprofile_subscribe" class="form-select" style="background-color: red;color:white;font-weight:bold;">
                            @foreach ($paketFree as $p)
                                <option value="{{$p->productCode}}">{{$p->productName}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class='mt-3'>
                        <label class='form-label' for='myprofile_companynameP'>Nama Perusahaan</label>
                        <input type='text' id='myprofile_companynameP' class='form-control' name='companyname' value="{{$tblcomp['companyname']}}" required/>
                    </div>
                    <div class='mt-3'>
                        <label class='form-label' for='myprofile_producttypeArrayP'>Pilih Pengelola</label>
                        <select style='width:100%;' name='producttypeArray[]' id='myprofile_producttypeArrayP' class='form-control select2' multiple='multiple' required>
                            @foreach ($tblproducttype as $d)
                                @php
                                    $productTempCompany = json_decode($tblcomp['producttypeArray']);
                                    if (is_array($productTempCompany)) {
                                        $select = in_array($d->producttypeid, $productTempCompany) ? "selected" : "";
                                    }else{
                                        $select = '';
                                    }
                                @endphp
                                <option value="{{ $d->producttypeid }}" {{ $select }}>{{ $d->productTypeName }}</option>
                            @endforeach;
                        </select>
                    </div>
                    <div class='mt-3'>
                        <label class='form-label' for='myprofile_emailP'>Email Perusahaan</label>
                        <input type='text' id='myprofile_emailP' class='form-control' name='email' value="{{$tblcomp['email']}}" required/>
                    </div>
                    <div class='mt-3'>
                        <label class='form-label' for='myprofile_hpP'>HP</label>
                        <input type='text' id='myprofile_hpP' class='form-control' name='hp' value="{{$tblcomp['hp']}}" required/>
                    </div>
                    <div class='mt-3'>
                        <label class='form-label' for='myprofile_companyaddressP'>Alamat Perusahaan</label>
                        <input type='text' id='myprofile_companyaddressP' class='form-control' name='companyaddress' value="{{$tblcomp['companyaddress']}}" required/>
                    </div>
                </div>
                <div class="modal-footer">
                    @if (session('UIDGlob')->companyid != '')
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    @else
                    <button type="submit" class="col-12 btn btn-danger" name="subscribe" value="1">Subscribe</button>
                    <a href="https://api.whatsapp.com/send?phone={{$tblcomp['hp']}}" target="_blank" class="col-12 btn btn-outline-secondary" style="height: 35px;">
                        <i class="fab fa-whatsapp"></i> Follow Up? <span style="color:red; font-size:0.8em;">*Menunggu Persetujuan Admin Sis Billing</span>
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>  
</div>
<script>
    // function toggleSeeMID() {
    //     var inputs = document.querySelectorAll('.seemid');
    //     inputs.forEach(function(input) {
    //         if (input.type === 'password') {
    //             input.type = 'text'; // Ganti ke tipe teks
    //             $('#seemid').text("Sembunyikan")
    //         } else {
    //             input.type = 'password'; // Ganti ke tipe sandi (password)
    //             $('#seemid').text("Lihat")
    //         }
    //     });
    // }
    function opnmdlcustomer(){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '{{url("/viewaddcustomer")}}',
            success: function(data) {
                openmodal('Tambah Customer',data)
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
    function opnmdlpengelola(){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '{{url("/viewaddpengelola")}}',
            success: function(data) {
                openmodal('Tambah Pengelola',data)
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
    
    function opnMasterProduct(){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '{{url("/viewmasterproduct")}}',
            success: function(data) {
                openmodal('Master Product',data)
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
    function opnProductType(){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '{{url("/viewproductype")}}',
            success: function(data) {
                openmodal('Product Type',data)
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
    function opnPaymentMethod(){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '{{url("/viewpaymentmethod")}}',
            success: function(data) {
                openmodal('Payment Method',data)
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
    $("#myprofile_companysetting").dxPopup({
        fullScreen: true,
        title: "Company Setting",
    });
    $('#myprofile_producttypeArrayP').select2()
    
    // var select2Element = $('.select2').select2();
    // select2Element.append(new Option(d.productTypeName, d.producttypeid, true, true)).trigger('change') //add selected
    // $('h4').append(formCompany)
    // $('#myprofile_producttypeArray').select2();

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
            $('#myprofile-saveimage').show()
        }
    }
    $("#imageUpload").change(function() {
        readURL(this);
    });
    $('#formctu').submit(function(g){
        g.preventDefault()
        if($('#myprofile_companyaddE').val() == ''){
            showNty("Tolong Pilih Pengelola")
            return false;
        }else{
            this.submit();
        }
    })
    $('#myprofile-formcompany').submit(function(d) {
        $('#loader').show('slow')
        d.preventDefault();
        $.ajax({
            type: 'POST',
            cache: false,
            url: '{{url("/companyUpdate")}}',
            data: $('#myprofile-formcompany').serialize(),
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(data) {
                if(data == 'view'){
                    window.location.href = '{{url("/success")}}'
                }else{
                    showNty(data)
                    $('#loader').hide('slow')
                }
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
                $('#loader').hide('slow')
            }
        });
    });
    $('#myprofile-formimg').submit(function(e){
        e.preventDefault()
        // Get the file input element and the selected file
        var input = $('#imageUpload')[0];
        var file = input.files[0];
        
        // Create a FormData object and add the file to it
        var formData = new FormData();
        formData.append('image', file);
        
        // Make an AJAX request to the server to upload the image
        $.ajax({
            url: '{{url("/uploadimageprofile")}}',
            type: 'POST',
            cache: false,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(data) {
                // Handle the response from the server
                console.log(data);
                $('#imagePreview').css('background-image', 'url(' + data + ')');
                $('#myprofile-saveimage').hide()
                showNty('Success Change Profile')
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    })
    $('#myprofile-formprofile').submit(function(f) {
        f.preventDefault();
        var formData = new FormData();

        // Mengambil value dari form input
        var nama = $('#myprofile_nama').val();
        var email = $('#myprofile_Email').val();
        var hp = $('#myprofile_hp').val();
        var alamatSingkat = $('#myprofile_alamatSingkat').val();
        var alamatLengkap = $('#myprofile_alamatLengkap').val();
        var infoTambahan = $('#myprofile_infoTambahan').val();

        // Menambahkan value ke dalam FormData object
        formData.append('nama', nama);
        formData.append('email', email);
        formData.append('hp', hp);
        formData.append('alamatSingkat', alamatSingkat);
        formData.append('alamatLengkap', alamatLengkap);
        formData.append('infoTambahan', infoTambahan);

        // Mengirim request ke server menggunakan Ajax
        $.ajax({
            type: 'POST',
            cache: false,
            url: '{{url("/updateUser")}}',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(data) {
                $('#myprofile_nama').val(data.nama);
                $('#myprofile_Email').val(data.email);
                $('#myprofile_hp').val(data.hp);
                $('#myprofile_alamatSingkat').val(data.alamatSingkat);
                $('#myprofile_alamatLengkap').val(data.alamatLengkap);
                $('#myprofile_infoTambahan').val(data.infoTambahan);
                showNty('Success Save')
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    });
    $('#myprofile_Password, #myprofile_Password2').on('input',function(){
        if($('#myprofile_Password').val() != $('#myprofile_Password2').val()){
            $('#alertpass').show()
            $('#myprofile_savepass').prop('disabled',true)
        }else{
            $('#myprofile_savepass').prop('disabled',false)
            $('#alertpass').hide()
        }
    })
    
    $('#myprofile_savepass').click(function(){
        var myprofile_Passwordold = $('#myprofile_Passwordold').val()
        var myprofile_Password = $('#myprofile_Password').val()
        var myprofile_Password2 = $('#myprofile_Password2').val()

        if(myprofile_Passwordold == "" && myprofile_Password == "" && myprofile_Password2 == ""){
            showNty('Please Input Password')
            return false
        }
        if (myprofile_Password.length < 6) {
            showNty('The password must consist of a minimum of 6 characters')
            return false;
        }

        var formData = new FormData();
        formData.append('passwordold', myprofile_Passwordold);
        formData.append('password', myprofile_Password);

        $.ajax({
            type: 'POST',
            cache: false,
            url: '{{url("/changePass")}}',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function(data) {
                if(data == 0){
                    showNty('Old password is incorrect')
                    return false
                }
                $('#myprofile_Passwordold').val("");
                $('#myprofile_Password').val("");
                $('#myprofile_Password2').val("");
                showNty('Success Save')
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    })
</script>