<div id="myModal" class="dx-popup dx-popup-fullscreen" style="min-width: 500px;"></div>

<script>
    function openmodal(title, content, val) {
        var popup = $('#myModal').dxPopup('instance');
        popup.option('title', title);
        popup.option('contentTemplate', function() {
            return $('<div id="primarymodal" val="'+val+'">').html(content); 
        });
        popup.option("width", "auto");
        popup.option("minWidth", "500px");
        popup.option('showCloseButton', true); 
        if (DevExpress.devices.current().deviceType === "phone" || DevExpress.devices.current().deviceType === "tablet") {
            popup.option("fullScreen", true);
            popup.option("height", "100vh");
            popup.option("width", "100vw");
        }
        popup.show();
    }
    function closemodal() {
        var popup = $('#myModal').dxPopup('instance');
        popup.hide();
    }

    $(function() {
        var popup = $("#myModal").dxPopup({
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
