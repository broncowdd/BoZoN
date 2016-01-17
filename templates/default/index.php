<?php
  require __DIR__.'/header.php';
  
  if(isset($_SESSION['login']) && !empty($_SESSION['login'])){
?>
    <p id="status"><a title="<?php e('Logout'); ?>" href="?logout"><?php e('Logout'); ?></a></p>
<?php
  }else if(file_exists('data/account/account.php')){
?>
    <p id="status"><a title="<?php e('Login'); ?>" href="login.php"><?php e('Login'); ?></a></p>
<?php
  }else{
?>
    <p id="status"><a title="<?php e('Login'); ?>" href="login.php"><?php e('Create an account'); ?></a></p>
<?php
  }
?>
  </header>
  
  <div id="index">

  </div>

<?php
  require __DIR__.'/footer.php';
?>
