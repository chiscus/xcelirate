<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

function message($key, $value){
  $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
  $channel = $connection->channel();

  $channel->queue_declare('redis_messages', false, false, false, false);

  $msg = new AMQPMessage($key.'*'.json_encode($value));
  $channel->basic_publish($msg, '', 'redis_messages');

  echo " [x] Message sent!'\n";

  $channel->close();
  $connection->close();

  return 0;
}
