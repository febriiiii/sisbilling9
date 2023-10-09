<div id="myModal2" class="dx-popup dx-popup-fullscreen"></div>

<script>
    function openmodal2(title, content, val) {
        var popup = $('#myModal2').dxPopup('instance');
        popup.option('title', title);
        popup.option('contentTemplate', function() {
            return $('<div id="primarymodal2" val="'+val+'">').html(content); 
        });
        popup.option('showCloseButton', true); 
        if (DevExpress.devices.current().deviceType === "phone" || DevExpress.devices.current().deviceType === "tablet") {
            popup.option("fullScreen", true);
            popup.option("height", "100vh");
            popup.option("width", "100vw");
        }
        popup.show();
    }
    function closemodal2() {
        var popup = $('#myModal2').dxPopup('instance');
        popup.hide();
    }

    $(function() {
        var popup = $("#myModal2").dxPopup({
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
