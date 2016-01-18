<?php
  require __DIR__.'/header.php';
  
  if($_SESSION['login']):
    echo '<p id="status"><a title="'.e('Logout',false).'" href="?logout">'.e('Logout',false).'</a></p>';
  elseif(file_exists('data/account/account.php')):
    echo '<p id="status"><a title="'.e('Login',false).'" href="login.php">'.e('Login',false).'</a></p>';
  else:
    echo '<p id="status"><a title="'.e('Create an account',false).'" href="login.php">'.e('Create an account',false).'</a></p>';
  endif;
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
      if(file_exists('data/account/account.php')):
        echo '<p id="warning">'.e('<a title="Login" href="login.php">Log in</a> to administer the web application',false).'</p>';
      else:
        echo '<p id="warning">'.e('You need to <a title="Create an account" href="login.php">create an account</a> to use this web application',false).'</p>';
      endif;
    ?>
  </div>

<?php
  require __DIR__.'/footer.php';
