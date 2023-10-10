<div id="modalContainer"></div>
<script>
function createNewModal(title,height,width,shading,content,val) {
    var $modalContainer = $(`<div id="primarymodalCustom" val="`+val+`"></div>`);
    $("#modalContainer").append($modalContainer);

    // Buat instance modal
    var popup = $modalContainer.dxPopup({
        title: title,
        width: width,
        height: height,
        showCloseButton: true,
        shading: shading,
        contentTemplate: function (container) {
            container.append(content);
        },
        onHidden: function () {
            $modalContainer.remove();
        }
    }).dxPopup("instance");

    // Tampilkan modal
    popup.show();
}
</script><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/modal/mainModalCustom.blade.php ENDPATH**/ ?>