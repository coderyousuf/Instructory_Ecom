<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if (session()->has('message'))
        <span style="color: green">{{ session('message') }}</span>
    @endif
    <form action="{{ route('make.payment') }}" method="POST">
        @csrf
        <script
            src="https://checkout.stripe.com/checkout.js"
            class="stripe-button"
            data-key="pk_test_51M6paYE2HXRmYqRHxTqlaDmw1VVhmS4jtoaL6beWM5qJUbse0fUuf5ZkjggrjrpZbNGLHgpD1Jo0yhKxtGobGZFb00hVHFwMRz"
            data-name="Gold Tier"
            data-description="Monthly subscription"
            data-amount="1000"
            data-image="https://www.webappfix.com/storage/app/public/site-setting/SRBx2hTgEOaHdozWVR3hgPb3LTdEw9NwajD05FL2.png"
            data-currency="usd"
            data-location="bograsherpur"
            data-label="Subscribe">
          </script>
        </form>
</body>
</html>
