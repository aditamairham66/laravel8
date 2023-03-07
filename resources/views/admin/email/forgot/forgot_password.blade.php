<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        *{margin: 0;padding: 0;}
        .box-email .box-email-head {
            display: block;
            padding: 48px 0;
        }
        .box-email .box-email-head .image {
            display: block;
            margin: 0 auto;
            width: 170px;
            height: 47.51px;
        }
        .box-email .box-email-head .image img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .box-email .box-email-body {
            padding: 60px 80px;
        }
        .box-email .box-email-bottom {
            padding: 16px;
            background: #000000;
            font-style: normal;
            font-weight: 400;
            font-size: 15px;
            line-height: 22px;
            text-align: center;
            color: #EDEDED;
        }
        .title {
            font-style: normal;
            font-weight: 800;
            font-size: 34px;
            line-height: 48px;
            letter-spacing: -0.0944444px;
            color: #3A3335;
            margin-bottom: 24px;
        }
        .caption {
            font-style: normal;
            font-weight: 400;
            font-size: 15px;
            line-height: 20px;
            letter-spacing: 0.01em;
            color: #000000;
            margin-bottom: 24px;
        }
        .caption a {
            color: #456D44!important;
        }
        .otp {
            font-weight: 800;
            font-size: 25px;
            line-height: 20px;
            letter-spacing: 0.01em;
            color: #000000;
            margin-bottom: 24px;
        }

        @media only screen and (max-device-width: 601px) {
            .box-email .box-email-bottom {
                font-size: 17px;
            }
            .title {
                font-size: 25px;
            }
            .caption {
                font-size: 17px;
            }
        }
    </style>
</head>
<body>

<div class="box-email">
    <div class="box-email-body">
        <p class="caption">
            Hello <b>{{ $name }}</b>
        </p>
        <p class="caption">
            Here is your entry into {{ env('APP_NAME') }}:
        </p>
        <p class="otp">
            {{ $password }}
        </p>
        <p class="caption">
            Best regards, <br>
            {{ env('APP_NAME') }} Team
        </p>
    </div>
    <div class="box-email-bottom">
        Copyright ©{{ date('Y') }} Insight Unlimited. All rights reserved.
    </div>
</div>

</body>
</html>
