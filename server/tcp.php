<?php
//创建 server对象 监听 127.0.0.1：9501端口
$server = new swoole_server("127.0.0.1" , 9501);

$server->set([
	'work_num' => 8, //worker 进程数 cpu 1-4
	'max_request' => 10000, //最大连接数
]);
/**
 * 监听开始事件
 */
$server->on("start", function ($server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});
/**
 * 监听连接进入事件
 * $fd 客户端连接的 唯一标志
 * $reactor_id 线程 id
 */

$server->on('connect' , function ($server , $fd , $reactor_id){
	echo "Client:{$reactor_id} - {$fd}-Connect.\n";
});

/**
 * 监听数据接收事件
 * $reactor_id 线程 id
 * $fd 客户端连接的 唯一标志
 */
$server->on('receive' , function ($server , $fd , $reactor_id , $data){
    $server->send($fd , "Server:{$reactor_id} - {$fd}内容：" . $data . "\n");
});

/**
 * 监听连接关闭事件
 */
$server->on('close' , function ($server , $fd){
    echo "Client:Close.\n";
});

//启动服务器
$server->start();