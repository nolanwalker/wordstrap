<?php get_header(); ?>

	
				<h1 class="entry-title"><?php _e( 'Not Found', '' ); ?></h1>
				<div class="entry-content">
					<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', '' ); ?></p>
					<?php get_search_form(); ?>
				</div>
		
	<script type="text/javascript">
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

<?php get_footer(); ?>