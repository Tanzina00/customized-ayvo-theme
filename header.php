<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage ayvo
 * @since 1.0
 * @version 1.0
 */
?>
    <!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
		 <?php
		if(is_page('store-locations') || is_page('store-locations-2')){
	echo ('<script src="https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.1/mapbox-gl.js"> </script>');
	echo('<link href="https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.1/mapbox-gl.css" rel="stylesheet" /> '); 
	
}
			if(is_page('checkout') || is_page('checkout-2')){

			echo('<script src="http://maps.google.com/maps/api/js?sensor=true"></script>'); 
		
		?>
	<style>
		  #map {
          height:350px;
        }
	</style>
<?php }
		?>
		<?php wp_head(); ?>
    </head>
<body <?php body_class(); ?>>
<div class="overlay-body"></div>
<?php do_action( 'ayvo_header_content' ); 
?>