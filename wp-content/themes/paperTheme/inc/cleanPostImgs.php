<?php
/**
 * Clean-up markup for images that are inserted into post
 *
 * @package _paperTheme
 */


add_filter( 'image_send_to_editor', '_paperTheme_remove_width_attribute', 10 );
add_filter( 'post_thumbnail_html', '_paperTheme_remove_width_attribute', 10 );
add_filter( 'the_content', '_paperTheme_remove_width_attribute', 10 );

/**
 * Remove height and width attributes from images inserterd into content area
 */
function _paperTheme_remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}




add_filter( 'img_caption_shortcode', 'clean_caption_shortcode', 10, 3 );
/**
 * Cleaup the img_caption_shortcode that is executed when adding captions
 * to images in the content field 
 *
 * This allows _paperTheme_img_unautop() to add the figcaption 
 * inside of the figure wrapper
 */
function clean_caption_shortcode( $empty, $attr, $content ){
	$attr = shortcode_atts( array(
		'id'      => '',
		'align'   => 'alignnone',
		'width'   => '',
		'caption' => ''
	), $attr );

	if ( 1 > (int) $attr['width'] || empty( $attr['caption'] ) ) {
		return '';
	}
	$content .='<figcaption class="wp-caption">' . $attr['caption'] . '</figcaption>';
	return $content;
}


/**
 * Remove p tags from around images inserterd into content area
 * wrap images in <figure>
 */
function _paperTheme_img_unautop($pee) {

	$pee = preg_replace('/(<a .*?><img.*?><figcaption .*?>.*?<\\/figcaption>|<img.*?><figcaption .*?>.*?<\\/figcaption>|<a .*?><img.*?>|<img.*?>)/i', '<figure>$1</figure>', $pee);
	
    return $pee;
}
add_filter( 'the_content', '_paperTheme_img_unautop', 100 );