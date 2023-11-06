@extends('layout.blank')
@section('content')
<button onclick="window.location.href='{{url('/')}}'" class="btn btn-primary m-3" style="padding:5px 10px 5px 5px; border-radius:100%;"><i class="las la-backspace" style="font-size: 40px;"></i></button>
    <div class="container" style="padding-bottom: 15vh;"> 
        <form class="container" style="margin-top:8vh; z-index:3;" method="POST" action="{{url('register')}}">
            @csrf
            <center>
                <div style="max-width: 500px">
                    <h3>Pengguna Baru</h3>
                    <div class="form-outline mt-4">
                        <input value="{{ old('nama') }}" name="nama" type="text" id="displayRegister_Nama" class="form-control @error('nama') is-invalid @enderror" required />
                        <label class="form-label" for="displayRegister_Nama">Nama</label>
                      </div>
                      @error('nama')
                          <div class="alert alert-danger mt-3">{{ $message }}</div>
                      @enderror
                    <div class="form-outline mt-3">
                        <input value="{{ old('email') }}" name="email" type="email" id="displayRegister_email" class="form-control @error('email') is-invalid @enderror" required/>
                        <label class="form-label" for="displayRegister_email">Email</label>
                      </div>
                      @error('email')
                          <div class="alert alert-danger mt-3">{{ $message }}</div>
                      @enderror
                      <div class="row" style="margin:0;">
                          <div class="form-outline col mt-3">
                              <input name="otp" type="text" id="displayRegister_otp" class="form-control" autocomplete="off"/>
                              <label class="form-label" for="displayRegister_otp">Email OTP</label>
                          </div>
                          <div style="width: 5px;"></div>
                          <button type="button" id="sendotp" class="btn btn-primary mt-3" style="width: 39px; height:39px;padding:0;">
                            <img width="18" height='18' src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAACXBIWXMAAAsTAAALEwEAmpwYAAAEdUlEQVR4nO2aTW/TWBSGLdggVsOSDWKFRpo/gBBL+A1sWLNlx441rNDsoapACNQWcCFVStqkJpA2bXHrxl83uLHDR1WVxmZgpEGiaDjIgbSJ61zf61x/xO2RzqZxrvWcnuQ9fnM47jAO48CE/O7ziZqxdXVZ3njJHZQAgKOaaV/QLWdcVDa+z1UboDVaE1zWQ1t3/kKmfRNZzpZm2lB+3YT8CwTKeutHs/nvn1xWWxxZzhVkOSKyHHBzVd+CvKDD1JwGK9omINPZ5LLa4siyv3XAkWXDvPgWJmeUNnyhYrT/rln2DS5rLY52oX9l7c1HKJTrwBfkNvzDqRVApg26Zf8vinCcy1KLI09WpfcwOavswo+MLYDaaP16vWGvctlpcacnFaMFsxWjDd6Bvz1WgWXlw9411udLXBZaHHlySd6AZ0V1H3y+rO1dZ9pfuSy0OOpKt7VL1fVd8G74B0+XQTf3rtUtm+eGucWRJ1fUTZgqab7wIxMVUIztnutTp/0aRYt3Z2eomZyRfeHdXJDe9b4vLdovU7a4NztDTTe4F/5ZSdlftCS1H0K2eG/uDTU4+Lu8+7m3e96bmPZrIVscN9Tg4N2s1T/uPyNO7ZcHbHHcUBME/0ps+s8HUWs/MGlx/FATBM/P1ED3OytK7dcYtXjQUBMEP8pX28rgdxZz7ZcZt3jQUBME76akb/U9k4n2QwQtTjLUkMALS43+5w6q/VpELU4y1JDAj+dX8WeH0X45whYnHWpI4EcnFl1fr+/ZobRfN52/kWXvRA2OG2pI4N1sW1u4e4TRftX8dEo3bTNKeNxQQwrfsbZwGVr71QiLgBtqSOE71hb2XoNqv8q4CEFDDSl8j7WFSSbarzIqQtBQQwrvtbZwyey5Xx2gCCRDDQ18j7WFbX/Gz/1qiCKQDDU08F5rC5eRPPerhEUgHWpo4P2sLcxnP7rnfjWgCKRDDQ28r7WFy6if+1XfIpAPNbTwftYWVm3i8PzVriLQDDW08H7WFv7LL0bPHzX/Ob0gvf9COtTsgxfw8H2trai1nyZyJW0niv88ztqKRftJQhCaxyYL7D/zWGsrTu0PimLVuBgFPM7ail37cSEsWddZwwdZW4lof78oLqw/Zg2PtbaS1H6/mK0Yayzhg6ytxLXfG9Nl1GIFH2RtpUb7aSSQFJ7I2kqT9pNIIA08ibWVGu0nkUAaeCJrK03aHySBNPCk1laqtB8ngTTwNNZWqrS/nwTSwhNbW2nT/k48L9e3w8Df4xe/TUxLht5oDfzbYqK7frnfEoiDvzM2D/efLv/3aFpayxWVW8J8fffbWm9+OTvQr09J7voJvyXQCz/yaP7Hw5zo8IW1F7k55ZogSH/gzhmkCInu+hWrxkUX/h6/uDOel0y+VHsyJWiXAeAI7Vlhi5Dorp8obp+cfWmeYXUeeuuc0037e+q1P8qg6YTM7PmHKcLQ7/kPXIRh3PNnWYSh2vNnXoRh2POPsgip3fOPqwip2/OPK+rmp/N6w5Ziu+FhcAczfgImbNaj6l8OQQAAAABJRU5ErkJggg==">
                          </button>
                          @error('otp')
                                  <div class="alert alert-danger mt-3">{{ $message }}</div>
                          @enderror
                      </div>
                      <div class="row" style="margin:0;">
                          <div class="form-outline col mt-3">
                              <input name="password" type="password" id="displayRegister_password" class="form-control @error('password') is-invalid @enderror" required/>
                              <label class="form-label" for="displayRegister_password">Password</label>
                            </div>
                            
                          <div style="width: 5px;"></div>
                          <div class="form-outline col mt-3">
                              <input name="password2" type="password" id="displayRegister_password2" class="form-control @error('password2') is-invalid @enderror" required/>
                              <label class="form-label" for="displayRegister_password2">Confirm Password</label>
                            </div>
                            <div class="row" style="margin:0;">
                              @error('password')
                                <div class="alert alert-danger col mt-3">{{ $message }}</div>
                              @enderror
                              <div style="width: 5px;"></div>
                              @error('password2')
                                <div class="alert alert-danger col mt-3">{{ $message }}</div>
                              @enderror
                            </div>
                      </div>
                    <div class="form-outline mt-3">
                        <input value="{{ old('hp') }}" name="hp" type="tel" id="displayRegister_HP" class="form-control @error('hp') is-invalid @enderror" required/>
                        <label class="form-label" for="displayRegister_HP">HP</label>
                      </div>
                      @error('hp')
                          <div class="alert alert-danger mt-3">{{ $message }}</div>
                      @enderror
                    <div class="form-outline mt-3">
                        <input value="{{ old('alamatSingkat') }}" name="alamatSingkat" type="text" id="displayRegister_AlamatSingkat" class="form-control @error('alamatSingkat') is-invalid @enderror" required/>
                        <label class="form-label" for="displayRegister_AlamatSingkat">Alamat Singkat</label>
                      </div>
                      @error('alamatSingkat')
                          <div class="alert alert-danger mt-3">{{ $message }}</div>
                      @enderror
                    <div class="form-outline mt-3">
                      <textarea name="alamatLengkap" id="displayRegister_AlamatLengkap" class="form-control @error('alamatLengkap') is-invalid @enderror" required>{{ old('alamatLengkap') }}</textarea>
                      <label class="form-label" for="displayRegister_AlamatLengkap">Alamat Lengkap</label>
                    </div>
                    @error('alamatLengkap')
                          <div class="alert alert-danger mt-3">{{ $message }}</div>
                      @enderror
                    <div class="form-outline mt-3">
                        <textarea name="InfoTambahan" type="text" id="displayRegister_InfoTambahan" class="form-control @error('InfoTambahan') is-invalid @enderror" value="-"/>{{ old('InfoTambahan') }}</textarea>
                        <label class="form-label" for="displayRegister_InfoTambahan">Info Tambahan</label>
                      </div>
                      @error('InfoTambahan')
                      <div class="alert alert-danger mt-3">{{ $message }}</div>
                      @enderror
                    <div class="mt-4">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault"/>
                        <label class="form-check-label" for="flexSwitchCheckDefault">Terms & Conditions</label>
                    </div>
                    <button id="submitR" type="submit" class="btn btn-primary col-12 mt-3" style="z-index: 3;">Daftar</button>
                </div>
            </center>
        </form>
    </div>

    <script>
      $(document).ready(function() {
          $('body').css('background-color','transparent')
      });
      $('#sendotp').click(function(){
        var nama = $('#displayRegister_Nama').val()
        var email = $('#displayRegister_email').val()
        $.ajax({
            url: '{{url("otpSET")}}',
            type: 'GET',
            cache: false,
            data: {email,nama},
            success: function(){
              showNty("Please Check Your Email");
            }
        });
      })
      $('#submitR').click(function(e){
          var check = $('#flexSwitchCheckDefault').prop('checked');
          if(!check){
            e.preventDefault()
            showNty("Please Checked Terms & Conditions")
          }else if($('#displayRegister_otp').val() == ''){
            e.preventDefault()
            showNty("Please Input OTP")
          }
      })
      $('#flexSwitchCheckDefault').change(function(){
          var check = $(this).prop('checked');
          if(check){
              $('#submitR').prop('type','submit')
              $("#fullscreenModal").modal("show");
          }else{
              $('#submitR').prop('type','button')
          }
      })
  </script>

    <!-- Modal -->
<div class="modal fade" id="fullscreenModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">TCS and Privacy Policy SisBilling</h5>
          <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="p-3">
                <h5>INTRODUCTION</h5>
                <p>PT Graha Kreasi Solusindo, is a limited liability company established under the laws of the Republic of Indonesia domiciled in Batam City, Riau Islands Province, Indonesia. Hereinafter referred to as "SisBilling", "We" or “Us”. Customer, is every single user of SisBilling Services either in the form of an individual / business entity or other legal entity subject to the laws of the Republic of Indonesia. Hereinafter referred to as "Customer" or “You". These Terms and Conditions of Service and Privacy Policy govern the relationship between PT Graha Kreasi Solusindo and the Customer. Hereinafter referred to as "Terms and Conditions of Service" and “Privacy Policy”.</p>
                <p>Every prospective SisBilling Customer is required to read and understand each of these Terms and Conditions of Service and Privacy Policy carefully. By registering an account on the <a href="https://SisBilling.gks.co.id/" target="_blank">SisBilling.gks.co.id</a> site, you are deemed to have read, understood, accepted, agreed and stated that you are willing and bound by the applicable Terms and Conditions of Service and Privacy Policy.</p>
                <p>If the Customer who registers an Account is a Representative of another Customer, then the Representative agrees to these Terms and Conditions of Service and Privacy Policy on behalf of the Customer and guarantees that he is an authorized Representative of the Customer so that he/she has the right and authority to act by and on behalf of the Customer including but not limited to the statement of the Customer's attachment to these Terms and Conditions of Service and Privacy Policy.</p>
    
                <h5>GENERAL CONDITIONS</h5>
                <p><b>Definition</b></p>
                <p>Account is a collection of data from Customer who registered to use SisBilling services. Customer are individuals, legal entities or other organizations, who registered to use the Service. Service Fee is any type of fee arising from the use of the services. Features are all forms of facilities in the application offered by SisBilling to the Customer. Service are products provided by SisBilling in the form of providing a feature, technology, services, and other products. Service include Account, Application, Features. Website is a web portal owned and managed at the address <a href="https://SisBilling.gks.co.id/" target="_blank">SisBilling.gks.co.id</a> or other sites managed by Us and may be changed from time to time. Representative is a user who has the capacity to represent the account owner. Package is a set of modules and features in the services that can be selected according to your needs.</p>
    
                <h5>ACCOUNT REQUIREMENTS</h5>
                <ol class="font-weight-bold">
                  <li>Account Registration
                    <ol type="a" class="font-weight-normal">
                      <li>You must first register an Account on our site to further use SisBilling services. Account registration is done by filling in valid personal data such as name, address, email address and other information needed in the registration form.</li>
                      <li>You guarantee that registered data is your data, it is true, accurate, up-to-date and accounted for.
                      </li>
                      <li>If you register an account ("Registrant") on behalf of an individual then you must be at least 18 years old or married and have legal capacity. If you are registering on behalf of a business entity or legal entity, the Registrant must be a Representative who legally has the capacity to act on behalf of the business entity / legal entity.</li>
                      <li>You guarantee and are obliged to be fully responsible for maintaining security and confidentiality of your Account and password. You can provide Account data to Representatives that you consider trustworthy and you are fully responsible for granting these access rights. You release SisBilling from all types of claims or lawsuits for losses suffered by you or other parties and will provide compensation for losses that may be experienced by SisBilling for misuse of your Account data and SisBilling Services by your Representative.</li>
                      <li>You are obliged to inform SisBilling if you are aware of any data breach, misuse of your Account or unauthorized use of the Account.</li>
                      <li>You must take best possible action to prevent any breach and/or misuse of your Account. When you aware of such action is happening, you must immediately reset your password. You agreed that SisBilling has the right to freeze / block / terminate the Account and access to the Service in the event of a violation and / or misuse of the Account in order to maintain the security of the Account.
                      </li>
                    </ol>
                  </li>
                  <li>Account Requirements
                    <p class="font-weight-normal">Account activation is carried out shortly after you register an Account and the Account you register will automatically have the status of a right to use. The right-to-use status means that You will have the authority to use the Account, access all Features provided and be fully responsible for all forms of information and content that You enter.</p>
                  </li>
                  <li>Use of Service
                    <ol type="a" class="font-weight-normal">
                      <li>You are responsible for all types of activities using the Service, information, data content such as graphics, images, links uploaded to the Account.</li>
                      <li>You agree that SisBilling can make additions, reductions, eliminate or change features and
                        functions in the Service to the latest version.</li>
                      <li>The customer agrees and guarantees to keep any content and information uploaded is not goods,
                        services, content and / or information that has negatively effect, such as:
                        <ol type="i" class="font-weight-normal">
                          <li>Gambling / lottery and / or betting content.</li>
                          <li>Pornography / pornographic services / items supporting sexual activities except those permitted to be traded under applicable laws in Indonesia.</li>
                          <li>Contains hate material against an individual / group / religion / race / ethnicity / age or disability.</li>
                          <li>Contains content providing access to drugs, addictive substances, and psychotropic substances;
                          </li>
                          <li>Goods / services related to sharp and explosive weapons and other objects that do not have a license to be traded.</li>
                          <li>Do not have a license to be traded in accordance with the provisions of Indonesian legislation.
                          </li>
                        </ol>
                      </li>
                      <li>You agree not to copy, duplicate, distribute, modify, reproduce, resell or exploit any part of the Service, use of the Service, source code or other content related to the Service.</li>
                      <li>You release SisBilling from any claims of loss or damage that you may incur as a result of changing or exploiting the Service or the source code of the Service.</li>
                      <li>You agree to use SisBilling Services in a reasonable manner. If SisBilling considers that there has been unreasonable use of the Service or not in accordance with the provisions in the Terms and Conditions of Service which can cause a decrease in the performance of the Service for Customers and other Customers or cause losses to SisBilling, SisBilling has the right to limit / freeze the use of the Service verbally or written notification either directly or through electronic form of communication to the Customer and if possible, SisBilling will make a notification within 1x24 hours before the restriction / freeze.</li>
                      <li>The Customer acknowledges and understands that SisBilling Services are provided as is.
                        SisBilling
                        does not guarantee that:
                        <ol type="i" class="font-weight-normal">
                          <li>Service, information, products will meet your specific needs and to your expectations.</li>
                          <li>Service will be free from interruption, error, damage, failure, theft.</li>
                          <li>Service will be accurate and reliable.</li>
                          <li>Service provided will always be free from bugs, trojans, viruses or other malicious software
                            components.</li>
                          <li>Fulfillment of Service needs in accordance with the wishes of the Customer including but not
                            limited to the availability/compatibility of devices, operating systems and Features.</li>
                        </ol>
                      </li>
                      <li>In supporting SisBilling Service, we may include links to sites or content provided or operated
                        if
                        there is involvement of third parties. SisBilling is not responsible for errors, information
                        accuracy, insults, fraud, or negatively charged content displayed or linked by third parties.
                        SisBilling and the Customer understand that third parties have their own Terms and Conditions and
                        Privacy Policy, therefore SisBilling urges Customer to check Terms and Conditions and Privacy
                        Policy
                        of third parties from time to time.</li>
                      <li>By registering and using third party services, Customer is deemed to have read, known and agreed
                        to
                        comply with each third party's Terms and Conditions and Privacy Policy.</li>
                    </ol>
                  </li>
                  <li>Term of Service
                    <ol type="a" class="font-weight-normal">
                      <li>By agreeing to these Terms and Conditions and having an activated Account according to the
                        procedure
                        that SisBilling determines, Customer can utilise the Service in accordance with the choosen
                        Package.
                      </li>
                      <li>The use of the Service is non-exclusive, non-sublicensable, non-transferable, and limited by and
                        subject to the provisions of these Terms and Conditions.</li>
                      <li>The Customer hereby acknowledges and warrants that:
                        <ol type="i" class="font-weight-normal">
                          <li>That it is Customer's responsibility to grant access to a Representative and the type of role
                            and rights they have access to including accessing your data;</li>
                          <li>That in the event of granting access to a representative, it will guarantee and be responsible
                            for granting such access, including against any legal consequences for actions taken by Invited
                            Users in connection with the Service, and therefore under no circumstances will SisBilling be
                            responsible for any disputes arising between the Customer and the Representative;</li>
                          <li>Any Usage Restrictions will remain in effect for the initial period of your Subscription Term
                            or
                            the relevant Renewal Period (as applicable). SisBilling reserves the right to change the terms
                            of
                            the Approval Usage Restrictions from time to time by providing an announcement or notice to you.
                          </li>
                        </ol>
                      </li>
                      <li>You may add or upgrade your subscription plan and by contacting SisBilling team in advance. In
                        this
                        case, SisBilling will charge you for the Access Fee corresponding to your new Subscription upgrade
                        ("New Service Fee") and you agree that the Plan, and the New Service Fee will apply going forward.
                      </li>
                      <li>The Intellectual Property Rights contained in each theme belong to SisBilling's designers.
                        SisBilling reserves the right to terminate your account, close your account, block or take other
                        legal action if you misuse the intellectual property rights.</li>
                      <li>Service
                        <ol type="i" class="font-weight-normal">
                          <li>Payment of SisBilling Service Fee can be made by direct transfer to the account of PT Graha
                            Kreasi Solusindo, </li>
                          <li>The maximum payment verification process is 1x24 hours. To speed up the payment verification
                            process, Customers can send receipts / proof of payment to the SisBilling team.</li>
                          <li>By paying the Service Fee, Customer is deemed to have known, understood and agreed with the
                            features of the Service provided. SisBilling does not warrant a refunds or reimbursements in
                            any
                            form for payments that have been made.</li>
                        </ol>
                      </li>
                      <li>Consultation Services
                        <ol type="i" class="font-weight-normal">
                          <li>SisBilling provides free consulting services to help you choose a Service package, operate
                            and
                            optimize the use of the Service, help overcome difficulties in using the Service. These
                            consulting
                            services are independent and not affiliated with any party.</li>
                          <li>Customers have their own rights in deciding whether or not to follow, choose or not, use or
                            not
                            each type of package or proposal after discussed with SisBilling team.</li>
                        </ol>
                      </li>
                      <li>Payment and Service Fee
                        <ol type="i" class="font-weight-normal">
                          <li>Payment of Service Fee
                            <ol type="1" class="font-weight-normal">
                              <li>Customer pays a fee according to the Package chosen in SisBilling.</li>
                              <li>Service Fee billing is done based on each customer's registered Account.</li>
                              <li>The Service Fee billing as intended will be billed (in the form of an invoice or
                                notification) automatically via registered email within 7 days before the active period
                                ends.
                              </li>
                              <li>Customers can immediately make payments for Service Fee billing.</li>
                            </ol>
                          </li>
                          <li>The mechanism for adding the active period is as follows:
                            <ol type="1" class="font-weight-normal">
                              <li>If there is still remaining active validity period on the Account and Customer makes
                                payment
                                for the continued Service Fee, then the remaining active validity period will accumulate
                                with
                                the new active validity period automatically so that the customer can continue to use
                                SisBilling Services in accordance with the last active period.</li>
                              <li>If the active validity period has expired and the Customer does not make payment of the
                                Advanced Service Fee, SisBilling has the right to freeze the Account until you make payment
                                of the Advanced Service Fee with a maximum waiting period of 30 (thirty) calendar days from
                                the last date of the active validity period.</li>
                              <li>If the payment waiting period has expired, SisBilling has the right to clean or delete
                                registered Account data at any time without prior notice.</li>
                            </ol>
                          </li>
                          <li>SisBilling reserves the right to calculate, add, include all additional exclusive fees
                            during the use of the Service that may arise due to requests for additional Service Features,
                            taxes, on the basis of government regulations, and/or laws and regulations.</li>
                          <li>SisBilling does not serve refunds for Service packages that you have paid for in the form of
                            any reason.</li>
                          <li>You agree that SisBilling has the right to make changes to the payment system at any time.
                          </li>
                        </ol>
                      </li>
                      <li>Changes in Payment and Service Fee
                        <ol type="1" class="font-weight-normal">
                          <li>SisBilling's prices or Service Fee may change at any time based on SisBilling's internal
                            decisions.</li>
                          <li>Customers will get indirect notification of changes in Service Fee either through the
                            <a href="https://SisBilling.gks.co.id/" target="_blank">SisBilling.gks.co.id</a> website, email, telephone contact or sms.</li>
                        </ol>
                      </li>
                      <p>Price changes are only applied to the next Service Fee payment in other words, SisBilling will not
                        bill additional fees on previous Service Fee payments that have been paid.</p>
                    </ol>
                  </li>
                  <li>Deletion, Cancellation and Freezing of Accounts
                    <ol type="a" class="font-weight-normal">
                      <li>Account Cancellation / Deletion
                        <ol type="i" class="font-weight-normal">
                          <li>Cancellation / deletion of your Account can be carried out at any time after you register the
                            Account on the SisBilling site. Account cancellation / deletion can only be done by the
                            registered Account owner and must be carried out by submitting an Account cancellation /
                            deletion to the SisBilling team. (email: <a href="mailto:supportSisBilling@gks.co.id">SupportSisBilling@gks.co.id</a>).</li>
                          <li>The Account Owner is willing to complete the required documents to SisBilling in connection
                            with the submission of Account cancellation / deletion.</li>
                          <li>In the event that the cancellation/deletion of the account is carried out before the
                            expiration of the active period, you are deemed to know and agree that the cancellation/deletion
                            of the account will cancel/delete the remaining validity period of the active account and there
                            will be no refund of the Service Fee paid in any form.</li>
                          <li>The Customer understands and agrees to the consequences of account cancellation/deletion, as
                            follows:
                            <ol type="1" class="font-weight-normal">
                              <li>Delete or terminate the Customer's rights to the Account under these Terms of Service;
                              </li>
                              <li>SisBilling can delete Account information and data stored on the SisBilling server.
                                SisBilling has no responsibility to you or any third party to provide compensation,
                                reimbursement for losses that may arise in connection with the cancellation / deletion of
                                the Account.</li>
                              <li>SisBilling has the right to reject the application for cancellation / deletion of an
                                Account if the applicant cannot complete the provisions of points ai and aii in section 5.
                                Deletion, Cancellation and Freezing of Accounts.</li>
                            </ol>
                          </li>
                        </ol>
                      </li>
                    </ol>
                  </li>
                  <li>Deletion of Account Data
                    <ol type="a" class="font-weight-normal">
                      <li>Deletion of customer account data can be carried out at any time after the customer has registered
                        an account on the SisBilling site. Deletion of account data can only be done by the account owner
                        who is registered as the owner.</li>
                      <li>Deletion of account data can only be carried out by submitting written data deletion to the
                        SisBilling support. (email: <a href="mailto:supportSisBilling@gks.co.id">SupportSisBilling@gks.co.id</a>)</li>
                      <li>SisBilling can delete account data as requested by the Customer and by submitting account data
                        deletion, the Customer is deemed to have understood and agreed to the consequences that may arise
                        such as:
                        <ol type="i" class="font-weight-normal">
                          <li>Account data that has been deleted cannot be reinstated.</li>
                          <li>Account deletion errors requested by the owner are not the responsibility of SisBilling.</li>
                          <li>SisBilling has no responsibility to the Customer or any third party to provide compensation,
                            compensation for losses that may arise in relation to the deletion of account data.</li>
                        </ol>
                      </li>
                      <li>SisBilling has the right to request documents as proof of Account ownership to the Customer at
                        any time needed.</li>
                      <li>The Customer agrees and has the obligation to back up / duplicate / recap / store / release / copy
                        account data or before submitting the deletion of account data. The Customer agrees to release
                        SisBilling from the responsibility of procuring account data again shortly after it is deleted.
                      </li>
                      <li>SisBilling has the right to reject the submission of account data deletion or if the applicant
                        cannot fulfill the provisions a, b and d in the provisions of section 5. Deletion of Account Data.
                      </li>
                    </ol>
                  </li>
                  <li>Prohibition
                    <p class="font-weight-normal">You agree that you are prohibited to:</p>
                    <ol type="a" class="font-weight-normal">
                      <li>Infringing the Property and Intellectual Rights of SisBilling or third parties in connection with
                        the use of the Service;</li>
                      <li>Use SisBilling's Service in a manner that could damage, disable, overburden, defect or weaken
                        SisBilling's systems and security or intervene with other Customers;</li>
                      <li>Access or register using bots or other automated methods;</li>
                      <li>Investigate any promotion to anyone of the Services provided by SisBilling;</li>
                      <li>Copy, duplicate / duplicate, distribute, change, create derivatives, resell or exploit parts of
                        the Service, use of the Service, source code (source code) or other content related to the Service.
                      </li>
                      <li>Using SisBilling Service by presenting misleading information to other parties or consumers so as
                        to cause harm to other parties.</li>
                    </ol>
                  </li>
                </ol>
    
                <h5>RIGHTS AND LIMITATIONS OF RESPONSIBILITY</h5>
                <ol type="1" class="font-weight-bold">
                  <li>Customer Rights
                    <ol type="a" class="font-weight-normal">
                      <li>The right to choose and use SisBilling Service as needed.</li>
                      <li>The right to choose and determine the Service package or device to be used.</li>
                      <li>The right to use SisBilling Services in accordance with the validity period that has been paid.
                      </li>
                      <li>The right to get explanations and support for the use of the Service by the SisBilling team.</li>
                      <li>The right to request query data related to transaction changes (fraud) through SisBilling support
                        email. Submission of such requests can only be done with a registered email as the Owner.</li>
                    </ol>
                  </li>
                  <li>SisBilling Rights
                    <ol type="a" class="font-weight-normal">
                      <li>The right to modify or stop the Service with reason.</li>
                      <li>The right to refuse to provide the Service to anyone for any reason at any time</li>
                      <li>The right (but not the obligation) to remove any Account Content that contravenes these Terms of
                        Service.</li>
                      <li>The right to suspend or terminate the Service in the event of verbal or written harassment,
                        threats of violence or retribution against any employee, member, officer, management of SisBilling.
                      </li>
                      <li>The right to provide the Service to anyone including to your competitors by not making exclusivity
                        agreements in any particular market segment.</li>
                      <li>The right to freeze the Account after the expiration of the Service validity period.</li>
                      <li>In the event of a dispute regarding Account ownership, SisBilling has the right to request
                        documents to determine or verify account ownership. Documents can be in the form of business
                        licenses, KTP, NPWP, and other legal documents. At our sole judgment, we also have the right to
                        determine the legitimate account owner and if it cannot be determined the legitimate account owner,
                        SisBilling has the right to freeze the account.</li>
                    </ol>
                  </li>
                  <li>SisBilling Responsibility Limitation
                    <ol type="a" class="font-weight-normal">
                      <li>SisBilling shall not be liable for any damages that may arise directly or indirectly,
                        unexpectedly, specially, continuously, or typically including but not limited to damages for loss of
                        profit, use, data or loss caused by the Customer's actions related to:
                        <ol type="i" class="font-weight-normal">
                          <li>The use of the Service or the inability to use the SisBilling Service either in part or in
                            whole.</li>
                          <li>Misuse or unauthorized access to your Account or data.</li>
                          <li>Damage or loss arising from access to links including but not limited to damage by viruses,
                            spyware, malware, crashes, bugs, and/or vulnerabilities.</li>
                          <li>Third party actions on the Service.</li>
                          <li>Breach of these Terms of Service by you.</li>
                          <li>Claims for infringement of Intellectual Property Rights.</li>
                          <li>Claims for tort.</li>
                          <li>Violation / breach of promise of agreements entered into by you with other third parties.</li>
                        </ol>
                      </li>
                      <li>In any case, you are willing to be responsible for all activities using the Service through your
                        Account. You agree to indemnify SisBilling for losses that may arise against all forms of
                        liability, actions, legal proceedings, costs, charges and expenses that SisBilling may incur or
                        suffer as a result of the use or misuse of the Service from your Account.</li>
                    </ol>
                  </li>
                </ol>
    
                <h5>REPRESENTATIONS AND WARRANTIES</h5>
                <p>The Customer agrees to comply with and implement the provisions contained in these Terms of Service in
                  good faith, high professionalism and responsibility in providing the most accurate and latest data when
                  registering.</p>
    
                <h5>COMMUNICATION</h5>
                <p>The Customer agrees to give permission to Us to be able to contact you via email / telephone / SMS / or
                  other electronic media in terms of confirming registration, confirming the use of the Service, as well as
                  in terms of delivering advertisements, marketing materials, other latest information related to the
                  Service to you through the contact that you entered at the time of account registration and / or other
                  contacts from time to time.</p>
    
                <h5>PROPRIETARY RIGHTS AND INTELLECTUAL PROPERTY</h5>
                <p>SisBilling grants you a limited, non-exclusive license to the Customer to be construed as a transfer of
                  title to intellectual property rights (IPR) using the SisBilling Service. Nothing in these Terms of
                  Service shall be construed as a transfer of intellectual property rights.</p>
                <ol type="1" class="font-weight-bold">
                  <li>Intellectual Property Rights and Customer Content
                    <ol type="a" class="font-weight-normal">
                      <li>We respect the IPR owned by each Customer uploaded as content material in the use of SisBilling
                        Service therefore all uploaded content material will remain the exclusive property and
                        responsibility of each Customer.</li>
                      <li>You agree to grant SisBilling, its subsidiaries and/or affiliates the royalty-free right to use
                        the information and/or data that SisBilling obtains through your use of the Service provided that
                        you provide notice to you, aggregate and/or anonymize the information or data before using it.</li>
                      <li>You agree to grant SisBilling, its subsidiaries and/or affiliates a royalty-free, non-exclusive,
                        sublicensable right to use, reproduce, modify, adapt, publish, create derivative works from,
                        distribute, perform and publicize Your Content as long as it does not conflict with applicable laws
                        and regulations.</li>
                    </ol>
                  </li>
                  <li>SisBilling Intellectual Property Rights
                    <ol type="a" class="font-weight-normal">
                      <li>All information and data relating to SisBilling Services are the exclusive property of
                        SisBilling, therefore all copies or modifications to SisBilling become SisBilling's proprietary
                        rights. </li>
                      <li>The First Party's right to use SisBilling has the following limitations:
                        <ol type="a" class="font-weight-normal">
                          <li>The use of SisBilling by the First Party is only for the Customer's business purposes and the
                            Customer is not allowed to transfer, either sell or rent the use of SisBilling to other
                            parties, including giving or allowing the use of SisBilling to or by other parties.</li>
                          <li>The Customer has the obligation to protect the copyright of SisBilling. </li>
                        </ol>
                      </li>
                      <li>You are not allowed to reproduce, duplicate, disseminate and use the results of work in the form
                        of products and / or services, slogans, images, photos, SisBilling logos or reproduce, duplicate,
                        disseminate, make derivatives of SisBilling Services including but not limited to source code for
                        commercial purposes without agreement or written consent from SisBilling.</li>
                      <li>You are only allowed to use SisBilling Content for purposes that are true, not misleading, not
                        for the purpose of deception to other parties and do not conflict with these Terms of Service and
                        applicable laws and regulations in the Republic of Indonesia. Justified purposes such as:
                        introducing, promoting, providing testimonials to other parties through any media. The use as
                        referred to above, must first be informed and approved by us.</li>
                      <li>If the Customer violates SisBilling's copyright and license, then we have the right to terminate
                        this Agreement unilaterally, terminate the right to use SisBilling along with its backup and claim
                        all losses arising from the misuse of this copyright and license.</li>
                    </ol>
                  </li>
                </ol>
    
                <h5>PRIVACY POLICY</h5>
                <p>SisBilling collects e-mail addresses from people who send e-mails. We also collect information about
                  what pages users access and information provided to Us by users through surveys and site registrations.
                  Such information may contain personal data about you including your address, phone number, etc.
                  SisBilling protects information in accordance with security standards. SisBilling protects information
                  in accordance with security standards. We are not allowed to disclose personal information without your
                  written permission. However, certain information collected from you and about you is used in the context
                  of providing our services to you. The information we collect is not shared, sold or rented to others,
                  except in certain circumstances and where the use of such information is deemed to have obtained valid
                  consent to disclose the following:</p>
                <ol type="a" class="font-weight-normal">
                  <li>SisBilling may share personal information in order to investigate, prevent, or take action related to
                    illegal activity, suspected fraud, situations involving possible threats to the physical safety of any
                    person, violations of SisBilling's terms of use, or as otherwise required by law.</li>
                  <li>SisBilling may employ other companies to perform tasks on our behalf and may need to share your
                    information with them to provide products and services to you.</li>
                  <li>We will transfer information about you if SisBilling is transferred to another company. In this case,
                    SisBilling will notify you by email or by placing a prominent notice on the SisBilling website before
                    information about you that has already been transferred becomes subject to a different privacy policy.
                  </li>
                </ol>
    
                <b>What we do with your information</b>
                <ol type="a" class="font-weight-normal">
                  <li>The term ''Personal Information'' as used herein is defined as any information that identifies or can
                    be used to identify, contact or locate the person to whom the information pertains. The personal
                    information we collect will be subject to this Privacy Policy, as amended from time to time.</li>
                  <li>When you register for SisBilling we ask for your name, company name and email address and you
                    indicate your willingness to provide such information when you join our Service.</li>
                  <li>SisBilling uses the information we collect for the following general purposes: product and Service
                    provision, billing, identification and authentication, Service improvement, contact, and research.</li>
                  <li>As part of the transactional process on SisBilling, You will obtain email addresses and/or shipping
                    addresses from your customers. You agree that, with respect to Personal Information of other users that
                    you obtain through SisBilling or through SisBilling related communications or SisBilling facilitated
                    transactions, SisBilling hereby grants to you a license to use such information only for commercial
                    communications for which you are responsible without involving SisBilling. SisBilling does not
                    tolerate spam. Therefore, notwithstanding the foregoing, you are not allowed to add the name of someone
                    who has transacted with you, to your email list (email or physical mail) without their consent.</li>
                </ol>
                <b>Safety Information</b>
                <p>The security of your personal information is very important to us. When you enter sensitive information
                  in our registration form, we encrypt the transmission of information using secure socket layer technology
                  (SSL), but nothing is 100% and the way you use your information will matter. While we strive to use
                  commercially acceptable means to protect your personal information, we cannot guarantee absolute security.
                  If you have any questions about security on our Web site, you can email Us at <a href="mailto:supportSisBilling@gks.co.id">SupportSisBilling@gks.co.id</a>
                </p>
                <p>Disclosures</p>
                <ol type="a" class="font-weight-normal">
                  <li>SisBilling may use third party service providers to provide certain services to you and we may share
                    personal information with those service providers. We require companies that may share personal
                    information to protect that data consistently with this policy and to limit the use of that personal
                    information to the performance of services for SisBilling.</li>
                  <li>SisBilling may disclose personal information in special situations, such as to comply with a court
                    order requiring Us to do so or when your actions violate the Terms of Service.</li>
                  <li>We do not sell or provide personal information to other companies to market their own products or
                    services.</li>
                </ol>
                <b>Cookies</b>
                <p>Cookies are small amounts of data, which may include an anonymous unique identifier. Cookies are sent to
                  your browser from a website and stored on your computer's hard drive. Each computer that accesses our
                  website is assigned a cookie to store the information.</p>
                <b>Google Analytics and Marketing</b>
                <p>We may use a service provided by Google called Google Analytics (GA). GA allows Us to reach people who
                  have previously visited our site, and show them relevant ads when they visit other sites on the Internet
                  within the Google Display Network. Cookies may be used to track your sessions on our website, to serve
                  customized ads from Google and other third-party vendors. When you visit this site, you may see
                  advertisements posted on the site by Google or other third parties. Through first-party and third-party
                  cookies, these third parties may collect information about you when you visit this and other sites. They
                  may use this data to display advertisements on this site and across the Internet based on your prior
                  visits to this website and elsewhere on the Internet. We do not collect this information or control the
                  content of the ads you will see. You may be able to opt out of customized Google Display Network ads by
                  visiting Ad Preferences (http://www.google.com/ads/preferences/), and the Google Analytics Opt-out Browser
                  Add-on (http: //www.google.ca/ads/preferences/plugin/). Your use of this site without opting out means
                  that you understand and consent to the collection of data to provide you with remarketing advertising
                  using GA and cookies from other third party vendors based on your prior visits to this website and
                  elsewhere on the Internet.</p>
                <b>Changes to this Privacy Policy</b>
                <p>We reserve the right to change this privacy statement at any time, so you are advised to review the
                  changes frequently. If we make any material changes to this policy, we will notify you here or by way of a
                  notice on our homepage so that you are aware of what information we collect and how we use it.</p>
    
                <h5>CHANGE OF TERMS</h5>
                <p>SisBilling has the right to make a change / revision / update these Terms of Service at any time from
                  time to time and will take effect from the date of publication. Notification of any changes to these Terms
                  of Service will be published on our website or through other media deemed necessary. We urge all
                  SisBilling Customers to periodically check this page to see the changes as referred to in the Changes to
                  the Terms. By continuing to use SisBilling Services, you are deemed to agree and will follow the changes
                  to the applicable Terms of Service.</p>
    
                <h5>GOVERNING LAW AND DISPUTE RESOLUTION</h5>
                <ol type="1" class="font-weight-normal">
                  <li>Any problems or disputes that arise in the future, the Customer agrees to resolve by deliberation to
                    reach consensus and is subject to the provisions and laws in force in Indonesia.</li>
                  <li>If such deliberative settlement fails to reach an agreement within a period of 30 (Thirty) calendar
                    days since the dispute arose, the Customer agrees to submit the dispute settlement through the District
                    Court at Batam City. The Customer agrees that the decision of the Court shall be Final and Binding.
                  </li>
                  <li>For all these matters with all its consequences, the Customer chooses a permanent and general legal
                    domicile at the Registrar's Office of the District Court at Batam City.</li>
                </ol>
                <h5>CUSTOMER SERVICE</h5>
                <ol type="1" class="font-weight-normal">
                  <li>You can ask questions, provide input, submit complaints related to SisBilling Services according to
                    your needs with the aim of consultation/assistance/complaints/technical questions:
                    <a href="mailto:supportSisBilling@gks.co.id">SupportSisBilling@gks.co.id</a></li>
                  <li>You agree that SisBilling has the right to verify and process the submission of questions or input
                    and / or complaints submitted by the Customer and SisBilling has the right to refuse to process the
                    questions / input and / or complaints that you submit in the event that the data is not verified based
                    on the Customer data stored in the SisBilling database or at SisBilling's internal discretion.</li>
                </ol>
              </div>
        </div>
      </div>
    </div>
  </div>

    <img src="{{asset('public/wave.svg')}}" style="bottom:0; position: fixed; z-index:-1;">

@endsection
