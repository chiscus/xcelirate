<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class MessagereceiverController extends ResourceController
{
	public function store()
	{
		// Receives the message from the workers
		$data = $this->request->getVar('message');

		// Separates the key and the value
		$result = explode('*', $data);

		// And stores the data if it wasn't stored before
		if (!$cachedData = cache($result[0])){
    	cache()->save($result[0], json_decode($result[1]), 300);
		}

		return $result[0];
	}
}
