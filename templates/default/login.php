<?php 
	/**
	* BoZoN login form:
	* part of auto_restrict lib v4.1
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
if (!function_exists('is_user_connected')){
	# Checks auto_restrict's session vars to know if admin is connected
	function is_user_connected(){
		if (empty($_SESSION['id_user'])||empty($_SESSION['login'])||empty($_SESSION['expire'])){
			return false;
		}
		return true;
	}
}
?>

<div id="login">
  <?php 
    $f=file_exists('private/auto_restrict_users.php');
    $n=isset($_GET['newuser']);
    if ($n&&!is_allowed('add user')){safe_redirect('index.php?p=admin&token='.TOKEN);}
    $p=isset($_GET['change_password']);
    $input_login='<input type="text" name="login" id="login" required="required" autofocus placeholder="'.e('Login',false).'"/>';
    if(!$f||$n){
    	echo '<h1>'.e('New account',false).'</h1>';
    }else if($p&&is_user_connected()){
    	//echo '<h1>'.e('Change password',false).'</h1>';
    }else{
    	//echo '<h1>'.e('Please, login',false).'</h1>';
    }
  ?>
  
  <div id="form">
    <?php  
    # error messages
    if (!empty($_GET['error'])){
    	echo '<div class="error">';
    		if ($_GET['error']==1){e('This login is not available, please try another one');}
    		if ($_GET['error']==2){e('Wrong combination login/pass');}
    		if ($_GET['error']==3){e("The passwords doesn't match.");}
    		if ($_GET['error']==4){e('Problem with admin password.');}
    	echo '</div>'; 
    }
    if (isset($_GET['success'])){
    	echo '<div class="success">';
    	if (empty($_GET['success'])){
    		e('Account created:');
    		if (!empty($_GET['name'])){echo ' <em>'.$_GET['name'].'</em> ';}
    	}elseif ($_GET['success']==1){
    		echo '<div class="success">';
    		e('Password changed'); 
    	}
      echo '</div>';
    }
    ?>
    
  	<form action="index.php" method="post" name="">				
  			<?php 
  				if(!$f||$n){
  					echo '<input type="hidden" name="creation" value="1"/>';
  					echo $input_login;
  				}else if($p&&is_user_connected()){
  					echo '<h1 id="user">'.e('User:',false).'&nbsp;'.$_SESSION['login'].'</h1>';	
  					adminPassword($label='',$placeholder=e('Old password',false));
  				}else{
  					echo $input_login;
  				}
  			?>
  
    	<input type="password" name="pass" id="pass" required="required" onKeyup="check();" placeholder="<?php e('Password'); ?>"/>	
    	<?php if ($n&&is_user_connected()||$p&&is_user_connected()||!$f){?>
    		<input type="password" name="confirm" id="confirm" onKeyup="check();" required="required" placeholder="<?php e('Repeat password'); ?>"/>	
    	<?php } ?>
    	<?php if (is_user_connected()){newToken();}?>
    	<div>
    		<?php if($f&&!$n&&!is_user_connected()){echo '<input id="kouki" type="checkbox" value="cookie" name="cookie" /><label for="kouki">'.e('Stay connected',false).'</label>';} ?>
    		<input id="submit" type="submit" class="btn" value="Ok" />	
    	</div>
    </form>
  </div>
</div>

<script>
    p=document.getElementById('pass');
    c=document.getElementById('confirm');
    function check(){
      if (p.value!=c.value){c.style.backgroundColor='#edbcba';}
      else{c.style.backgroundColor='#bcedbc';p.style.backgroundColor='#bcedbc'}
    }
    </script>