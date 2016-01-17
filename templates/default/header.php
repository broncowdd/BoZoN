<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>BoZoN | <?php e('Send, copy and share'); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="application-name" content="BoZoN">
<meta name="msapplication-tooltip" content="<?php e('Send, copy and share'); ?>">
<meta name="msapplication-TileImage" content="templates/default/img/logo.png">
<meta name="msapplication-TileColor" content="#0088ec">
<link rel="apple-touch-icon" href="templates/default/img/logo.png">
<link rel="shortcut icon" type="image/png" href="templates/default/img/favicon.png">
<link rel="stylesheet" type="text/css" href="templates/default/css/reset.css">
<link rel="stylesheet" type="text/css" href="templates/default/css/style.css">
<link rel="stylesheet" type="text/css" href="templates/default/css/mobile.css">
</head>

<body>
  <header>
    <p id="logo">&nbsp;</p>
    
    <div id="lang">
    <?php  
      foreach ($lang as $l=>$content){
        $class='';
        if ($_SESSION['language']==$l) $class='class="active"';
        echo '<a '.$class.' href="'.$uri.'?&amp;lang='.$l.'"><img title="" src="templates/default/img/'.$l.'.png" alt="" /></a>';
      }
    ?>
    </div>
