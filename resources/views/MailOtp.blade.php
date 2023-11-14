<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>One-Time Password</title>
    <style>
        /* Styles untuk tampilan email */
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }

        .header {
            background-color: whitesmoke;
            padding: 10px;
            text-align: center;
        }

        .content {
            padding: 20px;
            background-color: white;
        }

        .footer {
            background-color: whitesmoke;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Hai {{$name}},</h1>
        </div>
        <div class="content">
            @if (isset($hit))
            <a style="color:red; font-size:1.5em;" href="{{$hit}}">Klik ini untuk konfirmasi</a>
            @endif
            <p>Berikut adalah One-Time Password (OTP) Anda:</p>
            <center>
                <h1>{{ $otp }}</h1>
            </center>
            <small>
                <i style="color:red;">*Otp ini hanya berlaku dalam 24 jam, Harap jangan berikan informasi ini kepada siapapun dan pastikan untuk menjaga kerahasiaan OTP ini.</i>
            </small>
        </div>
        <div class="footer">
            <strong>Email ini dikirimkan secara otomatis. Mohon tidak membalas email ini.</strong>
            
            <center><br>
                <a style="font-size: 1.5em; font-weight:bold;" href="{{url('/')}}">Sis Billing</a>
            </center>
        </div>
    </div>
</body>
</html>
