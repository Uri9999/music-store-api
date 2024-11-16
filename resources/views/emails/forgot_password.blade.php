<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        Chào bạn, <br>
        Đây là email xác nhận quên mật khẩu Zumi Shope.<br>
        Để nhận mật khẩu mới, vui lòng click vào đường dẫn sau: <a href="{{ config('app.front_end_url') . "/auth/forgot-password/confirm?token=$token&email=$email" }}">{{ config('app.front_end_url') . "/auth/forgot-password/confirm?token=$token&email=$email" }}</a> <br>
        (Đường dẫn có hiệu lực đến {{ $expiresAt }} phút)
    </div>
</body>
</html>