<?php
	/**
	* BoZoN users page:
	* delete profiles, edit maximum size for user's folder
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
	require_once('core/auto_restrict.php'); # Connected user only !
	
	if (!is_allowed('users page')){safe_redirect('index.php?p=admin&token='.TOKEN);}
	$_SESSION['users_rights']=complete_users_rights();
?>




<div style="clear:both"></div>

<div id="users_page">
	<div class="tab_space">
		<ul class="tabs">
		<?php 
			if (is_allowed('delete user')) {echo '<li class="btn" data-target=".delete_tab"><span class="icon-trash"></span>'.e('Delete',false).'</li>';}
			if (is_allowed('change user status')) {echo '<li class="btn" data-target=".status_tab"><span class="icon-crown"></span> '.e('Status',false).'</li>';}
			if (is_allowed('change folder size')) {echo '<li class="btn" data-target=".folderspace_tab"><span class="icon-bat2"></span> '.e('Space',false).'</li>';}
			if (is_allowed('change passes')) {echo '<li class="btn" data-target=".password_tab"><span class="icon-lock"></span> '.e('Password',false).'</li>';}
		?>
		</ul>

		<div class=" dialog">
			<figure>
				<figcaption>
				<?php 
					if (is_allowed('delete user')) {
						echo '<div class="delete_tab hidden">';
						generate_users_formlist(e('Check users to delete account and files',false));// auto_restrict function
						echo '</div>';
					}

					if (is_allowed('change user status')) {
						echo '<div class="status_tab hidden">';
						generate_users_status_formlist(e('Select new status for the users',false),e('User',false),e('Admin',false));// auto_restrict function
						echo '</div>';
					}

					if (is_allowed('change folder size')) {
						echo '<div class="folderspace_tab hidden">';
						generate_users_folder_space_formlist(e('Configure folders max size',false),''); // in core (not an auto_restrict function)
						echo '</div>';
					}

					if (is_allowed('change passes')) {
						echo '<div class="password_tab hidden">';				
						echo '<h1>'.e('Change users\'passwords',false).'</h1><form action="" method="POST" class="users_pass_list"><table>';
						foreach ($auto_restrict['users'] as $user=>$data){
							if ($auto_restrict['users'][$user]['status']!='superadmin'){
								$class=' class="'.$auto_restrict['users'][$user]['status'].'" title="'.e($auto_restrict['users'][$user]['status'],false).'"';
								echo '<tr>';
								echo '<td>';
								echo '<span '.$class.'>'.$user.'</span></td>';
								echo '<input type="hidden" name="user_name[]" value="'.$user.'"/>';
								echo '<td><input type="text" name="user_pass[]" ondblclick="this.value=generer_password()" class="npt generate_pswd" value="" title="'.e('Double-clic to generate a password',false).'" autocomplete="off"/></td>';
								newToken();
								echo '</tr>';
							}
						}
						echo '</table><input type="submit" value="Ok" class="btn"/></form></div>';
					}
				?>
				
				</figcaption>
			</figure>
		</div>	
	</div>

</div>
		
	<script>
	    function generer_password() {
	    	// from http://www.italic.fr/generer-un-password-en-javascript/
	        var ok = 'azertyupqsdfghjkmwxcvbn23456789AZERTYUPQSDFGHJKMWXCVBN#@';
	        var pass = '';
	        longueur = 10;
	        for(i=0;i<longueur;i++){
	            var wpos = Math.round(Math.random()*ok.length);
	            pass+=ok.substring(wpos,wpos+1);
	        }
	        return pass;
	    }
	    remove(first('#users_page .hidden:empty'));
	    removeClass(first('#users_page .hidden'),"hidden");
	    addClass(first('.tabs li'),'active');
		on("click","li[data-target]",function(){
			target=attr(this,"data-target");
			addClass("figcaption>div","hidden");
			removeClass(target,"hidden");
			removeClass("li[data-target]","active");
			addClass(this,"active");
		});

		/*on("dblclick",".generate_pswd",function(){
			attr(this,"value",generer_password());
		});*/

	</script>		
	

