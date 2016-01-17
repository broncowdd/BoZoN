<?php
  // INCLUSION DES FICHIERS PHP
  require __DIR__.'/config.php';
  
  // DEMARRAGE DE LA SUPER GLOBALE $_SESSION
  session_start();
  
  // VERSION DE LA WEBAPP
  define('VERSION','0.0.1');
	
  // LES TRADUCTIONS
  // la fonction e()
  function e($txt,$echo=true){
    global $lang;
    if (isset($lang[$_SESSION['language']][$txt])){
      $t=$lang[$_SESSION['language']][$txt];
    }else{
      $t=$txt;
    }
    
    if($echo){
      echo $t;
    }else{
      return $t;
    }
  }
  
  // démarre le tableau $lang[] avant le chargement des traductions dans le dossier 'locales'
  $lang=array();
  
  foreach (glob('locales/*.php') as $locale){
    include $locale;
  }
  
  // chargement de la langue demandée
  if(isset($_GET['lang'])){
    if(file_exists('locales/'.$_GET['lang'].'.php')) $_SESSION['language']=$_GET['lang'];
  }
  
  if(!isset($_SESSION['language']) && isset($language) && !empty($language)){
    if(file_exists('locales/'.$language.'.php')) $_SESSION['language']=$language;
  }
  
  // PAGE ACTUELLE SUR LE SERVEUR
  $uri=explode('?', $_SERVER['REQUEST_URI'], 2);
  $uri=$uri[0];
  
  //print_r($_SESSION);
