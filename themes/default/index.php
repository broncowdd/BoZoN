<?php
  include('header.php');
  
  if($f){ 
?>
    <p class="login"><a title="<?php e('Login'); ?>" href="admin.php"><?php e('Login'); ?></a></p>
<?php
  }else{ 
?>
    <p class="login"><a title="<?php e('Login'); ?>" href="admin.php"><?php e('Create your account'); ?></a></p>
<?php
  }
?>
  </header>
  
  <div id="index">

  </div>

<?php
  include('footer.php');
?>
