<div id="myModalSelect" class="dx-popup dx-popup-fullscreen"></div>

<script>
    function openmodalSelect(title, content, val) {
        var popup = $('#myModalSelect').dxPopup('instance');
        popup.option('title', title);
        popup.option('contentTemplate', function() {
            return $('<div id="primarymodalSelect" val="'+val+'">').html(content); 
        });
        popup.option('showCloseButton', true); 
        if (DevExpress.devices.current().deviceType === "phone" || DevExpress.devices.current().deviceType === "tablet") {
            popup.option("fullScreen", true);
            popup.option("height", "100vh");
            popup.option("width", "100vw");
        }
        popup.show();
    }
    function closemodalSelect() {
        var popup = $('#myModalSelect').dxPopup('instance');
        popup.hide();
    }

    $(function() {
        var popup = $("#myModalSelect").dxPopup({
            visible: false,
            fullScreen: false,
            resizeEnabled: true,
            device: {
                deviceType: "phone"
            }
        }).dxPopup("instance");

        function updatePopupHeight() {
            if (DevExpress.devices.current().deviceType === "phone" || DevExpress.devices.current().deviceType === "tablet") {
                var viewportHeight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
                popup.option("height", viewportHeight);
            } else {
                popup.option("height", '80vh');
            }
        }

        // Mendeteksi perubahan orientasi
        window.addEventListener('orientationchange', function () {
            updatePopupHeight();
        });

        // Mengatur tinggi awal elemen saat halaman dimuat
        updatePopupHeight();
    });
</script>

<?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/modal/mainModalSelect.blade.php ENDPATH**/ ?>