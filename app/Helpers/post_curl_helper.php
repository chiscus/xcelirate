<?php
  function postCURL($_url, $_param){
    var_dump($_SERVER['SERVER_NAME']);
    $client = new GuzzleHttp\Client();
    $response = $client->request('POST', $_SERVER['SERVER_NAME'].'/sender', [
      'form_params' => [
          'field_name' => 'abc',
          'other_field' => '123',
          'nested_field' => [
              'nested' => 'hello'
          ]
      ]
    ]);
    var_dump($response);
}
