<style>
    .headericon{
        background-color: white;
        border-radius: 7px;
        padding:3px;
        opacity: 0.8px;
    }
</style>
<header>
    <nav class="navbar navbar-expand-lg blueBack" style="padding: 10px 0 0 0;">
      <div class="container-fluid row">
        <div class="col-4" style="display: flex; flex-direction: column; align-items: start;">
            <a class="headericonX">
                {{-- <img src="{{asset('public/pivot.png')}}" width="30" height="30"> --}}
                <lord-icon onclick="opnhome()" class="me-2"
                    src="https://cdn.lordicon.com/icxqolmx.json"
                    trigger="click"
                    colors="primary:#ffffff"
                    style="width:30px;height:30px">
                </lord-icon>
                @if (session('UIDGlob')->superadmin == 1)
                <lord-icon onclick="opnadmin()">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAB20lEQVR4nO2Zu0oDURBA1wc+QL/A2IpW+hGCkDRGUfFHbNXCQnwljZV2ImIt8RtiYxtDFP0CMYgmIBxZ3GJcZG82Oze5K3sgTZjMnZPdmZ0Qz8vIyMhwGmAE2AAugRrwHrxqwXvrfoznIsAq8IiZBrDiuQIwBBwSnwNg0AWBQ7pn34XbJinL/WzYRuLy4akvjc3PtIniBpgCckDFELvWD4FLQ1E5ETttiL0QsYskow3cAQWTwIOiQE3E+ldNi0KUQNPw4Upw+/jF3xpimyLvmKJANUrgU/GgD5F3UjFvK0rAnx5aNETeGcW8RAlcK55zJfIu9UpgU/GcDZH3qFcCo8CLwhnP8kEG1OmFgOIqURT5CujS8kwA5QQHHIs8g8A9ulQ7EfAPPuki+ZFcp4Et9MkbBUQBxW430GB9+FIquu1/87GKF4V0hOcqaDWW4wJlz1Uwcx5q3B30aXe0Tnch4D+ghkNb5yt2Kdi+AtuWBaraAr96AJi3LNCyIdC0tPv/iQ2BkohfIGUCZ6Ee2E2TQD00hcaBtzQJ/DWF9khhE5dF/Gwax2hTxE9YFsjHFfAf43Gm0JyFottJ1ulynCnkHMAAcNpJA6dN4jwVxYd+J5eCP/hOUlV8RsY/5htMrhuyGH7z2gAAAABJRU5ErkJggg==">
                </lord-icon>
                @endif
            </a>
        </div>
        <div class="col-4">
            <center>
                <a id="title" class="whiteFont" href="#" style="font-weight: bold; font-size:1.1em">Sis Billing</a>
            </center>
        </div>
        <div class="col-4">
            <div style="display: flex; justify-content: flex-end; margin-right:-30px;">
                <div id="contentlonceng">
                    
                </div>
                <a href="{{url('/logout')}}" class="ms-3 headericonX">
                    {{-- <span><img src="{{asset('public/logout.png')}}" width="30" height="30"></span> --}}
                    <lord-icon
                        src="https://cdn.lordicon.com/nhfyhmlt.json"
                        trigger="click"
                        colors="primary:#ffffff"
                        style="width:30px;height:30px">
                    </lord-icon>
                </a>
            </div>
        </div>
      </div>
    </nav>
  </header>

  <script>
    renderlonceng()
    function renderlonceng(){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '{{url("/viewlonceng")}}',
            success: function(data) {
                $('#contentlonceng').html(data)
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
    function opnhome(){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '{{url("/viewhome")}}',
            success: function(data) {
                openmodal("Report",data)
                $('#contentbill1').hide()
                $('#contentbill1').slideDown('slow')
                querysaled()
                querysaledBil()
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
    function opnadmin(){
        $.ajax({
            type: 'GET',
            cache: false,
            url: '{{url("/administrator")}}',
            success: function(data) {
                openmodal("Administrator",data)
            },
            error: function(xhr, status, error) {
                showNty(error,10000)
            }
        });
    }
  </script>
  