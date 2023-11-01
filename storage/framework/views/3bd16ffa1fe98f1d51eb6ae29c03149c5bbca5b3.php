<div id="mid" style="border-bottom: 1px solid #EEE;min-height: 80px;">
    <div class="info" style="display: block;margin-left: 0;">
    <h2 style="font-size: 0.9em;">Pembayaran Di Tolak Pengelola</h2>
    <table cellspacing="10" cellpadding="0" style="margin-bottom:10px; font-size: 0.7em;color: #666;line-height: 1.2em;">
        <tr>
            <td>Nama </td>
            <td> : <?php echo e($trans->nama); ?></td>
        </tr>
        <tr>
            <td>Alamat </td>
            <td> : <?php echo e($trans->alamatSingkat); ?></td>
        </tr>
        <tr>
            <td>Jatuh Tempo </td>
            <td> : <?php echo e(Carbon\Carbon::parse($trans->jatuhTempoTagihan)->format('Y-m-d')); ?></td>
        </tr>
        <tr>
            <td>No Trans </td>
            <td id="transGR"> : <?php echo e($trans->notrans); ?></td>
        </tr>
        <tr>
            <td>Angsuran </td>
            <td> : <?php echo e($trans->angsuran); ?>/~</td>
        </tr>
        <tr>
            <td>Pembayaran </td>
            <td> : <span id="pembayaranRecipt"><?php echo e($trans->paymentname); ?></span></td>
        </tr>
    </table>
    </div>
</div>



<style>
    /* button */
    button {
  background: transparent;
  position: relative;
  padding: 5px 15px;
  display: flex;
  align-items: center;
  font-size: 17px;
  font-weight: 600;
  text-decoration: none;
  cursor: pointer;
  border: 1px solid rgb(40, 144, 241);
  border-radius: 25px;
  outline: none;
  overflow: hidden;
  color: rgb(40, 144, 241);
  transition: color 0.3s 0.1s ease-out;
  text-align: center;
}

button span {
  margin: 10px;
}

button::before {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
  content: '';
  border-radius: 50%;
  display: block;
  width: 20em;
  height: 20em;
  left: -5em;
  text-align: center;
  transition: box-shadow 0.5s ease-out;
  z-index: -1;
}

button:hover {
  color: #ffffff;
  border: 1px solid rgb(40, 144, 241);
}

button:hover::before {
  box-shadow: inset 0 0 0 10em rgb(40, 144, 241);
}
</style>
<center>
    <a href="<?php echo e(url('/')); ?>" style="text-decoration: none;">
        <button>
          <img style="width: 30px;height:30px; border-radius:20px;" src="<?php echo e(asset('/public/icon.png')); ?>">
          <span>Sis Billing</span>
      </button>
    </a>
</center><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/MailPaymentreject.blade.php ENDPATH**/ ?>