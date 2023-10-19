<style>
.chat {
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: flex-start;
	list-style-type: none;
	padding: 0;
	margin: 0;
}

.message {
	background-color: rgba(255, 255, 255, 0.9);
	border-radius: 0;
	box-shadow: 0px 7px 5px 0px rgba(211, 205, 205, 0.5);
	position: relative;
	margin-bottom: 30px;
}

.message.left {
	padding: 5px 10px 5px 10px;
}

.message.right {
	align-self: flex-end;
	padding: 5px 10px 5px 10px;
}

.message p {
	margin: 0;
}
.message i {
	font-size: 0.6em;
}
.message p small{
	font-size: 0.6em;
    margin-left:10px;
}
/* .glasschat{
    background: rgba(243, 255, 216, 0.2);
    border-radius: 16px;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    border: 1px solid rgba(255, 255, 255, 0.3);
} */
#image-previewmsg{
    width: 100%;
    height: 100%;
    border-radius: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}
</style>

<div id="chat-wrapper" class="glasschat container p-3 cardX" style="max-width: 600px;">
    <ul class="chat scroller-content" id="contentchatd">
        
    </ul>
</div>

<!-- Fullscreen Modal PHOTO VIEW-->
<div id="modal-media-image" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
        <button class="uk-modal-close-outside" type="button" uk-close></button>
        <img id="imgView" src="" width="1800" height="1200" alt="">
    </div>
</div>

<script>
    // start open modal image
    function openmodalImage(url){
        $('#modal-media-image').css('z-index','11100')
        UIkit.modal('#modal-media-image').show()
        $('#imgView').prop('src',url)
    }
    // end open modal image
    var chatid = $('#primarymodal').attr('val')
    var scrollView = $("#primarymodal").dxScrollView({
        height: "100%",
        width: "100%",
    }).dxScrollView("instance");
    
    var formsendpesan = `<div class="d-flex wrapchat" style="position: fixed; bottom:20px; right:5vw; left:5vw; padding:0;">
                            <div class="col-1">
                                <label for="file-inputpesanmsg" class="btn btn-primary" style="border-radius: 20px; height:33px; width:40px; padding:5px 10px 10px 10px">
                                    <img width="20" height='20' src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAD50lEQVR4nO2Ya4hVVRTH70w+mvHFZDgqiqIjWAihlBoI6Qeh8jX4oISQyBGSCNLID5HaBynFtAwMMUJUFES0IUUEdRJClCLynUb0sETUHr7SmdJ+sZp1ZLNc58xV9r3jh/OH+TD3f/be/7X32uuxC4UcOXLkuFcAjwNrgB+Af4C/gMPA20C/QnsC6JDBdQHWAf+SjivAPKCivMpbBb4IXAUuAM8YrjvwNcVjLVBZTvFj1R0SfB9wlcBu7h6ryiW+H3DeLP5NwItvW1wA5gC9gf7Aq8Bv5htxtTGlFt8ZOGQWvgWMV/5p/T/EcaDWmWsA8KP5dlupDRBftVgYCLK7+idQlzHfU86lLs1dABoc8TvV5+VkvnRcYnIR854143qWQvxIoNksJHG9RvmPHOPeUa4j8D7wLbASeMDM/asZVx1bfC/gjFnkBjBc+Rcc8XsTocAqwz0fzD3McaGKqIkKaHIEvhQIuGa4X8Ro5Z9LG6t8o+E+jSZeF3jPEfBxkKxOG64FeFL5RzXRhZCo0115CaUWE2KKn+qUAVLDVMkxA1sdAa/o2K7ACcM1S12k/Gg1NsQX0dwnxTV+BwYqP98RvykYv8Xh5yjX24k8l4AhscR304gR4lZS74iLOLt3TIo35aU4s9gY3Kn9hpNTnhpLvLjGdkfAYuVrnbAnkeORDOOOJKERWOHMvSSK+Iw6Zo+ERP3b4+ze9Azj/gAGK1/v3Knb4TaG+AlOHfNTkhmBpY5xyzPCrcw1MSMiydwPx0xWF51klUSNKc7u7U8aGmBZmmvg36nbc8cy4ENHQINydVqUhTgH9FV+UpprZITb2THF93HqnM3KVWnsD/F3UrdL6NMQGOJM4hrAG2mJMKYBC8wCl5P6XRZzBLymXLVGmBCyEaOUH2e6NsFXwIOxDWjyWjvNltY1tgTj1nMn5mZ0bRelZ4gqXheTHQ8xTn+Xp5AQJ6VEUO5lR/wG5ToBBw13M+naYouXgsyiNuVkpujvTzh35miQrFY7c74ZXXzgxxZJk7LP/C4vDdO0XHbrGGCWM19jyd59NMzZKDJWubdoG3JH6vX7x4Drhv8O6FES8YERO8yinwQJ6Oc2DHhXv62RtyHDSTU7rKTiU5r1m0G7OAg4lSJ+mZ5gpTb3FjNLLl6gLwq2CJOdHxTwc/WkDsgJBYmsIqWh/6BQTgAzHBESx5/NGNMjpXGRzqpjWQ1IeT1IsEtfHuRJ8CFghF5wW/wlJ9en0B6g1R28hqNYyPvn0HYRHwJ43UlUbeFQ0rjcF6C1qf+8COHSTi5qF58vBlJZ6t04rAmvRSPWZxqZ/s/aOXLkyJGjcD/jPzQKbK6hl5kmAAAAAElFTkSuQmCC">
                                    <input type="file" accept=".png, .jpg, .jpeg" id="file-inputpesanmsg" style="opacity: 0;position: absolute;z-index: -1;">
                                </label>
                            </div>
                            <div id="image-previewmsg" style="width: 230px;height:150px; position:absolute;border-radius:30px;margin-top:-170px;">
                                <button id="sendmsgimgprivate" class="btn btn-light" style="position:absolute;right:-30px;bottom:0; margin:0;padding:5px;border-radius:100%;"><i class="las la-upload" style="font-weight:bold;font-size:1.5em;"></i></button>
                                <button onclick="$('#image-previewmsg').hide();" class="btn btn-light" style="position:absolute;right:-30px;bottom:50px; margin:0;padding:5px;border-radius:100%;"><i class="las la-times" style="font-weight:bold;font-size:1.5em;"></i></button>
                            </div>
                            <form id="message-form" class="col d-flex">
                                <div class="col d-flex">
                                    <input id="message-input" type="text" class="form-control" style="border-radius:15px; margin: 0 20px 0 20px;" autocomplete="off">
                                </div>
                                <div class="col-1">
                                    <button type="submit" class="btn btn-primary" style="border-radius: 20px; height:33px; width:40px; padding:5px 10px 10px 10px">
                                        <img width="20" height='20' src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAACXBIWXMAAAsTAAALEwEAmpwYAAAEdUlEQVR4nO2aTW/TWBSGLdggVsOSDWKFRpo/gBBL+A1sWLNlx441rNDsoapACNQWcCFVStqkJpA2bXHrxl83uLHDR1WVxmZgpEGiaDjIgbSJ61zf61x/xO2RzqZxrvWcnuQ9fnM47jAO48CE/O7ziZqxdXVZ3njJHZQAgKOaaV/QLWdcVDa+z1UboDVaE1zWQ1t3/kKmfRNZzpZm2lB+3YT8CwTKeutHs/nvn1xWWxxZzhVkOSKyHHBzVd+CvKDD1JwGK9omINPZ5LLa4siyv3XAkWXDvPgWJmeUNnyhYrT/rln2DS5rLY52oX9l7c1HKJTrwBfkNvzDqRVApg26Zf8vinCcy1KLI09WpfcwOavswo+MLYDaaP16vWGvctlpcacnFaMFsxWjDd6Bvz1WgWXlw9411udLXBZaHHlySd6AZ0V1H3y+rO1dZ9pfuSy0OOpKt7VL1fVd8G74B0+XQTf3rtUtm+eGucWRJ1fUTZgqab7wIxMVUIztnutTp/0aRYt3Z2eomZyRfeHdXJDe9b4vLdovU7a4NztDTTe4F/5ZSdlftCS1H0K2eG/uDTU4+Lu8+7m3e96bmPZrIVscN9Tg4N2s1T/uPyNO7ZcHbHHcUBME/0ps+s8HUWs/MGlx/FATBM/P1ED3OytK7dcYtXjQUBMEP8pX28rgdxZz7ZcZt3jQUBME76akb/U9k4n2QwQtTjLUkMALS43+5w6q/VpELU4y1JDAj+dX8WeH0X45whYnHWpI4EcnFl1fr+/ZobRfN52/kWXvRA2OG2pI4N1sW1u4e4TRftX8dEo3bTNKeNxQQwrfsbZwGVr71QiLgBtqSOE71hb2XoNqv8q4CEFDDSl8j7WFSSbarzIqQtBQQwrvtbZwyey5Xx2gCCRDDQ18j7WFbX/Gz/1qiCKQDDU08F5rC5eRPPerhEUgHWpo4P2sLcxnP7rnfjWgCKRDDQ28r7WFy6if+1XfIpAPNbTwftYWVm3i8PzVriLQDDW08H7WFv7LL0bPHzX/Ob0gvf9COtTsgxfw8H2trai1nyZyJW0niv88ztqKRftJQhCaxyYL7D/zWGsrTu0PimLVuBgFPM7ail37cSEsWddZwwdZW4lof78oLqw/Zg2PtbaS1H6/mK0Yayzhg6ytxLXfG9Nl1GIFH2RtpUb7aSSQFJ7I2kqT9pNIIA08ibWVGu0nkUAaeCJrK03aHySBNPCk1laqtB8ngTTwNNZWqrS/nwTSwhNbW2nT/k48L9e3w8Df4xe/TUxLht5oDfzbYqK7frnfEoiDvzM2D/efLv/3aFpayxWVW8J8fffbWm9+OTvQr09J7voJvyXQCz/yaP7Hw5zo8IW1F7k55ZogSH/gzhmkCInu+hWrxkUX/h6/uDOel0y+VHsyJWiXAeAI7Vlhi5Dorp8obp+cfWmeYXUeeuuc0037e+q1P8qg6YTM7PmHKcLQ7/kPXIRh3PNnWYSh2vNnXoRh2POPsgip3fOPqwip2/OPK+rmp/N6w5Ziu+FhcAczfgImbNaj6l8OQQAAAABJRU5ErkJggg==">
                                    </button>
                                </div>
                            </form>
                        </div>`

    // setTimeout(() => {
        $('#primarymodal').append(formsendpesan)
        $('#image-previewmsg').hide();
        function readURLmsgprivate(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-previewmsg').css('background-image', 'url('+e.target.result +')');
                    $('#image-previewmsg').hide();
                    $('#image-previewmsg').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#file-inputpesanmsg").change(function() {
            readURLmsgprivate(this);
        });
        $('#sendmsgimgprivate').click(function(){
            // Get the file input element and the selected file
            var input = $('#file-inputpesanmsg')[0];
            var file = input.files[0];
            
            // Create a FormData object and add the file to it
            var formData = new FormData();
            formData.append('image', file);
            formData.append('chatid', chatid);
            // Make an AJAX request to the server to upload the image
            $.ajax({
                url: '{{url("/sendimgchat")}}',
                type: 'POST',
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                success: function(data) {
                    $('#image-previewmsg').hide();
                },
                error: function(xhr, status, error) {
                    showNty(error,10000)
                }
            });
        })
        $('#message-form').unbind().submit(function(s){
            s.preventDefault()
            if($('#message-input').val() ==""){
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
                url: '{{url("/sendchat")}}',
                data: {
                    chatid,
                    description : $('#message-input').val()
                },
                success: function(data) {
                    $('#message-input').val("")
                },
                error: function(xhr, status, error) {
                    showNty(error,10000)
                }
            });
        })
    // }, 400);
    
    // menentukan posisi scroll ke bagian bawah
    function scrolltoBottomChat(){
        setTimeout(function() {
            scrollView.scrollTo({ left: 10, top: $('.glasschat').height() });
        }, 100);
    }

    var contentchat = $('#contentchatd')
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        cache: false,
        url: '{{url("/getchatd")}}',
        data: {chatid},
        success: function(data) {
            contentchat.html("")
            var urli = 'public/storage/'+data.header.profileImg
            var header = `<div class="">`+
                            `<img src="{{asset('')}}`+urli+`" width="30" height="30" style="border-radius:100%;">`+
                            `<span>`+data.header.nama+`</span>`+
                        `</div>`
            $('.dx-popup-title .dx-toolbar-items-container .dx-toolbar-before').append(header)
            data.detail.forEach(e => {
                var position = "left";
                var name = "<i>"+e.nama+"</i><br>"
                if(e.userid == e.userauth){
                    position = "right"
                    name = ""
                }
                if(e.description != "!@##@!IMG!@##@!"){
                    msg = e.description+"<small>"+e.timef+"</small>"
                }else{
                    msg = `<div onclick="openmodalImage('{{asset('/public/storage/chatimg')}}/`+e.id+`.png')" style="cursor:pointer; background-image: url('{{asset('/public/storage/chatimg')}}/`+e.id+`.png'); background-size: cover; width: 180px; height:130px;"></div>
                        <small style="display: block; text-align:end;">`+e.timef+`</small>`;
                }
                var chat = "<li class='message item "+position+"'> " +
                                name+"<p>"+msg+"</p>" +
                            "</li>"
                contentchat.append(chat)
            });
            scrolltoBottomChat()
            renderlonceng()
            $('#message-input').focus()
        },
        error: function(xhr, status, error) {
            showNty(error,10000)
        }
    });

    // var pusher = new Pusher('{{config("app.PUSHER_APP_KEY")}}', {
    //   cluster: '{{config("app.PUSHER_APP_CLUSTER")}}'
    // });

    // if (channel) {
    //     channel.unbind();
    // }
    // var channel = pusher.subscribe('my-channel');
    // channel.bind('my-event', function(data) {
    //     if(data.type == 'chat'){
    //         if(data.chatid == $('#primarymodal').attr('val')){
    //             var position = "left";
    //             var name = "<i>"+data.nama+"</i><br>"
    //             if("{{isset(session('UIDGlob')->userid)?session('UIDGlob')->userid:null}}" == data.authuser){
    //                 position = "right"
    //                 name = ""
    //             }
    //             msg = data.description+"<small>"+data.InsertDT.split('T')[1].split('.')[0].slice(0, -3)+"</small>"
    //             var chat = "<li class='message item "+position+"'> " +
    //                             name+"<p>"+msg+"</p>" +
    //                         "</li>"
    //             $('#contentchatd').append(chat)
    //             scrolltoBottomChat()
    //         }
    //     }else if(data.type == 'polling'){
    //       if("{{isset(session('UIDGlob')->userid)?session('UIDGlob')->userid:null}}" != data.authuser){
    //         if(data.val == 'like'){
    //           $(`.${data.clp}`).val(parseInt($(`.${data.clp}`).val()) + 1)
    //         }else if(data.val == 'dislike'){
    //           $(`.${data.clp}`).val(parseInt($(`.${data.clp}`).val()) - 1)
    //           if(parseInt($(`.${data.clp}`).val()) < 0){
    //             $(`.${data.clp}`).val(0)
    //           }
    //         }
    //       }
    //     }
    // });
</script>
