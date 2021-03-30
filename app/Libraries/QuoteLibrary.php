<?php //defined('BASEPATH') OR exit('No direct script access allowed');

  namespace App\Libraries;

  class QuoteLibrary {

    function getCleanName($fullname)
    {
      // Verify that the name is separated by dashes
      $queryName = strpos($fullname, ' ') ? str_replace(' ', '-', $fullname) : $fullname;
      // Verify that the name is lower case
      $queryName = strtolower($queryName);

      return $queryName;
    }

    function getKeyName($fullname, $key, $type = 'redis')
    {
      if($type == 'redis') return $fullname . '-' . $key;
      if($type == 'rabbitmq') return $key . '*' . $fullname;
      return $fullname;
    }

    function processQuote($quote)
    {
      //if(isset(SHOUT_QUOTE) && !SHOUT_QUOTE) return $quote;

      $quote = str_replace("’", "´", $quote);

      // Transform to uppercase
      $quote = strtoupper($quote);

      // Remove the last letter if there is a punctuation mark
      $removableSymbols = ['!', ',', '.', ';', ':'];
      $lastLetter = substr($quote, -1);
      if(in_array($lastLetter, $removableSymbols)) $quote = substr($quote, 0, -1);

      // Append the exclamation mark
      $quote .= '!';

      return $quote;
    }

  }
