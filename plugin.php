<?php
/**
 * Plugin Name: Sandbox Plugin
 * Plugin URI: https://github.com/Herm71/blackbird-core-functionality-plugin.git
 * Description: Dev plugin for sandbox sites.
 * Version: 1.1.0
 * Author: Blackbird
 * Author URI: https://jasonchafin.com/
 * License: GPL2
 * Text Domain: blackbird
 */

// Set plugin directory and basename.
if ( ! defined( 'ACF_DIR' ) ) {
	define( 'ACF_DIR', dirname( __FILE__ ) );
}

/**
 * Add new load point for JSON
 */

function ucsc_add_json_load_point( $paths ) {
    // Remove the original path (optional).
    unset($paths[0]);

    // Append the new path and return it.
    $paths[] = ACF_DIR . '/acf-json';

    return $paths;    
}
add_filter( 'acf/settings/load_json', 'ucsc_add_json_load_point' );

/**
 * Add new save point for JSON
 */

function ucsc_add_json_save_point( $path ) {
    return ACF_DIR . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'ucsc_add_json_save_point' );

/**
 * We register our block's with WordPress's handy
 * register_block_type();
 *
 * @link https://developer.wordpress.org/reference/functions/register_block_type/
 */

function register_acf_blocks() {
	register_block_type( __DIR__ . '/blocks/editorial-style-guide' );
}

add_action( 'init', 'register_acf_blocks' );



 //Jason's Test Functions
// add_filter('use_block_editor_for_post_type', 'prefix_disable_gutenberg', 10, 2);
function prefix_disable_gutenberg($current_status, $post_type)
{
    // Use your post type key instead of 'product'
    if ($post_type === 'a_z_style_guide') return false;
    return $current_status;
}

// add_action( 'init', 'disable_editor_style_guide', 99); 

function disable_editor_style_guide() {

    remove_post_type_support( 'a_z_style_guide', 'editor' );

}

add_shortcode('say-hello', 'say_hello');

function say_hello() {

return 'Hello!';

}

add_shortcode( 'style-definition','bb_a_z_style_guide_single_loop' );

function bb_a_z_style_guide_single_loop(){
	$finaldefs = '';  
	if( have_rows('style_definitions') ):while( have_rows('style_definitions') ): the_row();

		$azItem = get_sub_field('editorial_style_item');
		$azDef = get_sub_field('editorial_style_definition');
		
		$finaldefs .= '<p><b>'.$azItem.':</b></p>'.$azDef.'<hr>';
  	
		endwhile;
	endif;
  return $finaldefs;
}
/** Alternate method of single loop. Works the same */
function bb_a_z_style_guide_single_loop2(){
		$finaldefs = '';
    $definitions = get_field('style_definitions');
 
	if ( $definitions ) {
		
		foreach ( $definitions as $definition ) {
    	// vars
    	$azItem = $definition['editorial_style_item'];
    	$azDef = $definition['editorial_style_definition'];
	
    	$finaldefs .= '<p><b>'.$azItem.':</b></p>'.$azDef.'<hr>';
		}
  }
	return $finaldefs;
}

/** Template Loop */

add_shortcode( 'style-archive','bb_a_z_styles_archive_loop' );
function bb_a_z_styles_archive_loop() {
	$finalloop = ''; 
	// Call Post
	$args = array (
	'post_type' => 'a_z_style_guide',
	'orderby' => 'title',
	'order' => 'ASC',
	'posts_per_page' => -1,
		
	);
	$azDir = new \WP_Query( $args );
	if ($azDir->have_posts()) :
		while ($azDir->have_posts()) :
			$azDir->the_post();
			$azTitle = get_the_title();
			$finalloop .= '<h2>'.$azTitle.'</h2>';
			if( have_rows('style_definitions') ):
				while( have_rows('style_definitions') ): 
					the_row();
					// vars
					$azItem = get_sub_field('editorial_style_item');
					$azDef = get_sub_field('editorial_style_definition');
					$finalloop .=  '<p><b>'.$azItem.':</b></p>'.$azDef.'<hr>';
				endwhile;
			endif;
		endwhile;
	endif;
return $finalloop;
wp_reset_postdata();

}


register_meta(
    'post',
    'book-genre',
    array(
        'show_in_rest' => true,
        'single'       => true,
        'type'         => 'string',
        'default'      => 'Default text field',
    )
);

add_action( 'init', 'projectslug_register_meta' );

function projectslug_register_meta() {
	register_meta(
		'post',
		'projectslug_mood',
		array(
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'string',
			'sanitize_callback' => 'wp_strip_all_tags'
		)
	);
}