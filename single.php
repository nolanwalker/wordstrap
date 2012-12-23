<?php get_header(); ?>

		

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				

				
					<h1 class="entry-title"><?php the_title(); ?></h1>

					

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', '' ), 'after' => '</div>' ) ); ?>
					</div><!-- .entry-content -->

				<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>

			
<?php get_footer(); ?>
