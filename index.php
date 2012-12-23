<?php get_header(); 


	wp_reset_query();
	global $post;
	$counter = 0;
	$args = array(
					'numberposts'     => get_option("wordstrap_homepage_carousel_count", 3 ),
					'offset'          => 0,
					'category'          => get_option('wordstrap_homepage_category'),
					'orderby'         => 'post_date',
					'order'           => 'DESC',
					'post_type'       => 'post',
					'post_status'     => 'publish'); 
	
	//print_r($args);
	$posts_array = get_posts( $args );
	?>
  
  
  	<div class="row">
    <div class="span8">
    
    <div class="well">
        <div id="wordstrapCarousel" class="carousel slide">
            <div class="carousel-inner">
                      
            
            
  
 
  
    
    
	<? foreach( $posts_array as $post ) :	setup_postdata($post); 
    	remove_filter('the_excerpt', 'wpautop'); 
    
    ?>
    		 	<div class="item <? if($counter == 0) {?>active<? } ?>">
                   <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', '' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"> <? the_post_thumbnail() ?>></a>
                    <div class="carousel-caption">
                        <h4><?php the_title(); ?></h4>
                        <p><?php the_excerpt(); ?>.</p>
                    </div>
                </div>
    
    <?php 
   	  $counter++;
  	  endforeach; 
    
    ?>
	
	
			</div>
            <a class="left carousel-control" href="#wordstrapCarousel" data-slide="prev">‹</a>
            <a class="right carousel-control" href="#wordstrapCarousel" data-slide="next">›</a>
        </div>
        
        <?php dynamic_sidebar( 'homepage-widget' ); ?>
        
    </div>
    
    		
    </div> <!-- end span8-->
    <div class="span4">
    
     
		 <?
            wp_reset_query();
            global $post;
            $counter = 0;
            $args = array(
                            'numberposts'     => get_option("wordstrap_homepage_right_count", 3 ),
                            'offset'          => 0,
                            'category'          => get_option('wordstrap_homepage_category_right'),
                            'orderby'         => 'post_date',
                            'order'           => 'DESC',
                            'post_type'       => 'post',
                            'post_status'     => 'publish'); 
            
            //print_r($args);
            $posts_array = get_posts( $args );
        
        ?>
	 
		 <? foreach( $posts_array as $post ) :	setup_postdata($post); 
            remove_filter('the_excerpt', 'wpautop'); 
        
        ?>
     
     
     
         
            <div class="well">
            <h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', '' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                   <p><?php the_excerpt(); ?></p>
                 <p><a class="btn" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', '' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">View details &raquo;</a></p>
            </div>
        
       <?php 
		  $counter++;
		  endforeach; 
    
   		 ?>
        
        
    </div> <!-- end span4-->
    </div> <!-- end row-->





<? 
	//	} else {

?>
          
          
           
           
         
<?php 
		//}
		$counter++;
	//endwhile; 
	
?>
		 	
<?php get_footer(); ?>
<script type="text/javascript">
  $('#wordstrapCarousel').carousel()
</script>
 