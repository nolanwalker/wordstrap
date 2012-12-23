<?php get_header(); ?>

		

<?php
	if ( have_posts() )
		the_post();
?>

				<h1 class="page-title author"><?php printf( __( 'Author Archives: %s', '' ), "<span class='vcard'><a class='url fn n' href='" . get_author_posts_url( get_the_author_meta( 'ID' ) ) . "' title='" . esc_attr( get_the_author() ) . "' rel='me'>" . get_the_author() . "</a></span>" ); ?></h1>

<?php
if ( get_the_author_meta( 'description' ) ) : ?>
					<div id="entry-author-info">
						
						<div id="author-description">
							<h2><?php printf( __( 'About %s', 'twentyten' ), get_the_author() ); ?></h2>
							<?php the_author_meta( 'description' ); ?>
						</div>
					</div>
<?php endif; ?>

<?php
	rewind_posts();

	 get_template_part( 'loop', 'author' );
?>
			
<?php get_footer(); ?>
