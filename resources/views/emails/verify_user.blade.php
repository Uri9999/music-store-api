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
        Đây là email xác nhận đăng ký tài khoản Zumi Shop. Nếu bạn không phải là người đăng ký, vui lòng bỏ qua email này. <br>
        Để xác thực tài khoản hãy click vào đường dẫn sau: <a href="{{ config('app.front_end_url') . "/auth/register/confirmation?verification_token=$verificationToken" }}">{{ config('app.front_end_url') . "/auth/register/confirmation?verification_token=$verificationToken" }}</a> <br>
        (Đường dẫn có hiệu lực đến {{ $expiresAt }})
    </div>
</body>
</html>