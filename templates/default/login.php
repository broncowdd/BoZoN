<?php 
	/**
	* BoZoN login form:
	* part of auto_restrict lib v4.1
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
if (!function_exists('is_admin_connected')){
	# Checks auto_restrict's session vars to know if admin is connected
	function is_admin_connected(){
		if (empty($_SESSION['id_user'])||empty($_SESSION['login'])||empty($_SESSION['expire'])){
			return false;
		}
		return true;
	}

}
?>


	<div class="form_content">
		<?php
			# error messages
			if (!empty($_GET['error'])){
				echo '<div class="error">';
					if ($_GET['error']==1){e('This login is not available, please try another one');}
					if ($_GET['error']==2){e('Wrong combination login/pass');}
					if ($_GET['error']==3){e('The passwords doesn\'t match.');}
					if ($_GET['error']==4){e('Problem with admin password.');}
				echo '</div>'; 
			}
			if (isset($_GET['success'])){
				if (empty($_GET['success'])){
					echo '<div class="success">';
					if (!empty($_GET['name'])){echo '<em>'.$_GET['name'].'</em> ';}
					e('account created');
					echo '</div>'; 
				}elseif ($_GET['success']==1){
					echo '<div class="success">';
					e('Password changed');
					echo '</div>'; 
				}

			}
		?>
		<form action='index.php' method='post' name='' >				
				<?php 
					$f=file_exists('private/auto_restrict_users.php');
					$n=isset($_GET['newuser']);
					$p=isset($_GET['change_password']);
					$input_login='<input type="text" class="npt" name="login" id="login" required="required" autofocus placeholder="'.e('Login',false).'"/>';
					if(!$f||$n){
						echo '<h1>'.e('Create your account',false).'</h1>';
						echo '<input type="hidden" name="creation" value="1"/>';
						echo $input_login;
						
					}else if($p&&is_admin_connected()){
						echo '<h1>'.e('Change password',false).'</h1>';
						echo '<h2>'.$_SESSION['login'].'</h2>';	
						adminPassword($label='',$placeholder=e('Old password',false));
					}else{
						echo '<h1>'.e('Please, login',false).'</h1>';
						echo $input_login;
					}
				?>

			<input type='password' class="npt" name='pass' id='pass'  required="required"  onKeyup="check();" placeholder="<?php  e('Password')?>"/>	
			<?php if ($n&&is_admin_connected()||$p&&is_admin_connected()||!$f){?>
				<input type='password' class="npt" name='confirm' id='confirm' onKeyup="check();" required="required" placeholder="<?php  e('Repeat password')?>"/>	
			<?php } ?>
			<?php if (is_admin_connected()){newToken();}?>
			<div>
				<?php if($f&&!$n&&!is_admin_connected()){echo '<input id="cookie" type="checkbox" value="cookie" name="cookie"/><label for="cookie">'.e('Stay connected',false).'</label>';} ?>
				<input type='submit' class="btn" value='Ok'/>	
			</div>
		</form>
	</div>
<script>
	p=document.getElementById('pass');
	c=document.getElementById('confirm');
	function check(){
		if (p.value!=c.value){c.style.backgroundColor='#F50';}
		else{c.style.backgroundColor='#5F5';p.style.backgroundColor='#5F5'}
	}
</script>