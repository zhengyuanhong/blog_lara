<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bootstrap 实例 - 基本的表格</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div>
    @foreach($items as $item)
        <p>{{$item->installment->pingtai}}平台第{{$item->sequence}}期还款</p>
        <ol>
            <li>平台：{{$item->installment->pingtai}}</li>
            <li>消费金额：{{$item->installment->price}}元</li>
            <li>消费项目：{{$item->installment->name}}</li>
            <li>分 期 数：{{$item->installment->base}}期</li>
            <li>还款数目：{{$item->fee}}元</li>
        </ol>
    @endforeach
    <p>总共{{$total}}元</p>
    <p>转账账号</p>
    <ol>
        <li>微      信：好友转账</li>
        <li>支  付  宝：14770951192</li>
        <li>建设银行卡：6236682100001707329</li>
    </ol>
</div>
</body>
</html>
