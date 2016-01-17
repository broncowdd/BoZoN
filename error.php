<?php
  require __DIR__.'/common.php';
  
  $server=$_SERVER['REDIRECT_STATUS'];
  $message['401']=e('Authentication required',false);
  $message['403']=e('Access forbidden',false);
  $message['404']=e('The page or file specified does not exist',false);
  $message['500']=e('Internal server error',false);
  
  require __DIR__.'/templates/'.$template.'/error.php';
