<?php
  include('header.php');
  
  if(!empty($_SESSION['login'])){
?>
    <p id="status"><a title="<?php e('Logout'); ?>" href="admin.php"><?php e('Logout'); ?></a></p>
<?php
  }else if(file_exists('private/auto_restrict_pass.php')){
?>
    <p id="status"><a title="<?php e('Login'); ?>" href="admin.php"><?php e('Login'); ?></a></p>
<?php
  }else{
?>
    <p id="status"><a title="<?php e('Login'); ?>" href="admin.php"><?php e('Create your account'); ?></a></p>
<?php
  }
?>
  </header>
  
  <div id="index">

  </div>

<?php
  include('footer.php');
?>
