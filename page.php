<?php get_header(); ?>


	<div class="row">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list sidebar">
            <?php dynamic_sidebar( 'main-sidebar' ); ?>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span9">


<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

						<h1 class="entry-title"><?php the_title(); ?></h1>
					

					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
				

<?php endwhile; ?>

		</div><!--/span9-->
      </div><!--/row-->
<?php get_footer(); ?>
