<div id="mid" style="border-bottom: 1px solid #EEE;min-height: 80px;">
    <div class="info" style="display: block;margin-left: 0;">
    <h2 style="font-size: 0.9em;">Pembayaran Menunggu Persetujuan</h2>
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
            <td>Invoice No </td>
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

<center>
    <a style="font-size: 1.5em; font-weight:bold;" href="<?php echo e(url('/')); ?>">Sis Billing</a>
</center><?php /**PATH C:\xampp\htdocs\sisbilling9\resources\views/MailPaymentaprove.blade.php ENDPATH**/ ?>