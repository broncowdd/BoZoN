<?php 
	/**
	* BoZoN login form:
	* part of auto_restrict lib 
	* @author: Bronco (bronco@warriordudimanche.net)
	**/

	include('core.php');
?>
<head>
	<title>BoZon - Admin</title>
	 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="shortcut icon" type="/image/png" href="img/bozonlogo2.png">
	<meta charset="utf-8" />
</head>
<body class="login">

<div class="form_content">
	<form action='' method='post' name='' >
		<p class="logo">

		</p>
		<h1>BoZoN</h1>
			<?php 
				$f=file_exists($auto_restrict['path_to_files'].'/auto_restrict_pass.php');
				if($f){echo '<h2>'.e('Please, login',false).'</h2>';}else{echo '<h2>'.e('Create your account',false).'</h2>';} 
			?>
		
			<hr/>
			<label for='login'><?php  e('Login')?> </label>
			<input type='text' name='login' id='login' required="required" autofocus/>
			
		<label for='pass'><?php  e('Password')?> </label>
		<input type='password' name='pass' id='pass'  required="required"/>	

		
		<?php if($f){echo '<hr/><input id="cookie" type="checkbox" value="cookie" name="cookie"/><label for="cookie">'.e('Stay connected',false).'</label>';} ?>
		
		
		<hr/>
		<input type='submit' value='Ok'/>	
	</form>
</div>
</body>