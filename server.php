<?php 
require_once __DIR__.'/vendor/autoload.php';

use Workerman\Worker;
use PHPSocketIO\SocketIO;

$uidmap = array();

$io = new SocketIO(3120);

$io->on('connection', function($socket)use($io) {
	$socket->on('login', function($uid)use($socket, $io) {
		global $uidmap;

		if(isset($socket->uid)) {
			return;
		} else {
			$uid = (string) $uid;

			if(!isset($uidmap[$uid])) {
				$uidmap[$uid] = 0;
			}

			$uidmap[$uid]++;

			// 加入群組
			$socket->join($uid);

			$socket->uid = $uid;
			
			//echo $socket->uid.PHP_EOL;	
		}		
	});

	$socket->on('device msg', function($data)use($io) {
		global $uidmap;
		
		extract(json_decode($data, true));

		if($to) {
			$io->to($to)->emit('new msg', $content);
		} else {
			$io->emit('new msg', $data);	
		}		
	});


	$socket->on('disconnect', function()use($socket) {
		if(isset($socket->uid)) {
			return;
		} else {
			global $uidmap;

			if(--$uidmap[$socket->uid] <= 0) {
				unset($uidmap[$socket->uid]);
			}
		}
	});
});

// 訪問此 port 可向客戶端推播
$io->on('workerStart', function()use($io) {
	$inner_worker = new Worker('http://0.0.0.0:9191');
	
	// 客戶端發送資料時觸發事件
	$inner_worker->onMessage = function($connection, $data)use($io) {
		global $uidmap;

		if(isset($_GET['content'])) {
			$_GET['content'] = htmlspecialchars($_GET['content']);
			$to = @$_GET['to'];
			
			if($to) {
				$io->to($to)->emit('new msg', $_GET['content']);
			} else {
				$io->emit('new msg', $_GET['content']);
			}

			if($to && !isset($uidmap[$to])) {
				return $connection->send('offline');
			} else {
				return $connection->send('ok');
			}

		} else {
			return $connection->send('fail, $_GET["content"] not found');
		}		
	};

	$inner_worker->listen();
});

Worker::runAll();