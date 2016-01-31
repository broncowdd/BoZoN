<?php 
	/**
	* BoZoN login form:
	* part of auto_restrict lib 
	* @author: Bronco (bronco@warriordudimanche.net)
	**/

?>


	<div class="form_content">
		<?php
			# error messages
			if (!empty($_GET['error'])){
				echo '<div class="error">';
					if ($_GET['error']==1){e('This login is not available, please try another one');}
					if ($_GET['error']==2){e('Wrong combination login/pass');}
				echo '</div>'; 
			}
			if (isset($_GET['success'])){
				echo '<div class="success">';
				if (!empty($_GET['name'])){echo '<em>'.$_GET['name'].'</em> ';}
				e('account created');
				echo '</div>'; 
			}
		?>
		<form action='index.php' method='post' name='' >				
				<?php 
					$f=file_exists('private/auto_restrict_users.php');
					$n=isset($_GET['newuser']);
					if(!$f||$n){
						echo '<h1>'.e('Create your account',false).'</h1>';
						echo '<input type="hidden" name="creation" value="1"/>';
						if (is_admin_connected()){newToken();}
						
					}else{
						echo '<h1>'.e('Please, login',false).'</h1>';
					}
				?>

			<input type='text' class="npt" name='login' id='login' required="required" autofocus placeholder="<?php  e('Login')?>"/>			
			<input type='password' class="npt" name='pass' id='pass'  required="required" placeholder="<?php  e('Password')?>"/>	
			<?php if (is_admin_connected()){newToken();}?>
			<div>
				<?php if($f&&!$n){echo '<input id="cookie" type="checkbox" value="cookie" name="cookie"/><label for="cookie">'.e('Stay connected',false).'</label>';} ?>
				<input type='submit' class="btn" value='Ok'/>	
			</div>
		</form>
	</div>
