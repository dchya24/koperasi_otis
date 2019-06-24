<?php

function getRandomString($length = 6){
  $characters = "abcdefghijklmnopqrstuvwxyz";
  $charactersLength = strlen($characters);
  $random_string = "";
  for($i = 0; $i < $length; $i++){
    $random_string .= $characters[rand(0, $charactersLength - 1 )];
  }

  return $random_string;
}