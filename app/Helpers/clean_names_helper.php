<?php

function clean_names($fullname)
{
  // Verify that the name is separated by dashes
  $queryName = strpos($fullname, ' ') ? str_replace(' ', '-', $fullname) : $fullname;
  // Verify that the name is lower case
  $queryName = strtolower($queryName);
  // Separate full name
  $queryName = explode('-', $queryName);

  return $queryName;
}
