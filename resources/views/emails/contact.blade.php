<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <p>お問い合わせを受け付けました。</p>
    
    <p><strong>お名前：</strong> {{ $contactData['sender_name'] }}</p>
    <p><strong>メールアドレス：</strong> {{ $contactData['sender_email'] }}</p>
    
    <p><strong>お問い合わせ内容：</strong></p>
    <p>{{ $contactData['message'] }}</p>
</body>
</html>
