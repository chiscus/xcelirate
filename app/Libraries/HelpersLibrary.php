<?php //defined('BASEPATH') OR exit('No direct script access allowed');

  namespace App\Libraries;

  use PhpAmqpLib\Connection\AMQPStreamConnection;
  use PhpAmqpLib\Message\AMQPMessage;
  use App\Libraries\QuoteLibrary;

  class HelpersLibrary {

    function showJsonError($message)
    {
       $error_response = json_encode(
         array(
             'status' => FALSE,
             'error' => 'Server Error',
             'message' => $message
         )
       );

       return $error_response;
    }

    function sendQueueMessage($key, $value, $channelName){
      try {
        $quoteLibrary = new QuoteLibrary();

        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare($channelName, false, false, false, false);

        $keyName = $quoteLibrary->getKeyName(json_encode($value), $key, 'rabbitmq');

        //var_dump($keyName);

        $msg = new AMQPMessage($keyName);
        $channel->basic_publish($msg, '', $channelName);

        //if(SHOW_REDIS_MSGS) echo "Message sent!'\n";

        $channel->close();
        $connection->close();

        return true;
      } catch (\Exception $e) {
        return false;
      }
    }

  }
