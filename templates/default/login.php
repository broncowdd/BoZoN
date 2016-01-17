<?php
    require __DIR__.'/header.php'; 
?>
  </header>
  
  <div id="login">
    <form action="" method="post" name="">
      <?php 
        $f=file_exists('data/account.php');
        if($f){
          echo '<h2>'.e('Login',false).'</h2>';
        }else{
          echo '<h2>'.e('Create an account',false).'</h2>';
        }
      ?>
      
      <input type="text" name="login" id="user" placeholder="<?php e('User'); ?>" required="required" autofocus />
      
      <input type="password" name="pass" id="pass" placeholder="<?php e('Password'); ?>" required="required" />	
      
      <?php if($f){echo '<input id="cookie" type="checkbox" value="cookie" name="cookie" /><label for="cookie">'.e('Stay connected',false).'</label>';} ?>
  		
  		<?php if($f){ ?>
          <input type="submit" id="submit" value="<?php e('Login') ?>" />
      <?php }else{ ?>
          <input type="submit" id="cya" value="<?php e('OK') ?>" />
      <?php } ?>
    </form>
  </div>

<?php
  require __DIR__.'/footer.php';
?>
