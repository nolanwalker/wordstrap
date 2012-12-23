<?php
/**
 * Template Name: No sidebar
 *
 */

get_header(); ?>

		
<div class="row">
        <div class="span12">
          

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

						<h1 class="entry-title"><?php the_title(); ?></h1>
					

					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
				

<?php endwhile; ?>

		</div><!--/span12-->
      </div><!--/row-->
<?php get_footer(); ?>