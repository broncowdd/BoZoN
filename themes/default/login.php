<?php
  include('header.php');
?>

  <div id="login" class="form_content">
    <form action="" method="post" name="">
      <?php 
        $f=file_exists($auto_restrict['path_to_files'].'/auto_restrict_pass.php');
        if($f){
          echo '<h2>'.e('Login',false).'</h2>';
        }else{
          echo '<h2>'.e('Create your account',false).'</h2>';
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
  include('footer.php');
?>
