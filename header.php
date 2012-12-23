<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', '' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link href="<?php bloginfo('template_url'); ?>/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php bloginfo('template_url'); ?>/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">


<!--addition styles for demos, remove if you want to-->
<link href="<?php bloginfo('template_url'); ?>/bootstrap/css/docs.css" rel="stylesheet">

<!--google prettify, if you want it-->
<link href="<?php bloginfo('template_url'); ?>/bootstrap/css/prettify.css" rel="stylesheet">

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->


<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>


</head>

<body>

	
	
    
    
    <div class="navbar navbar-fixed-top">
       <div class="navbar-inner">
        <div class="container">
         	<span class="brand"><a href="/"><?php bloginfo( 'name' ); ?></a>
            <h5><?php bloginfo( 'description' ); ?></h5>
            </span>
            
        </div>
        </div>
      
      <div class="navbar-inner">
        <div class="container">
            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
           
          
            <div class="nav-collapse">
                <?php wp_nav_menu( array(
                    'theme_location'	=>	'primary',
                    'menu_class'		=>	'nav',
                    'depth'				=>	2,
                    'fallback_cb'		=>	false,
                    'walker'			=>	new wordstrap_walker_nav_menu,
                ) ); 
                //if ( the_bootstrap_options()->navbar_searchform ) {
                  //  the_bootstrap_navbar_searchform();
                //} ?>
            </div>
        </div>
    </div>
      

    </div>
    
    
    <div class="container">

     

     

      