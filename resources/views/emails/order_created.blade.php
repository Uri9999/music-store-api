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
        Đơn hàng mới từ khách hàng <b>{{$username}}</b> <br>
        Chi tiết đơn hàng, vui lòng click vào đường dẫn sau: <a href="{{ config('app.front_end_url') . '/admin/order/' . $orderId }}">{{ config('app.front_end_url') . '/admin/order/' . $orderId }}</a> <br>
    </div>
</body>
</html>