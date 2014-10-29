<?php 
/* =======================================================================
  AJAX FUNCTIONALITY 
========================================================================== */

/* =======================================================================
  lazyLoad posts
 ========================================================================== */
// if both logged in and not logged in users can send this AJAX request,
// add both of these actions, otherwise add only the appropriate one
add_action( 'wp_ajax_nopriv_lazyLoad_request', 'lazyLoad_request' );
add_action( 'wp_ajax_lazyLoad_request', 'lazyLoad_request' ); 

 function lazyLoad_request(){ 
    // store request values
    $post_type       = $_POST['post_type'];
    $paged           = $_POST['page_no'];
    $posts_per_page  = $_POST['posts_per'];
    $cat_name        = $_POST['cat_name'] ? '"'.$_POST['cat_name'].'"': null;
    $tag_name        = $_POST['tag_name'] ? '"'.$_POST['tag_name'].'"': null;
    $search_term     = $_POST['search_term'] ? '"'.$_POST['search_term'].'"': null;
    $post_content_type = ($post_type !== "post") ? $post_type : null;
    

    // pass stored values as arguement
    $args = array (
      'post_type' => $post_type,
      'category_name' => $cat_name,
      'tag' => $tag_name,
      'posts_per_page' => $posts_per_page,
      'paged' => $paged,
      's' => $search_term
    );

    // setup new query with args
    $infinite_query = new WP_Query($args);

    if ( $infinite_query->have_posts() ) {
      while ( $infinite_query->have_posts() ) {
        $infinite_query->the_post();
        get_template_part( "content",   $post_content_type ); 
      }
    } 

    wp_reset_postdata();
 
    exit;
}
