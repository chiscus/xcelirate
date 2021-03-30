<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class MessagesenderController extends ResourceController
{
	public function store()
	{
		$data = $this->request->getVar('message');

		$result = explode('*', $data);

		if (!$cachedData = cache($result[0])){
    	cache()->save($result[0], json_decode($result[1]), 300);
		}

		return $result[0];
	}
}
