<?php
//连接 swoole tcp 服务

$client = new swoole_client(SWOOLE_SOCK_TCP);


if(!$client->connect("127.0.0.1" , 9501)){
    echo "连接失败!!!";
    exit;
}

//php cli 常量
fwrite(STDOUT , "请输入消息：");
$msg = trim(fgets(STDIN));

//发送消息 给 tcp server服务器
$client->send($msg);

//接收 来自server 的数据
$res = $client->recv();
echo $res;
