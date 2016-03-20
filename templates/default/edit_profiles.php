<?php
	/**
	* BoZoN users page:
	* delete profiles, edit maximum size for user's folder
	* @author: Bronco (bronco@warriordudimanche.net)
	**/
	require_once('core/auto_restrict.php'); # Connected user only !
	if (!is_allowed('change status rights')){safe_redirect('index.php?p=admin&token='.TOKEN);}
?>




<div style="clear:both"></div>

<div id="edit_profiles">
	
<table><form action="#" method="POST">
	<?php
		foreach($PROFILES as $num=>$profile){
			echo '<tr>';
			echo '<td><input class="npt" type="text" name="profile_name[]" value="'.$profile.'" title="'.e($profile,false).'"/></td><td>';
			foreach($ACTIONS as $action){
				$eaction=e($action,false);
				if(is_allowed($action,$profile)){$checked='checked';}else{$checked='';}
				echo '<input id="'.$profile.$eaction.'" type="checkbox" name="'.$num.'[]" value="'.$action.'" '.$checked.'/><label class="btn" for="'.$profile.$eaction.'">'.$eaction.'</label>';
			}			
			echo '</td></tr>';
		}

	?>
	<tr class="add">
		<td><input class="npt" type="text" name="profile_name[]" value="" placeholder="<?php e('New profile');?>"/></td>
		<td>
			<?php 
			foreach($ACTIONS as $action){
				$eaction=e($action,false);
				echo '<input id="new'.$eaction.'" type="checkbox" name="'.count($PROFILES).'[]" value="'.$action.'" disabled="true"/><label class="btn" for="new'.$eaction.'">'.$eaction.'</label>';
			}		
			?>

		</td>
	</tr>
	<tr><td></td><td><input type="submit" value="Ok" class="btn"/></td></tr>
	<?php newToken();?>
</form></table>
</div>
		
<script>
	on('keyup','.add .npt',function(){
		if (this.value){removeAttr('input[type=checkbox]:disabled','disabled')}
		else{attr('.add input[type=checkbox]','disabled','true');}
	});
</script>
	

