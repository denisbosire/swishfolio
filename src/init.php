<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function swishfolio_lite_cgb_block_assets() { // phpcs:ignore
	// Register block styles for both frontend + backend.
	wp_register_style(
		'swishfolio_lite-cgb-style-css', // Handle.
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
		is_admin() ? array( 'wp-editor' ) : null, // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
	);

	// Register block editor script for backend.
	wp_register_script(
		'swishfolio_lite-cgb-block-js', // Handle.
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
		null, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);

	// Register block editor styles for backend.
	wp_register_style(
		'swishfolio_lite-cgb-block-editor-css', // Handle.
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
	wp_localize_script(
		'swishfolio_lite-cgb-block-js',
		'cgbGlobal', // Array containing dynamic data for a JS Global.
		[
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
			// Add more data here that you want to access from `cgbGlobal` object.
		]
	);

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
	 * @since 1.16.0
	 */
	register_block_type(
		'cgb/block-swishfolio-lite', array(
			// Enqueue blocks.style.build.css on both frontend & backend.
			'style'         => 'swishfolio_lite-cgb-style-css',
			// Enqueue blocks.build.js in the editor only.
			'editor_script' => 'swishfolio_lite-cgb-block-js',
			// Enqueue blocks.editor.build.css in the editor only.
			'editor_style'  => 'swishfolio_lite-cgb-block-editor-css',
		)
	);
}

// Hook: Block assets.
add_action( 'init', 'swishfolio_lite_cgb_block_assets' );


function swishportfolio_cpts() {

	/**
	 * Post Type: Portfolio.
	 */

	$labels = array(
		"name" => __( "Portfolio", "pro-portfolio" ),
		"singular_name" => __( "Portfolio", "pro-portfolio" ),
	);

	$args = array(
		"label" => __( "Portfolio", "pro-portfolio" ),
		"labels" => $labels,
		"description" => "Add Your personal portfolio here",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "portfolio", "with_front" => true ),
		"query_var" => true,
		"menu_icon" => plugin_dir_url( __DIR__ ) . 'assets/icons/gallery2.png',
		'show_in_rest' => true,
		"supports" => array( "title", "editor", "thumbnail" ),
	);

	register_post_type( "portfolio", $args );
}

function swishportfolio_taxes() {

	/**
	 * Taxonomy: Project Types.
	 */

	$labels = array(
		"name" => __( "Project Types", "pro-portfolio" ),
		"singular_name" => __( "Project Type", "pro-portfolio" ),
	);

	$args = array(
		"label" => __( "Project Types", "pro-portfolio" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => true,
		"label" => "Project Types",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'project-type', 'with_front' => true, ),
		"show_admin_column" => true,
		"show_in_rest" => true,
		"rest_base" => "project-type",
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "project-type", array( "portfolio" ), $args );
}
add_action( 'init', 'swishportfolio_cpts' );
add_action( 'init','swishportfolio_taxes' );