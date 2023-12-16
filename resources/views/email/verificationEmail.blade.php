<!DOCTYPE html>
<html>

<head>
    <title>Verification Email</title>
    <link href="{{ asset('node_modules/@fortawesome/ontawesome-free/css/fontawesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<style>
    * {
        padding: 0;
        margin: 0;
        text-decoration: none;
    }

    .icon {
        color: grey;
        margin-right: 0.5rem;
    }
</style>

<body style="text-align: center; color: white; ">
    <h1 class="email-header" style="background-color: #222222; padding: 0.3rem;">PAIWebGIS</h1>
    <div class="email-body" style="background-color: #313131; padding: 2rem;">
        <h2 style="margin-bottom: 1rem;">Pai WebGIS Verification</h2>
        <p>You have entered your email <strong>{{$myEmail}}</strong> at Pai WebGIS to register a new account. So we can get </p>
        <p>you started, please enter the code below on the registration page:</p>
        <p style="margin:2rem; font-weight: bold; color: #1c8092; font-size: xx-large;">{{$verifyCode}}</p>
        <p>We look forward to you joining our community!</p>
        <p>If you did not attempt to register an account, please ignore this email.</p>

    </div>

    <div class="email-footer" style="background-color: #222222; padding-top: 2rem; padding-bottom: 1rem;">
        <div style="font-size: 2rem;">
            <a class="icon" href=""><i class="fa-brands fa-square-facebook"></i></a>
            <a class="icon" href=""><i class="fa-brands fa-x-twitter"></i></a>
            <a class="icon" href=""><i class="fa-brands fa-discord"></i></a>
        </div>

        <h2 style="margin: 1rem;">PAIWebGIS</h2>

        <div style="color: grey; margin: 0.5rem;">
            <small><a href="" style="color: grey;">Privacy Policy</a> | <a href="" style="color: grey;">Terms of Service</a></small>
        </div>

        <small style="color: grey;">Copyright <i class="fa-regular fa-copyright"></i> 2023 Pai Tran. All rights reserved.</small>
    </div>


    <script src="https://kit.fontawesome.com/aa99f25d07.js" crossorigin="anonymous"></script>
</body>


</html>