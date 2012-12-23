<?php
if ( ! isset( $content_width ) )
	$content_width = 1000;

add_action( 'after_setup_theme', 'default_setup' );
add_filter('widget_text', 'do_shortcode');
remove_filter ('the_content', 'wpautop');

//**********MENUS********************
function default_setup() {

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', '' ),
	) );

	define( 'NO_HEADER_TEXT', true );



	
}
//**********SIDEBARS********************
function default_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', '' ),
		'id' => 'main-sidebar',
		'description' => __( 'The primary sidebar', '' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<li class="nav-header">',
		'after_title' => '</li>',
	) );
	
	
	register_sidebar( array(
		'name' => __( 'Homepage Widget', '' ),
		'id' => 'homepage-widget',
		'description' => __( 'A widget for under the carousel on the hompeage.', '' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2 class="hompage-widget">',
		'after_title' => '</h2>',
	) );

	
}









//************EXCERPTS********************
function default_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'default_excerpt_length' );


function default_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', '' ) . '</a>';
}

function default_auto_excerpt_more( $more ) {
	return ' &hellip;' . default_continue_reading_link();
}
add_filter( 'excerpt_more', 'default_auto_excerpt_more' );

function default_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= default_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'default_custom_excerpt_more' );


function default_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', '' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', '' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', '' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', '' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', '' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', ''), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}



add_action( 'widgets_init', 'default_widgets_init' );

function default_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', '' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', '' ), get_the_author() ),
			get_the_author()
		)
	);
}

function default_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', '' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', '' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', '' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}


class wordstrap_walker_nav_menu extends Walker_Nav_Menu {
    
	
	function start_lvl( &$output, $depth ) {
		$output .= "\n<ul class=\"dropdown-menu\">\n";
	}

	
	function start_el( &$output, $item, $depth, $args ) {
		global $wp_query;
		
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$li_attributes = $class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		if ( $args->has_children ) {
			$classes[] = 'dropdown';
			$li_attributes .= ' data-dropdown="dropdown"';
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

		$attributes	=	$item->attr_title	? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes	.=	$item->target		? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes	.=	$item->xfn			? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes	.=	$item->url			? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes	.=	$args->has_children	? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

		$item_output	=	$args->before . '<a' . $attributes . '>';
		$item_output	.=	$args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output	.=	( $args->has_children ) ? ' <b class="caret"></b>' : '';
		$item_output	.=	'</a>' . $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	
	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {

		if ( ! $element )
			return;

		$id_field = $this->db_fields['id'];

		//display this element
		if ( is_array( $args[0] ) )
			$args[0]['has_children'] = (bool) ( ! empty( $children_elements[$element->$id_field] ) AND $depth != $max_depth - 1 );
		elseif ( is_object(  $args[0] ) )
			$args[0]->has_children = (bool) ( ! empty( $children_elements[$element->$id_field] ) AND $depth != $max_depth - 1 );

		$cb_args = array_merge( array( &$output, $element, $depth ), $args );
		call_user_func_array( array( &$this, 'start_el' ), $cb_args );

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ( $max_depth == 0 OR $max_depth > $depth+1 ) AND isset( $children_elements[$id] ) ) {

			foreach ( $children_elements[ $id ] as $child ) {

				if ( ! isset( $newlevel ) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array( &$output, $depth ), $args );
					call_user_func_array( array( &$this, 'start_lvl' ), $cb_args );
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
			unset( $children_elements[ $id ] );
		}

		if ( isset( $newlevel ) AND $newlevel ) {
			//end the child delimiter
			$cb_args = array_merge( array( &$output, $depth ), $args );
			call_user_func_array( array( &$this, 'end_lvl' ), $cb_args );
		}

		//end this element
		$cb_args = array_merge( array( &$output, $element, $depth ), $args );
		call_user_func_array( array( &$this, 'end_el' ), $cb_args );
	}
}

function wordstrap_nav_menu_css_class( $classes ) {
	if ( in_array('current-menu-item', $classes ) OR in_array( 'current-menu-ancestor', $classes ) )
		$classes[]	=	'active';

	return $classes;
}
add_filter( 'nav_menu_css_class', 'wordstrap_nav_menu_css_class' );


/*admin settings*/
function wordstrap_admin_menu() {

    add_menu_page ( 'WordStrap Settings', 'WordStrap', 'edit_published_posts', 'wordstrap-settings', 'wordstrap_admin_function' );

}


function wordstrap_admin_function() {
	$you_are_here = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
	$categories = get_categories(array('hide_empty' => 0));
	
	$wordstrap_homepage_category = get_option("wordstrap_homepage_category", "none" );
	$wordstrap_homepage_carousel_count = get_option("wordstrap_homepage_carousel_count", 3 );
	
	$wordstrap_homepage_category_right = get_option("wordstrap_homepage_category_right", "none" );
	$wordstrap_homepage_right_count = get_option("wordstrap_homepage_right_count", 3 );
	
	
	
	/* deal with form submit */
	if(isset($_POST['submit'])) {
			
		update_option(  'wordstrap_homepage_category', $_POST['wordstrap_homepage_category']);
		update_option(  'wordstrap_homepage_carousel_count', $_POST['wordstrap_homepage_carousel_count']);
		
		update_option(  'wordstrap_homepage_category_right', $_POST['wordstrap_homepage_category_right']);
		update_option(  'wordstrap_homepage_right_count', $_POST['wordstrap_homepage_right_count']);
		
		
		echo ( "<script> alert('Settings Updated.'); location.replace('$you_are_here') </script>" );
		exit;
		
	}
	
	
	
	
	
	
	echo '
		<h1>WordStrap Settings</h1>
		<div style="float:right">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="R8NBSH2PGBA74">
		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
		</div>

		
		<p>Thank you for choosing WordStrap. If you like it, click the donate link to buy my a cup of coffee (or bettter yet, a beer).</p>
		<p>Below are some very basic settings for your theme, please update frequently as I will be adding features.</p>
		<hr>
		<form method="post" action="' . $you_are_here . '">
		<h2>Homepage Carousel</h2>
		<p>
		<select name="wordstrap_homepage_category">
		<option value="none" ';
		if($wordstrap_homepage_category == "none") {
			echo ' selected="selected" ';	
		}
		echo '
		>----Post Category---</option>';
		foreach ($categories as $category) {
			echo '<option value="' . $category->cat_ID . '" ';
			if($wordstrap_homepage_category == $category->cat_ID) {
				echo ' selected="selected" ';	
			}
			echo ' >' . $category->category_nicename . '</option>';
		}
		echo '
		</select> <a href="edit-tags.php?taxonomy=category">Posts Category</a>
		</p>
		<p>
		<select name="wordstrap_homepage_carousel_count">';
		
		for ($i=3;$i<=10;$i++) {
			echo '<option value="' . $i . '" ';
			if($wordstrap_homepage_carousel_count == $i) {
				echo ' selected="selected" ';	
			}
			echo ' >' . $i . '</option>';
		}
		echo '
		</select>
		Number of Posts
		</p>
		
		
		
		<h2>Homepage Right Side Posts</h2>
		<p>
		<select name="wordstrap_homepage_category_right">
		<option value="none" ';
		if($wordstrap_homepage_category_right == "none") {
			echo ' selected="selected" ';	
		}
		echo '
		>----Post Category---</option>';
		foreach ($categories as $category) {
			echo '<option value="' . $category->cat_ID . '" ';
			if($wordstrap_homepage_category_right == $category->cat_ID) {
				echo ' selected="selected" ';	
			}
			echo ' >' . $category->category_nicename . '</option>';
		}
		echo '
		</select> <a href="edit-tags.php?taxonomy=category">Posts Category</a>
		</p>
		<p>
		<select name="wordstrap_homepage_right_count">';
		
		for ($i=3;$i<=10;$i++) {
			echo '<option value="' . $i . '" ';
			if($wordstrap_homepage_right_count == $i) {
				echo ' selected="selected" ';	
			}
			echo ' >' . $i . '</option>';
		}
		echo '
		</select>
		Number of Posts
		</p>
		
		
		
		
		
		<div style="clear:both"></div>
		<input type="submit" name="submit" value="Submit">
		</form>';
}





add_action ( 'admin_menu', 'wordstrap_admin_menu' );








