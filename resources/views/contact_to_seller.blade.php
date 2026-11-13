<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <p>出品している商品「{{ $emailData['product_name'] }}」について、購入検討者からお問い合わせが届きました。</p>
    
    <p><strong>送信者名:</strong> {{ $emailData['sender_name'] }} さん</p>
    <p><strong>送信者メール:</strong> {{ $emailData['sender_email'] }}</p>
    
    <p><strong>お問い合わせ内容:</strong></p>
    <p>{{ $emailData['message_body'] }}</p>
</body>
</html>