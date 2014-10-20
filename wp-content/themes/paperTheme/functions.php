<?php
/**
 * _paperTheme functions and definitions
 *
 * @package _paperTheme
 */

if ( ! function_exists( '_paperTheme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function _paperTheme_setup() {

	// launching operation cleanup
	 add_action('init', '_paperTheme_head_cleanup');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', '_paperTheme' ),
	) );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	
}
endif; // _paperTheme_setup
add_action( 'after_setup_theme', '_paperTheme_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function _paperTheme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', '_paperTheme' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', '_paperTheme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function _paperTheme_scripts() {
	global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

  if (!is_admin()) {

		// modernizr (without media query polyfill)
		wp_register_script( '_paperTheme-modernizr', get_stylesheet_directory_uri() . '/js/libs/modernizr.custom.js', array(), '2.5.3', false );

		// register main stylesheet from css
		wp_register_style( '_paperTheme-stylesheet', get_stylesheet_directory_uri() . '/css/style.css', array(), '', 'all' );

		// ie-only style sheet
		wp_register_style( '_paperTheme-ie-only', get_stylesheet_directory_uri() . '/css/ie.css', array(), '' );

		//adding scripts file in the footer
		wp_register_script( '_paperTheme-custom-js', get_stylesheet_directory_uri() . '/js/_paperTheme.js', array( 'jquery' ), '', true );

		//courtesy of _s underscores.me theme
		wp_register_script( '_paperTheme-foucs-fix-js', get_stylesheet_directory_uri() . '/js/fix-link-focus-fix.js', array( 'jquery' ), '', true );

		// enqueue styles and scripts
		wp_enqueue_script( '_paperTheme-modernizr' );
		wp_enqueue_style( '_paperTheme-stylesheet' );
		wp_enqueue_style( '_paperTheme-ie-only' );

		$wp_styles->add_data( '_paperTheme-ie-only', 'conditional', 'lt IE 9 | IE 9' ); // add conditional wrapper around ie stylesheet

		// enque JQuery from google CDN and add to footer 
		wp_deregister_script('jquery');
		wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"), true, '1.11.1', true);
		wp_enqueue_script('jquery');

		// AJAX
		// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
		wp_localize_script( '_paperTheme-custom-js', 'LocalAJAX', array( 'url' => admin_url( 'admin-ajax.php' ) ) );

		// enqueue custom.js after Jquery in the footer
		wp_enqueue_script( '_paperTheme-custom-js' );
		
		// this gets concatenated into _paperTheme-custom-js
		// during the production theme build
		wp_enqueue_script( '_paperTheme-focus-fix-js' );

	}

	// wp_enqueue_style( '_s-style', get_stylesheeturi() );
}
add_action( 'wp_enqueue_scripts', '_paperTheme_scripts' );

/**
 * Clean-up wp_head() garbage
 */
require get_template_directory() . '/inc/clean_wp_head.php';

/**
 * Clean images inserted into post
 */
require get_template_directory() . '/inc/cleanPostImgs.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * AJAX functions called by javascript actions
 */
require get_template_directory() . '/inc/ajax-functions.php';

