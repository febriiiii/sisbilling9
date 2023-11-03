<!-- resources/views/emails/custom_email.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <style>
        /* Gaya CSS untuk tampilan email */
        .plan {
            border-radius: 16px;
            padding: 10px;
            background-color: #e6f1ec;
            color: #697e91;
            min-width: 300px;
        }

.plan strong {
  font-weight: 600;
  color: #425275;
}

.plan .inner {
  align-items: center;
  padding: 0px 0 20px 20px;
  background-color: #ecf0ff;
  border-radius: 12px;
  position: relative;
}

.plan .pricing {
  width: fit-content;
  float: right;
  background-color: #bed6fb;
  border-radius: 99em 0 0 99em;
  padding: 0.625em 0.75em;
  font-size: 1.25rem;
  font-weight: 600;
  color: #425475;
}

.plan .pricing small {
  color: #707a91;
  font-size: 0.75em;
  margin-left: 0.25em;
}

.plan .title {
  font-weight: 600;
  font-size: 1.25rem;
  color: #425675;
}

.plan .title + * {
  margin-top: 0.75rem;
}

.plan .info + * {
  margin-top: 1rem;
}

.plan .features {
  display: flex;
  flex-direction: column;
}

.plan .features li {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.plan .features li + * {
  margin-top: 0.75rem;
}

.plan .features .icon {
  background-color: #1FCAC5;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  border-radius: 50%;
  width: 20px;
  height: 20px;
}

.plan .features .icon svg {
  width: 14px;
  height: 14px;
}

.plan .features + * {
  margin-top: 1.25rem;
}

    </style>
</head>
<body>
        <div class="plan">
            <div class="inner">
                <span class="pricing">
                    <span>
                        Data Request
                    </span>
                </span><br>
                <p class="title">Approval Company</p>
                <p class="info">Haloo, mohon izinkan saya untuk membuat perusaahaan. Terima kasih.</p>
                <ul class="features" style="display:inline-block">
                    
                        <?php
                            $request = json_decode($request);
                        ?>
                        <?php $__currentLoopData = $request; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <span class="icon" style="margin-right:10px;">
                                    <img width="20" height="20" src="https://img.icons8.com/ultraviolet/40/checkmark--v1.png" alt="checkmark--v1"/>
                                </span>
                                <?php
                                    $value = is_array($value)?json_encode($value):$value;
                                ?>
                                <strong style="display: inline-block;"><?php echo e($key); ?>:</strong><span style="padding-left: 1em;"><?php echo e($value); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <br>
                <a href="<?php echo e($url); ?>" style="font-weight:bold; text-decoration: none; background-color: rgb(131, 184, 231); padding:10px; margin:20px; border-radius:15px;">
                        Approve File
                </a>
            </div>
        </div>
      <center><br>
          <a style="font-size: 1.5em; font-weight:bold;" href="<?php echo e(url('/')); ?>">Sis Billing</a>
      </center>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/MailSubscribe.blade.php ENDPATH**/ ?>