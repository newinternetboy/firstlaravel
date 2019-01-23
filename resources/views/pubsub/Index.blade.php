<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

</body>
<script>
    var ws = new WebSocket("ws://47.93.247.110:8100");
    ws.onopen = function (event) {
        ws.send("client request connect");
    }
    //接受服务器的消息
    ws.onmessage = function (event) {
        console.log('client received data from websocket server',event.data);
    }

    //websocket 客户端关闭
    ws.onclose = function (event) {
        console.log("client has closed.\n",event)
    }
</script>
</html>