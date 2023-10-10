<div id="myModalMini" class="dx-popup dx-popup-fullscreen"></div>

<script>
    function openmodalMini(title, content, val) {
        alert('msk')
        var popup2 = $('#myModalMini').dxPopup('instance');
        popup2.option('title', title);
        popup2.option('contentTemplate', function() {
            return $('<div id="primarymodalMini" val="'+val+'">').html(content); 
        });
        popup2.option('showCloseButton', true); 
        popup2.option('shading', false);
        popup2.option("height", "80vh");
        popup2.option("max-width", "400px");
        if (DevExpress.devices.current().deviceType === "phone" || DevExpress.devices.current().deviceType === "tablet") {
            popup2.option("fullScreen", true);
            popup2.option("height", "100vh");
            popup2.option("width", "100vw");
        }
        popup2.show();
    }
    function closemodalMini() {
        var popup2 = $('#myModalMini').dxPopup('instance');
        popup2.hide();
    }

    $(function() {
        var popup2 = $("#myModalMini").dxPopup({
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
                popup2.option("height", viewportHeight);
            } else {
                popup2.option("height", '80vh');
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
<?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/modal/mainModalMini.blade.php ENDPATH**/ ?>