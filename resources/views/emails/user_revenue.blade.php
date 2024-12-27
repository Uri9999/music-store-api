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
        Chào <b>{{ $username }}</b> <br>
        Tổng kết doanh thu tháng <b>{{ $month }}</b>: </br>
        Hoa hồng bài tab đã bán được: {{ $tabSumPrice }} </br>
        Hoa hồng Subscription đã giới thiệu: {{ $subscriptionSumPrice }} </br>
    </div>
</body>
</html>