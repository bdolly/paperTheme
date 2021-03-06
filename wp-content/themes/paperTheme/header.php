<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package _paperTheme
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Favicon and Feed -->
<link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Feed" href="<?php echo home_url(); ?>/feed/">

<!--  iPhone Web App Home Screen Icon -->
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/img/devices/_paperTheme-icon-ipad.png" />
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/img/devices/_paperTheme-icon-retina.png" />
<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/img/devices/_paperTheme-icon.png" />

<!-- Enable Startup Image for iOS Home Screen Web App -->
<meta name="apple-mobile-web-app-capable" content="yes" />
<link rel="apple-touch-startup-image" href="<?php echo get_template_directory_uri(); ?>/_paperTheme-mobile-load.png" />

<meta name="keywords" content="" />
<meta name="author" content="TPD Design House">
<!-- <link rel=”author” href=”https://plus.google.com/[YOUR PERSONAL G+ PROFILE HERE]“/> -->
<meta name="copyright" content="&copy; <?php echo get_the_date(Y); ?> <?php echo bloginfo( 'name' ); ?>" >

<title><?php wp_title( '|', true, 'right' ); ?></title>
<meta name="description" content="<?php bloginfo('description'); ?>" />


<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site grid-container">
	<a class="skip-link text-screen-reader" href="#content"><?php _e( 'Skip to content', '_paperTheme' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			
			<h1 id="site-logo" class="l-no-margin"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h4 class="l-no-mp site-description"><?php bloginfo( 'description' ); ?></h4> 
		</div>

		<nav id="site-navigation" class="navigation navigation--main" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
