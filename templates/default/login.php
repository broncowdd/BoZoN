<?php 
	/**
	* BoZoN login form:
	* part of auto_restrict lib 
	* @author: Bronco (bronco@warriordudimanche.net)
	**/

?>


	<div class="form_content">
		<form action='' method='post' name='' >
			
				<?php 
					$f=file_exists('private/auto_restrict_pass.php');
					if(!$f){echo '<h1>'.e('Create your account',false).'</h1>';} 
					else{echo '<h1>'.e('Please, login',false).'</h1>';}
				?>

			<input type='text' class="npt" name='login' id='login' required="required" autofocus placeholder="<?php  e('Login')?>"/>
				
			<input type='password' class="npt" name='pass' id='pass'  required="required" placeholder="<?php  e('Password')?>"/>	

			<div>
				<?php if($f){echo '<input id="cookie" type="checkbox" value="cookie" name="cookie"/><label for="cookie">'.e('Stay connected',false).'</label>';} ?>
				<input type='submit' class="btn" value='Ok'/>	
			</div>
		</form>
	</div>
