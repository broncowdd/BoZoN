<?php
    require __DIR__.'/header.php'; 
?>
  </header>
  
  <div id="login">
    <form action="" method="post" name="">
      <?php 
        $f=file_exists('data/account/account.php');
        if($f):
          echo '<h2>'.e('Login',false).'</h2>';
        else:
          echo '<h2>'.e('Create an account',false).'</h2>';
        endif;
      ?>
      
      <input type="text" name="login" id="user" placeholder="<?php e('User'); ?>" required="required" autofocus />
      
      <input type="password" name="pass" id="pass" placeholder="<?php e('Password'); ?>" required="required" />	
      
      <?php
        if($f):
          echo '<input id="cookie" type="checkbox" value="cookie" name="cookie" /><label for="cookie">'.e('Stay connected',false).'</label>
                <input type="submit" id="submit" value="'.e('Login',false).'" />';
        else:
          echo '<input type="submit" id="cya" value="'.e('OK',false).'" />';
        endif;
      ?>
    </form>
  </div>

<?php
  require __DIR__.'/footer.php';
