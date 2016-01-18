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

  <div id="error">
    <h2><?php e('Server error'); ?></h2>
    
    <p><?php echo $message[$server]; ?></p>

  </div>

<?php
  require __DIR__.'/footer.php';
