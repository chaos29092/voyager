<html>
<body>
<h1>网站留言</h1>

name: {{$order->name}} <br>
Email: {{$order->email}} <br>
Phone: {{$order->phone}} <br>
Subject: {{$order->subject}} <br>
Request: {{$order->message}}<br>
url: {{$order->url}} <br>
clientId: {{$order->clientId}} <br>
Created_at:{{$order->created_at}}

</body>
</html>
