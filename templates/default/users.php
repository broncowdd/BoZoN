<?php
	/**
	* BoZoN users page:
	* delete profiles, edit maximum size for user's folder
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
	if (!function_exists('newToken')){require_once('core/auto_restrict.php');} # Admin only!
	if (!is_admin()){include(THEME_PATH.'footer.php');exit;}
?>

<link rel="stylesheet" type="text/css" href="<?php echo THEME_PATH; ?>/css/users_page.css">



		<div style="clear:both"></div>

<div id="users_page">

					<h1><?php e('Users profiles'); ?></h1>

				<table><tr>
					<td>
					<div class="dialog"><figure><figcaption>
						<?php 
							generate_users_formlist(e('Delete an account',false),e('Check users to delete account and files',false));// auto_restrict function
						?>

						</figcaption></figure></div>
					</td>
					<td>
					<div class="dialog"><figure><figcaption>
						<?php 
							generate_users_folder_space_formlist(e('Configure folders max size',false),''); // in core (not an auto_restrict function)
						?>
						</figcaption></figure></div>
					</td>
				</tr></table>


	</div>
		
			
	

