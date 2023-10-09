<form id='myforum-formpengumuman'>
    <?php echo csrf_field(); ?>
    <label>Judul</label>
    <input type="text" class="form-control" name="judul" required>
    <div class="html-editor mt-2"></div>
    <input type="hidden" name="pengumuman" id="val-pengumuman">
    <label class="mt-3">Perusahaan</label>
    <select class="form-select mb-3" name="companyid" id="companyidpengumuman">
    <?php $__currentLoopData = $companyarray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($k); ?>"><?php echo e($v); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <?php if(session('UIDGlob')->companyid != ''): ?>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="ispengumumancompany" name="isPengumumanCompany"/>
            <label class="form-check-label" for="ispengumumancompany">Gunakan Sebagai Pengumuman Perusahaan</label>
        </div>
    <?php endif; ?>
    <div id="contentpolling mt-3">
    <div class="row">
        <h4 class="col-auto">Polling</h4>
        <button type="button" onclick="createpolling()" class="col-auto btn btn-secondary">
        <img height="20" width="20" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAAsTAAALEwEAmpwYAAABPklEQVR4nGNgwAKSF9Zolqzraq3f1DcHhIvXdLSmLa3UYCAEctY26ddvnbBj/pkVH3fc3/1/14O9YAxizz+z/EPd1v7tecta9bBqLl7dGjTl8IL7ME248OTD8+4VrWkNwLB5ChGakQ3JW1GvAzegbkv/bmwKP/78BMbY5Bq2TtwK1py5sEkT5D9SDZh3ZvmHpMU16gyl6zvbkAOMWAN23N/zv3RtewtD7aa+udg0gfCff3/AGFkMWW3txt7ZDHWb+2eTbcCmnlkMoARDrhdK1nY0g1MdWYF4evl7cCCCQN2W/p0kR+O2/s0MMJC3rFUPlDiITUiTDs+7m7WsSRtuAAiAkicxhoA0l6xu90fRDHfJinqd+i0TtoESCSiQkAMM5Of6LX3bMGzGBkCBA8rCoCgG4eK17S0pCyvUsCkGAK4nhoxfVAFiAAAAAElFTkSuQmCC">
        </button>
    </div>
    <hr>
    <div id="pollingwrap">
        
    </div>
    </div>
    <button type="submit" class="btn btn-primary">Kirim</button>
</form>

<script>
  var scrollView = $("#primarymodal").dxScrollView({
        height: "100%",
        width: "100%",
    }).dxScrollView("instance");
$('#myforum-formpengumuman').submit(function(h){
    h.preventDefault()
    var htmlEditor = $(".html-editor").dxHtmlEditor("instance");
    var editorContent = htmlEditor.option("value");
    if(editorContent == ""){
        new Noty({
            text: "Tolong Masukan Deskripsi",
            timeout: 2000 
        }).show();
        return false
    }
    $("#val-pengumuman").val(editorContent);

    
    var form = new FormData(this);
    form.append('customData', 'nilai khusus lainnya'); // Contoh penambahan data kustom

    var dataSize = Array.from(form).reduce(function(acc, [key, value]) {
        return acc + encodeURIComponent(key).length + encodeURIComponent(value).length;
    }, 0);

    var maxSize = 10240; // Batas maksimum ukuran data dalam byte

    if (dataSize > maxSize) {
        new Noty({
            text: "Ukuran data melebihi batas yang diizinkan",
            timeout: 2000 
        }).show();
        return false;
    }
    
    $.ajax({
        type: 'POST',
        cache: false,
        url: '<?php echo e(url("/sendpengumuman")); ?>',
        data: $(this).serialize(),
        success: function(d) {
            closemodal()
            new Noty({
                text: "Berhasil Mengirim",
                timeout: 2000 
            }).show();
        },
        error: function(xhr, status, error) {
            new Noty({
                text: error,
                timeout: 10000 
            }).show();
        }
    });
})
// html editor
$(() => {
  const editor = $('.html-editor').dxHtmlEditor({
    height: 400,
    value: "",
    imageUpload: {
      tabs: ['file', 'url'],
      fileUploadMode: 'base64',
    },
    toolbar: {
      items: [
        'undo', 'redo', 'separator',
        {
          name: 'size',
          acceptedValues: ['8pt', '10pt', '12pt', '14pt', '18pt', '24pt', '36pt'],
        },
        {
          name: 'font',
          acceptedValues: ['Arial', 'Courier New', 'Georgia', 'Impact', 'Lucida Console', 'Tahoma', 'Times New Roman', 'Verdana'],
        },
        'separator', 'bold', 'italic', 'strike', 'underline', 'separator',
        'alignLeft', 'alignCenter', 'alignRight', 'alignJustify', 'separator',
        'orderedList', 'bulletList', 'separator',
        {
          name: 'header',
          acceptedValues: [false, 1, 2, 3, 4, 5],
        }, 'separator',
        'color', 'background', 'separator',
        'link', 'image', 'separator',
        'clear', 'codeBlock', 'blockquote', 'separator',
        'insertTable', 'deleteTable',
        'insertRowAbove', 'insertRowBelow', 'deleteRow',
        'insertColumnLeft', 'insertColumnRight', 'deleteColumn',
      ],
    },
    mediaResizing: {
      enabled: true,
    },
  }).dxHtmlEditor('instance');
});
</script><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/getView/viewFormpesanforum.blade.php ENDPATH**/ ?>