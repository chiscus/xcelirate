<?php

function process_quotes($quotesArray)
{
  foreach ($quotesArray as $key => $quoteElement) {
    // Transform to uppercase
    $quotesArray[$key]['quote'] = strtoupper($quoteElement['quote']);

    // Remove the last letter if there is a punctuation mark
    $removableSymbols = ['!', ',', '.', ';', ':'];
    $lastLetter = substr($quoteElement['quote'], -1);
    if(in_array($lastLetter, $removableSymbols)) $quotesArray[$key]['quote'] = substr($quotesArray[$key]['quote'], 0, -1);

    // Append the exclamation mark
    $quotesArray[$key]['quote'] .= '!';
  }

  return $quotesArray;
}
