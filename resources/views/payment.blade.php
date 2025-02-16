<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aqarcom</title>
    <!-- Moyasar Styles -->
    <link rel="stylesheet" href="https://cdn.moyasar.com/mpf/1.7.3/moyasar.css">
    <style>
        .mysr-form{
            margin-top:15px !important; ;
        }
    </style>
    <!-- Moyasar Scripts -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=fetch"></script>
    <script src="https://cdn.moyasar.com/mpf/1.7.3/moyasar.js"></script>
</head>
<body class="body">
    <div class="mysr-form"></div>
    <script>
        Moyasar.init({
            element: '.mysr-form',
            amount: {{$amount * 100}},
            currency: 'SAR',
            description: 'Aqarcom Payment Process For User ID {{request()->user_id}}',
            // publishable_api_key: 'pk_test_2qLumuqsTWQbwmvMXaYF6MLmLpw3JSzSSuid3KZ2',
            publishable_api_key: 'pk_live_nE1Xh3Gskr2KtKDcCsdk9pDoQvNBkaEfTfcP5wgu',
            callback_url: '{{$url}}',
            methods: ['creditcard' , 'applepay' , 'stcpay'],
            apple_pay: {
                country: 'SA',
                label: 'Aqarcom',
                validate_merchant_url: 'https://api.moyasar.com/v1/applepay/initiate',
            },
        });
        document.addEventListener('contextmenu', event=> event.preventDefault());
        document.onkeydown = function(e) {
            if(e.keyCode === 123) {
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
                return false;
            }
            if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
                return false;
            }
        }
    </script>
</body>
</html>
