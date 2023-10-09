<style>
    
.komentar {
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: flex-start;
	list-style-type: none;
	padding: 0;
	margin: 0;
}
</style>
<div class="row container">
    <small class="col-12" style="text-align: justify;">{!!$tblpengumuman->pengumuman!!}</small>
    <hr class="mt-1">
</div>
<div id="komentar-wrapper" class="glasskomentar container" style="padding-bottom: 10vh;">
    <ul class="komentar scroller-content" id="contentkomentard">
    </ul>
</div>
<form id="msgkmtr-form" class="d-flex wrapkomentar" style="position: fixed; bottom:20px; right:10vw; left:10vw; padding:0;">
    <div class="col-1" hidden>
        <button onclick="alert('On Progress')" type="button" class="btn btn-primary" style="border-radius: 20px; height:33px; width:40px; padding:5px 10px 10px 10px">
            <img width="20" height='20' src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAD50lEQVR4nO2Ya4hVVRTH70w+mvHFZDgqiqIjWAihlBoI6Qeh8jX4oISQyBGSCNLID5HaBynFtAwMMUJUFES0IUUEdRJClCLynUb0sETUHr7SmdJ+sZp1ZLNc58xV9r3jh/OH+TD3f/be/7X32uuxC4UcOXLkuFcAjwNrgB+Af4C/gMPA20C/QnsC6JDBdQHWAf+SjivAPKCivMpbBb4IXAUuAM8YrjvwNcVjLVBZTvFj1R0SfB9wlcBu7h6ryiW+H3DeLP5NwItvW1wA5gC9gf7Aq8Bv5htxtTGlFt8ZOGQWvgWMV/5p/T/EcaDWmWsA8KP5dlupDRBftVgYCLK7+idQlzHfU86lLs1dABoc8TvV5+VkvnRcYnIR854143qWQvxIoNksJHG9RvmPHOPeUa4j8D7wLbASeMDM/asZVx1bfC/gjFnkBjBc+Rcc8XsTocAqwz0fzD3McaGKqIkKaHIEvhQIuGa4X8Ro5Z9LG6t8o+E+jSZeF3jPEfBxkKxOG64FeFL5RzXRhZCo0115CaUWE2KKn+qUAVLDVMkxA1sdAa/o2K7ACcM1S12k/Gg1NsQX0dwnxTV+BwYqP98RvykYv8Xh5yjX24k8l4AhscR304gR4lZS74iLOLt3TIo35aU4s9gY3Kn9hpNTnhpLvLjGdkfAYuVrnbAnkeORDOOOJKERWOHMvSSK+Iw6Zo+ERP3b4+ze9Azj/gAGK1/v3Knb4TaG+AlOHfNTkhmBpY5xyzPCrcw1MSMiydwPx0xWF51klUSNKc7u7U8aGmBZmmvg36nbc8cy4ENHQINydVqUhTgH9FV+UpprZITb2THF93HqnM3KVWnsD/F3UrdL6NMQGOJM4hrAG2mJMKYBC8wCl5P6XRZzBLymXLVGmBCyEaOUH2e6NsFXwIOxDWjyWjvNltY1tgTj1nMn5mZ0bRelZ4gqXheTHQ8xTn+Xp5AQJ6VEUO5lR/wG5ToBBw13M+naYouXgsyiNuVkpujvTzh35miQrFY7c74ZXXzgxxZJk7LP/C4vDdO0XHbrGGCWM19jyd59NMzZKDJWubdoG3JH6vX7x4Drhv8O6FES8YERO8yinwQJ6Oc2DHhXv62RtyHDSTU7rKTiU5r1m0G7OAg4lSJ+mZ5gpTb3FjNLLl6gLwq2CJOdHxTwc/WkDsgJBYmsIqWh/6BQTgAzHBESx5/NGNMjpXGRzqpjWQ1IeT1IsEtfHuRJ8CFghF5wW/wlJ9en0B6g1R28hqNYyPvn0HYRHwJ43UlUbeFQ0rjcF6C1qf+8COHSTi5qF58vBlJZ6t04rAmvRSPWZxqZ/s/aOXLkyJGjcD/jPzQKbK6hl5kmAAAAAElFTkSuQmCC">
        </button>
    </div>
    <div class="col d-flex">
        <input id="msgkmtr-input" type="text" class="form-control" style="border-radius:15px; margin: 0 20px 0 20px;" autocomplete="off">
    </div>
    <div class="col-1">
        <button type="submit" class="btn btn-primary" style="border-radius: 20px; height:33px; width:40px; padding:5px 10px 10px 10px">
            <img width="20" height='20' src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAACXBIWXMAAAsTAAALEwEAmpwYAAAEdUlEQVR4nO2aTW/TWBSGLdggVsOSDWKFRpo/gBBL+A1sWLNlx441rNDsoapACNQWcCFVStqkJpA2bXHrxl83uLHDR1WVxmZgpEGiaDjIgbSJ61zf61x/xO2RzqZxrvWcnuQ9fnM47jAO48CE/O7ziZqxdXVZ3njJHZQAgKOaaV/QLWdcVDa+z1UboDVaE1zWQ1t3/kKmfRNZzpZm2lB+3YT8CwTKeutHs/nvn1xWWxxZzhVkOSKyHHBzVd+CvKDD1JwGK9omINPZ5LLa4siyv3XAkWXDvPgWJmeUNnyhYrT/rln2DS5rLY52oX9l7c1HKJTrwBfkNvzDqRVApg26Zf8vinCcy1KLI09WpfcwOavswo+MLYDaaP16vWGvctlpcacnFaMFsxWjDd6Bvz1WgWXlw9411udLXBZaHHlySd6AZ0V1H3y+rO1dZ9pfuSy0OOpKt7VL1fVd8G74B0+XQTf3rtUtm+eGucWRJ1fUTZgqab7wIxMVUIztnutTp/0aRYt3Z2eomZyRfeHdXJDe9b4vLdovU7a4NztDTTe4F/5ZSdlftCS1H0K2eG/uDTU4+Lu8+7m3e96bmPZrIVscN9Tg4N2s1T/uPyNO7ZcHbHHcUBME/0ps+s8HUWs/MGlx/FATBM/P1ED3OytK7dcYtXjQUBMEP8pX28rgdxZz7ZcZt3jQUBME76akb/U9k4n2QwQtTjLUkMALS43+5w6q/VpELU4y1JDAj+dX8WeH0X45whYnHWpI4EcnFl1fr+/ZobRfN52/kWXvRA2OG2pI4N1sW1u4e4TRftX8dEo3bTNKeNxQQwrfsbZwGVr71QiLgBtqSOE71hb2XoNqv8q4CEFDDSl8j7WFSSbarzIqQtBQQwrvtbZwyey5Xx2gCCRDDQ18j7WFbX/Gz/1qiCKQDDU08F5rC5eRPPerhEUgHWpo4P2sLcxnP7rnfjWgCKRDDQ28r7WFy6if+1XfIpAPNbTwftYWVm3i8PzVriLQDDW08H7WFv7LL0bPHzX/Ob0gvf9COtTsgxfw8H2trai1nyZyJW0niv88ztqKRftJQhCaxyYL7D/zWGsrTu0PimLVuBgFPM7ail37cSEsWddZwwdZW4lof78oLqw/Zg2PtbaS1H6/mK0Yayzhg6ytxLXfG9Nl1GIFH2RtpUb7aSSQFJ7I2kqT9pNIIA08ibWVGu0nkUAaeCJrK03aHySBNPCk1laqtB8ngTTwNNZWqrS/nwTSwhNbW2nT/k48L9e3w8Df4xe/TUxLht5oDfzbYqK7frnfEoiDvzM2D/efLv/3aFpayxWVW8J8fffbWm9+OTvQr09J7voJvyXQCz/yaP7Hw5zo8IW1F7k55ZogSH/gzhmkCInu+hWrxkUX/h6/uDOel0y+VHsyJWiXAeAI7Vlhi5Dorp8obp+cfWmeYXUeeuuc0037e+q1P8qg6YTM7PmHKcLQ7/kPXIRh3PNnWYSh2vNnXoRh2POPsgip3fOPqwip2/OPK+rmp/N6w5Ziu+FhcAczfgImbNaj6l8OQQAAAABJRU5ErkJggg==">
        </button>
    </div>
</form>
<script>
    var pengumumanid = $('#primarymodal').attr('val')
    var scrollView = $("#primarymodal").dxScrollView({
        height: "100%",
        width: "100%",
    }).dxScrollView("instance");

    // menentukan posisi scroll ke bagian bawah
    function scrolltoBottomkomentar(){
        setTimeout(function() {
            scrollView.scrollTo({ left: 10, top: $('.glasskomentar').height() });
        }, 100);
    }

    var contentkomentar = $('#contentkomentard')
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        cache: false,
        url: '{{url("/getkomentard")}}',
        data: {pengumumanid},
        success: function(data) {
            contentkomentar.html("")
            data.forEach(e => {
                var urli = 'public/storage/'+e.profileImg
                var name = `<img src="{{asset('')}}`+urli+`" style="border-radius:100%; width:20px; height:20px; margin-right:10px;"><b>`+e.nama+`</b><small> `+new Date(e.InsertDT).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })+`</small><br>`
                var komentar = "<li class='msgkmtr item'> " +
                                name+"<p style='margin-left:30px;'>"+e.pesan+"</p>" +
                            "</li>"
                contentkomentar.append(komentar)
            });
            scrolltoBottomkomentar()
            renderlonceng()
        },
        error: function(xhr, status, error) {
            new Noty({
                text: error,
                timeout: 10000 
            }).show();
        }
    });
    $('#msgkmtr-form').unbind()
    $('#msgkmtr-form').submit(function(s){
        s.preventDefault()
        if($('#msgkmtr-input').val() ==""){
            return false
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            cache: false,
            url: '{{url("/sendkomentar")}}',
            data: {
                pengumumanid,
                description : $('#msgkmtr-input').val()
            },
            success: function(data) {
                $('#msgkmtr-input').val("")
            },
            error: function(xhr, status, error) {
                new Noty({
                    text: error,
                    timeout: 10000 
                }).show();
            }
        });
    })
</script>