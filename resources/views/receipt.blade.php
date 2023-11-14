    <div id="invoice-POS" style="box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);padding: 2mm;margin: 0 auto;width: 70mm;background: #FFF;">
      <center id="top">
        <div class="info" style="display: block;margin-left: 0;"> 
          <h2 style="font-size: 0.9em;">{{$trans->companyname}}</h2>
        </div><!--End Info-->
      </center><!--End InvoiceTop-->
    
      @if ($trans->statusid == 7)
        <h6 style="border-bottom: 1px solid #EEE;">Notifikasi Pembayaran Berhasil</h6>
      @else
        <h6 style="border-bottom: 1px solid #EEE;">Tagihan</h6>
      @endif
      
      <div id="mid" style="border-bottom: 1px solid #EEE;min-height: 80px;">
        <div class="info" style="display: block;margin-left: 0;">
          <h2 style="font-size: 0.9em;">Detail Pelanggan</h2>
          <table cellspacing="10" cellpadding="0" style="margin-bottom:10px; font-size: 0.7em;color: #666;line-height: 1.2em;">
            <tr>
                <td>Nama </td>
                <td> : {{$trans->nama}}</td>
            </tr>
            <tr>
                <td>Alamat </td>
                <td> : {{$trans->alamatSingkat}}</td>
            </tr>
            <tr>
                <td>Jatuh Tempo </td>
                <td> : {{Carbon\Carbon::parse($trans->jatuhTempoTagihan)->format('Y-m-d')}}</td>
            </tr>
            <tr>
                <td>Invoice No </td>
                <td id="transGR"> : {{$trans->notrans}}</td>
            </tr>
            {{-- <tr>
                <td>Angsuran </td>
                <td> : {{$trans->angsuran}}/~</td>
            </tr> --}}
            <tr>
                <td>Pembayaran </td>
                <td> : <span id="pembayaranRecipt">{{$trans->paymentname}}</span></td>
            </tr>
        </table>
        </div>
      </div><!--End Invoice Mid-->
      
      <div id="bot" style="border-bottom: 1px solid #EEE;min-height: 50px;">
            <div id="table">
              <table style="width: 100%;border-collapse: collapse;">
                <tr class="tabletitle" style="font-size: 0.8em;background: #EEE;">
                  <td class="item" style="width: 24mm;"><h2 style="font-size: 0.9em;">Desc</h2></td>
                  <td class="Hours"><h2 style="font-size: 0.9em;">Qty</h2></td>
                  <td class="Rate"><h2 style="font-size: 0.9em;">Sub Total</h2></td>
                </tr>
    
                <tr class="service" style="border-bottom: 1px solid #EEE;">
                  <td class="tableitem"><p class="itemtext" style="font-size: 0.7em;color: #666;line-height: 1.2em;">{{$trans->text}}</p></td>
                  <td class="tableitem"><p class="itemtext" style="font-size: 0.7em;color: #666;line-height: 1.2em;">1</p></td>
                  <td class="tableitem"><p class="itemtext" style="font-size: 0.7em;color: #666;line-height: 1.2em;">{{number_format($trans->Amount)}}</p></td>
                </tr>
    
                <tr class="tabletitle" style="font-size: 0.8em;background: #EEE;">
                  <td></td>
                  <td class="Rate"><h2 style="font-size: 0.9em;">Denda</h2></td>
                  <td class="payment"><h2 style="font-size: 0.9em;">{{number_format($trans->SLateFee)}}</h2></td>
                </tr>
    
                <tr class="tabletitle" style="font-size: 0.8em;background: #EEE;">
                  <td></td>
                  <td class="Rate"><h2 style="font-size: 0.9em;">Total</h2></td>
                  <td class="payment"><h2 style="font-size: 0.9em;">{{number_format($trans->Amount)}}</h2></td>
                </tr>
    
              </table>
            </div><!--End Table-->
    
            <div id="legalcopy" style="margin-top: 5mm;">
              {!! QrCode::size(30)->generate($trans->notrans) !!}
              <p class="legal" style="font-size: 0.7em;color: #666;line-height: 1.2em;">
                @if (isset($type))
                <br>Simpan email ini sebagai referensi transaksi anda, Terimakasih telah bertransaksi di aplikasi sisbilling.
                @else
                <strong>Terima kasih!</strong>
                <br> atas kepercayaan Anda dalam menggunakan layanan kami. 
                @endif
              </p>
            </div>
    
          </div><!--End InvoiceBot-->
    </div><!--End Invoice-->
    @if (isset($type))
    <strong>Email ini dikirimkan secara otomatis. Mohon tidak membalas email ini.</strong>
    @endif
    <script>
      // downloadReceipt()
      // function downloadReceipt() {
      //   const data = document.getElementById('invoice-POS');
      //   // console.log(data);
      
      //   html2canvas(data).then((canvas) => {
      //     // Few necessary setting options
      //     const imgWidth = 208;
      //     const pageHeight = 295;
      //     const imgHeight = canvas.height * imgWidth / canvas.width;
      //     const heightLeft = imgHeight;
      
      //     const contentDataURL = canvas.toDataURL('image/png');
      //     const pdf = new jspdf('p', 'mm', 'a4'); // A4 size page of PDF
      //     const position = 0;
      //     pdf.addImage(contentDataURL, 'PNG', 0, position, imgWidth, imgHeight);
      //     pdf.save('ikismail.pdf'); // Generated PDF
      //   });
      // }
      
      // Panggil fungsi downloadReceipt() saat halaman dimuat (opsional)
      // window.onload = downloadReceipt;
      </script>
      