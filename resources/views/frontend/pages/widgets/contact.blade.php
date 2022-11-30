@extends('frontend.layouts.master')

@section('frontendtitle') Contact Page @endsection

@section('front_content')
   @include('frontend.layouts.inc.breadcrumb', ['pagename' => 'contact'])

<!-- contact-area start -->
<div class="google-map">
<div class="contact-map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7496149.367987175!2d85.84660245692535!3d23.452196207301743!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30adaaed80e18ba7%3A0xf2d28e0c4e1fc6b!2sBangladesh!5e0!3m2!1sen!2sbd!4v1669823182747!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
</div>
<div class="contact-area ptb-100">
<div class="container">
<div class="row">
<div class="col-lg-8 col-12">
  <div class="contact-form form-style">
      <div class="cf-msg"></div>
      <form action="http://themepresss.com/tf/html/tohoney/mail.php" method="post" id="cf">
          <div class="row">
              <div class="col-12 col-sm-6">
                  <input type="text" placeholder="Name" id="fname" name="fname">
              </div>
              <div class="col-12  col-sm-6">
                  <input type="text" placeholder="Email" id="email" name="email">
              </div>
              <div class="col-12">
                  <input type="text" placeholder="Subject" id="subject" name="subject">
              </div>
              <div class="col-12">
                  <textarea class="contact-textarea" placeholder="Message" id="msg" name="msg"></textarea>
              </div>
              <div class="col-12">
                  <button id="submit" name="submit">SEND MESSAGE</button>
              </div>
          </div>
      </form>
  </div>
</div>
<div class="col-lg-4 col-12">
  <div class="contact-wrap">
      <ul>
          <li>
              <i class="fa fa-home"></i> Address:
              <p>1234, Contrary to popular Sed ut perspiciatis unde 1234</p>
          </li>
          <li>
              <i class="fa fa-phone"></i> Email address:
              <p>
                  <span>info@yoursite.com </span>
                  <span>info@yoursite.com </span>
              </p>
          </li>
          <li>
              <i class="fa fa-envelope"></i> phone number:
              <p>
                  <span>+0123456789</span>
                  <span>+1234567890</span>
              </p>
          </li>
      </ul>
  </div>
</div>
</div>
</div>
</div>
<!-- contact-area end -->


@endsection
