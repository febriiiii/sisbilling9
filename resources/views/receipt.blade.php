{{-- <style>
    #invoice-POS {
  box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
  padding: 2mm;
  margin: 0 auto;
  width: 70mm;
  background: #FFF;
}

#invoice-POS::selection {
  background: #f31544;
  color: #FFF;
}

#invoice-POS::moz-selection {
  background: #f31544;
  color: #FFF;
}

#invoice-POS h1 {
  font-size: 1.5em;
  color: #222;
}

#invoice-POS h2 {
  font-size: 0.9em;
}

#invoice-POS h3 {
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
}

#invoice-POS p {
  font-size: 0.7em;
  color: #666;
  line-height: 1.2em;
}

#invoice-POS #top,
#invoice-POS #mid,
#invoice-POS #bot {
  border-bottom: 1px solid #EEE;
}

#invoice-POS #mid {
  min-height: 80px;
}

#invoice-POS #bot {
  min-height: 50px;
}

#invoice-POS .info {
  display: block;
  /* float: left; */
  margin-left: 0;
}

#invoice-POS .title {
  float: right;
}

#invoice-POS .title p {
  text-align: right;
}

#invoice-POS table {
  width: 100%;
  border-collapse: collapse;
}

#invoice-POS td {
  /* padding: 5px 0 5px 15px; */
  /* border: 1px solid #EEE; */
}

#invoice-POS .tabletitle {
  /* padding: 5px; */
  font-size: 0.8em;
  background: #EEE;
}

#invoice-POS .service {
  border-bottom: 1px solid #EEE;
}

#invoice-POS .item {
  width: 24mm;
}

#invoice-POS .itemtext {
  font-size: 0.7em;
}

#invoice-POS #legalcopy {
  margin-top: 5mm;
}

</style>
<div id="invoice-POS">
    
    <center id="top">
        <div>
            {!! QrCode::size(30)->generate($trans->notrans) !!}
        </div>
      <div class="info"> 
        <h2>{{$trans->companyname}}</h2>
      </div><!--End Info-->
    </center><!--End InvoiceTop-->
    
    <div id="mid">
      <div class="info">
        <h2>Detail Pelanggan</h2>
        <p> 
            Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$trans->nama}}</br>
            Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$trans->alamatSingkat}}</br>
            Jatuh Tempo&nbsp;: {{Carbon\Carbon::parse($trans->jatuhTempoTagihan)->format('Y-m-d')}}</br>
            No Trans&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$trans->notrans}}</br>
            Angsuran&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$trans->angsuran}}/~</br>
            Pembayaran : <span id="pembayaranRecipt"></span></br>
        </p>
      </div>
    </div><!--End Invoice Mid-->
    
    <div id="bot">
					<div id="table">
						<table>
							<tr class="tabletitle">
								<td class="item"><h2>Desc</h2></td>
								<td class="Hours"><h2>Qty</h2></td>
								<td class="Rate"><h2>Sub Total</h2></td>
							</tr>

							<tr class="service">
								<td class="tableitem"><p class="itemtext">{{$trans->text}}</p></td>
								<td class="tableitem"><p class="itemtext">1</p></td>
								<td class="tableitem"><p class="itemtext">{{number_format($trans->Amount)}}</p></td>
							</tr>

							<tr class="tabletitle">
								<td></td>
								<td class="Rate"><h2>tax</h2></td>
								<td class="payment"><h2>0.00</h2></td>
							</tr>

							<tr class="tabletitle">
								<td></td>
								<td class="Rate"><h2>Total</h2></td>
								<td class="payment"><h2>{{number_format($trans->Amount)}}</h2></td>
							</tr>

						</table>
					</div><!--End Table-->

					<div id="legalcopy">
						<p class="legal"><strong>Terima kasih!</strong><br> atas kepercayaan Anda dalam menggunakan layanan kami. 
						</p>
                        <center><strong style="font-size: .7em;">Graha Kreasi Solusindo</strong></center>
					</div>

				</div><!--End InvoiceBot-->
  </div><!--End Invoice--> --}}
    <div id="invoice-POS" style="box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);padding: 2mm;margin: 0 auto;width: 70mm;background: #FFF;">
    
      <center id="top" style="border-bottom: 1px solid #EEE;">
          <div>
              {!! QrCode::size(30)->generate($trans->notrans) !!}
          </div>
        <div class="info" style="display: block;margin-left: 0;"> 
          <h2 style="font-size: 0.9em;">{{$trans->companyname}}</h2>
        </div><!--End Info-->
      </center><!--End InvoiceTop-->
      
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
                <td>No Trans </td>
                <td> : {{$trans->notrans}}</td>
            </tr>
            <tr>
                <td>Angsuran </td>
                <td> : {{$trans->angsuran}}/~</td>
            </tr>
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
              <p class="legal" style="font-size: 0.7em;color: #666;line-height: 1.2em;"><strong>Terima kasih!</strong><br> atas kepercayaan Anda dalam menggunakan layanan kami. 
              </p>
                          <center><strong style="font-size: .7em;">Graha Kreasi Solusindo</strong></center>
            </div>
    
          </div><!--End InvoiceBot-->
    </div><!--End Invoice-->

    <script>
      downloadReceipt()
      function downloadReceipt() {
        const data = document.getElementById('invoice-POS');
        // console.log(data);
      
        html2canvas(data).then((canvas) => {
          // Few necessary setting options
          const imgWidth = 208;
          const pageHeight = 295;
          const imgHeight = canvas.height * imgWidth / canvas.width;
          const heightLeft = imgHeight;
      
          const contentDataURL = canvas.toDataURL('image/png');
          const pdf = new jspdf('p', 'mm', 'a4'); // A4 size page of PDF
          const position = 0;
          pdf.addImage(contentDataURL, 'PNG', 0, position, imgWidth, imgHeight);
          pdf.save('ikismail.pdf'); // Generated PDF
        });
      }
      
      // Panggil fungsi downloadReceipt() saat halaman dimuat (opsional)
      // window.onload = downloadReceipt;
      </script>
      