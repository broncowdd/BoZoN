<?php
  include('header.php');
?>
  <p id="status"><a title="<?php e('Logout'); ?>" href="admin.php?deconnexion"><?php e('Logout'); ?></a></p>		
  </header>
  
  
	<p><?php echo $message;?></p>

	<div id="content">
		

<div class="window">
<header><?php e('Access log');?></header>
<table class="sortable">
<thead>
	<tr>
		<th><?php e('Date');?></th>
		<th><?php e('File');?></th>
		<th><?php e('IP');?></th>
		<th><?php e('Origin');?></th>
		<th><?php e('Host');?></th>
	</tr>
	</thead>
	<tbody>
	<?php echo $log_list;?>

	</tbody>

	<tfoot>
		<tr><td><?php echo $button_previous;?></td><td></td><td><?php echo $paginate;?></td><td class="total_entries"><?php echo '[total: '.count($stats).']';?></td><td><?php echo $button_next;?></td></tr>
	</tfoot>
</table>
		</div>
			
		
	</div>
	<footer>
	<a class="trash" title="" href="stats.php?kill&token=<?php newToken(true);?>"><?php e('Delete all stat data'); ?></a>
		<div class="credits">Bozon v<?php echo VERSION;?> - <?php e('tiny file sharing app, coded with love and php by ');?> <a href="http://warriordudimanche.net">Bronco</a> - <a href="admin.php?deconnexion"><?php e('Logout'); ?></a></div>
		<a href="https://github.com/broncowdd/BoZoN" class="github" title="<?php e('fork me on github');?>">&nbsp;</a>
	</footer>
<script src="sorttable.js"></script>
<script>
	menu=document.getElementById('menu');
	menu_icon=document.getElementById('menu_icon');
	body=document.getElementById('body');
	cl='open';

	// block closing menu by clicking on it
	menu.addEventListener('click', function(event){
        if(event.stopPropagation) { event.stopPropagation(); }		
	});

	// menu appears and vanish
	menu_icon.addEventListener('click', function(event){
		if (menu.classList) {
		    menu.classList.toggle(cl)
		} else {
		    var classes = menu.className.split(' ')
		    var existingIndex = classes.indexOf(cl)
		    if (existingIndex >= 0)
		      classes.splice(existingIndex, 1)
		    else
		      classes.push(cl);
		    menu.className = classes.join(' ')
		}
        if(event.preventDefault) { event.preventDefault(); }
        if(event.stopPropagation) { event.stopPropagation(); }
		return false;
	});
	// close menu on clicking outside
	body.addEventListener('click', function(event){
		if (menu.classList) {
		   menu.classList.remove(cl);
		} else {
		   var classes = el.className.split(' ')
		    var existingIndex = classes.indexOf(cl)
		    if (existingIndex >= 0){ classes.splice(existingIndex, 1);}		    
		    el.className = classes.join(' ')
		}
        
		
	});

</script>

<?php
  include('footer.php');
?>
