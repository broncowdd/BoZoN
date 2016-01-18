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
  
  <div id="index">
    <h2><?php e('Send documents online'); ?></h2>
    
    <div id="block">
      <div>
        <div class="img"><img src="templates/default/img/tosend.png" alt="" /></div>
        <p><?php e('Send your files on the server'); ?></p>
      </div>
      <div>
        <div class="img"><img src="templates/default/img/toshare.png" alt="" /></div>
        <p><?php e('Share your files with friends'); ?></p>
      </div>
    </div>
    
    <?php
      if(file_exists('data/account/account.php')){
    ?>
      <p id="warning"><?php e('<a title="Login" href="login.php">Log in</a> to administer the web application'); ?></p>
    <?php
      }else{
    ?>
      <p id="warning"><?php e('You need to <a title="Create an account" href="login.php">create an account</a> to use this web application'); ?></p>
    <?php
      }
    ?>
  </div>

<?php
  require __DIR__.'/footer.php';
?>
