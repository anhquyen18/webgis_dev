<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Email</title>
    <link href="{{ asset('node_modules/@fortawesome/ontawesome-free/css/fontawesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://kit.fontawesome.com/aa99f25d07.js" crossorigin="anonymous"></script>

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

    .reset-button {
        margin: 2rem;
        padding: 10px 30px;
        font-weight: bold;
        background-color: #1c8092;
        color: white;
    }

    .reset-button:hover {
        cursor: pointer;
    }
</style>

<body style="text-align: center; color: white; ">
    <h1 class="email-header" style="background-color: #222222; padding: 0.3rem;">PAIWebGIS</h1>
    <div class="email-body" style="background-color: #313131; padding: 2rem;">
        <h2 style="margin-bottom: 1rem">{{$myName}},</h2>
        <p>There was recently a request to change the password for your account.</p>
        <p style="margin-top: 0.5rem;">If you requested this password change, please reset your password here:</p>
        <a id="myLink" href="{{ $link }}"><Button class="reset-button">RESET PASSWORD</Button></a>
        <p>Please do not share this link with anyone.</p>
        <p>If you did not make this request, you can ignore this message and your password will remain the same.</p>

    </div>

    <div class="email-footer" style="background-color: #222222; padding-top: 2rem; padding-bottom: 1rem;">
        <p style="margin: 2rem; font-size: 1.5rem;">Thank you, Pai!</p>
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


</body>



</html>