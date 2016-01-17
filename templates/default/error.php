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
    <p id="status"><a title="<?php e('Create an account'); ?>" href="login.php"><?php e('Create an account'); ?></a></p>
<?php
  }
?>
  </header>

  <div id="error">
    <h2><?php e('Server error'); ?></h2>
    
    <p><?php echo $message[$server]; ?></p>

  </div>

<?php
  require __DIR__.'/footer.php';
?>
