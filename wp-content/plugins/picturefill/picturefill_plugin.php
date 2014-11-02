<?php
/*
    Plugin Name: Picturefill
    Plugin URI:
    Description: Add HTML5 responsive <picture> element with srcset to content images
    Author: Benjamin Dolly
    Version: 1.0
    Author URI: dev.insearchofaweso.me
    */











function pictureFiller( $content ) {

$pretty = function( 
        $v='', 
        $c="&nbsp;&nbsp;&nbsp;&nbsp;", 
        $in=-1, 
        $k=null 
        )use( &$pretty ) {

            $r='';

            if ( in_array( gettype( $v ), array( 'object', 'array' ) ) ) {

                $r.=( $in!=-1?str_repeat( $c, $in ):'' ).( is_null( $k )?'':"$k: " ).'<br>';

                foreach ( $v as $sk=>$vl ){
                    $r.=$pretty( $vl, $c, $in+1, $sk ).'<br>';
                }//end foreach

            }else {
                $r.=( $in!=-1?str_repeat( $c, $in ):'' ).( is_null( $k )?'':"$k: " ).( is_null( $v )?'&lt;NULL&gt;':"<strong>$v</strong>" );
            }

            return$r;
        };










    global $wp_query, $post, $_wp_additional_image_sizes;
    


    $sizes = array();
    $get_intermediate_image_sizes = get_intermediate_image_sizes();

    //Create the full array with sizes and crop info
    //http:codex.wordpress.org/Function_Reference/get_intermediate_image_sizes
    foreach ( $get_intermediate_image_sizes as $_size ) {
        
         if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {
            // put standard sizes in array 
            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );

        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            // add custom sizes to array
            $sizes[ $_size ] = array( 
                    'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                    'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                    'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
            );
        }//end if/else

    }//end foreach

    
    $new_content = preg_replace_callback(
        '/(<a .*?><img.*?>|<img.*?>)/i',
         'pictureFiller_content_imgs', 
         $content);



    return $new_content;


// return $content;


}//end pictureFiller

add_filter( 'the_content', 'pictureFiller' );


function pictureFiller_content_imgs($matches){
    // print_r($matches[0]);
}






// end of file
?>
