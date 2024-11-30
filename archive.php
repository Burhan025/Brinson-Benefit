<?php get_header(); ?>

</div><!--close Header -->
    
    </div><!--close Wrapper -->
<div id="main-bg" >
<div id="main" class=<?php if (is_front_page()) { ?>"main-home"<?php } else { ?>"main-page"<?php } ?>>
<div id="page-bottom">
<div id="page_content" class="wrapper" >
<div id="content">

<?php query_posts($query_string . '&orderby=date&order=DESC'); ?>


	<?php if (have_posts()) : ?>

	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h1 class="pagetitle"><?php single_cat_title(); ?></h1>
	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h1 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h1>
	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h1 class="pagetitle">Archive</h1>
	<?php } ?>
    
		<?php while (have_posts()) : the_post(); ?>
        		
      <div class="postdate"><?php the_time('F j, Y') ?></div>
      <h2 class="posttitle"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
      
      <div class="entry post clear">
		
		<?php if ( get_post_meta($post->ID, 'summary', true) ) { 
		
		 echo get_post_meta($post->ID, 'summary', true)  
		 
		 ?>
                
        <div class="read-more"><a class="read-more" href="<? the_permalink(); ?>">Read More»</a></div>
        
        <?php } elseif (is_category(array('webinars'))) {?>
			   <!--<div class="read-more"><a class="read-more" href="<? the_permalink(); ?>">Read More»</a></div>-->
		<?php } else {?>
        		
                <div class="eventespresso-thumbnail">
					<?php the_post_thumbnail('thumbnail'); ?>
			  </div>
        		
                <div class="archive-post-summary">
                <? the_excerpt_custom_length(300) ?>
                <div class="eventespresso-date">
					<?php espresso_event_date(); ?>
				</div>
                <div class="read-more"><a class="read-more ee-viewdetail" href="<? the_permalink(); ?>">View Details»</a></div>
                
                </div>
                
                
                <div class="read-more"><a class="read-more archive-blog" href="<? the_permalink(); ?>">Read More»</a></div>
        <?php }?>
       
      </div><!--end entry-->                
    <?php endwhile; ?>
    
	<?php wp_pagenavi(); ?>

    <?php else : ?>
    <?php endif; ?>  
    
 </div><!-- End Content-->
	
	
	<?php
if(strpos($_SERVER['REQUEST_URI'], 'control') !== false){
    get_sidebar('right');
}
	if(strpos($_SERVER['REQUEST_URI'], 'compliance') !== false){
    get_sidebar('right');
}
	if(strpos($_SERVER['REQUEST_URI'], 'efficiency') !== false){
    get_sidebar('right');
}
	if(strpos($_SERVER['REQUEST_URI'], 'communication') !== false){
    get_sidebar('right');
}
	if(strpos($_SERVER['REQUEST_URI'], 'education') !== false){
    get_sidebar('right');
}
	
	if(strpos($_SERVER['REQUEST_URI'], 'wellness') !== false){
    get_sidebar('right');
}
if(strpos($_SERVER['REQUEST_URI'], 'advocacy') !== false){
    get_sidebar('right');
}
	if(strpos($_SERVER['REQUEST_URI'], 'covid') !== false){
    get_sidebar('right');
}
	if(strpos($_SERVER['REQUEST_URI'], 'people') !== false){
    get_sidebar('event');
}
//else{
    //get_sidebar('event');
//}
	?>
	
 
        
      
  
</div><!--End Page_Content-->
</div><!--End Page_Bottom-->
</div><!-- End Main-->
</div><!-- End Main-BG-->

<?php get_footer(); ?>