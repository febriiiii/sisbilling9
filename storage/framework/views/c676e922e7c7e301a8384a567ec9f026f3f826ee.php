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
            <h1>Hai <?php echo e($name); ?>,</h1>
        </div>
        <div class="content">
            <p>Berikut adalah One-Time Password (OTP) Anda:</p>
            <center>
                <h1><?php echo e($otp); ?></h1>
                <?php if(isset($hit)): ?>
                <a style="color:red;" href="<?php echo e($hit); ?>">Klik ini untuk konfirmasi</a>
                <?php endif; ?>
            </center>
            <small>
                <i style="color:red;">*Harap jangan berikan informasi ini kepada siapapun dan pastikan untuk menjaga kerahasiaan OTP ini.</i>
            </small>
        </div>
        <div class="footer">
            <strong>Email ini dikirimkan secara otomatis. Jangan membalas email ini.</strong>
            
            <center><br>
                <a style="font-size: 1.5em; font-weight:bold;" href="<?php echo e(url('/')); ?>">Sis Billing</a>
            </center>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/MailOtp.blade.php ENDPATH**/ ?>