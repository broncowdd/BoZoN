
	<footer>
	  <p><a id="github" href="https://github.com/broncowdd/BoZoN" title="<?php e('Fork me on github'); ?>" target="_blank"><span class="icon-github-circled" ></span></a></p>
	  <p id="version">BoZoN <?php echo VERSION; ?></p>
	</footer>
	
	<script>
		// click on lightbox link
		on('click','a[data-type]',function(event){
			event.preventDefault();
			event.stopPropagation();
			lb_show(this);
			return false;
		})

		// click on folder to ufold content on share page
		on('click','.folder',function(){
			toggleClass(this.nextElementSibling,'show');
			toggleClass(this,'unfolded');
		});
	</script>
</body>
</html>
