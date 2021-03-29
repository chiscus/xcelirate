<?php

function show_json_error($message, $status_code = 500, $status_message = '')
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
