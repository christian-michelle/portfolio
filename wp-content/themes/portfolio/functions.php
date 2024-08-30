<?php
/**
 * portfolio functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package portfolio
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function portfolio_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on portfolio, use a find and replace
		* to change 'portfolio' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'portfolio', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'portfolio' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'portfolio_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'portfolio_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function portfolio_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'portfolio_content_width', 640 );
}
add_action( 'after_setup_theme', 'portfolio_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function portfolio_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'portfolio' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'portfolio' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'portfolio_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function portfolio_scripts() {
	wp_enqueue_style( 'portfolio-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'portfolio-style', 'rtl', 'replace' );

	wp_enqueue_script( 'portfolio-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'portfolio_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


/*** Add custom post types and taxonomies */
add_action('init', function() {
	register_post_type('portfolio', [
		'label' => __('Portfolio', 'txtdomain'),
		'public' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-book',
		'supports' => ['title', 'editor', 'thumbnail', 'author', 'revisions', 'comments'],
		'show_in_rest' => true,
		'rewrite' => ['slug' => 'portfolio'],
		'taxonomies' => ['portfolio_genre'],
		'labels' => [
			'singular_name' => __('Portfolio', 'txtdomain'),
			'add_new_item' => __('Add new portfolio', 'txtdomain'),
			'new_item' => __('New portfolio', 'txtdomain'),
			'view_item' => __('View portfolios', 'txtdomain'),
			'not_found' => __('No portfolios found', 'txtdomain'),
			'not_found_in_trash' => __('No portfolios found in trash', 'txtdomain'),
			'all_items' => __('All portfolios', 'txtdomain'),
			'insert_into_item' => __('Insert into portfolio', 'txtdomain')
		],		
	]);
 
	register_taxonomy('portfolio_genre', ['portfolio'], [
		'label' => __('Genres', 'txtdomain'),
		'hierarchical' => true,
		'rewrite' => ['slug' => 'portfolio-genre'],
		'show_admin_column' => true,
		'show_in_rest' => true,
		'labels' => [
			'singular_name' => __('Genre', 'txtdomain'),
			'all_items' => __('All Genres', 'txtdomain'),
			'edit_item' => __('Edit Genre', 'txtdomain'),
			'view_item' => __('View Genre', 'txtdomain'),
			'update_item' => __('Update Genre', 'txtdomain'),
			'add_new_item' => __('Add New Genre', 'txtdomain'),
			'new_item_name' => __('New Genre Name', 'txtdomain'),
			'search_items' => __('Search Genres', 'txtdomain'),
			'parent_item' => __('Parent Genre', 'txtdomain'),
			'parent_item_colon' => __('Parent Genre:', 'txtdomain'),
			'not_found' => __('No Genres found', 'txtdomain'),
		]
	]);
	register_taxonomy_for_object_type('portfolio_genre', 'portfolio');
});

// Add custom blocks - ACF Blocks 
add_action('acf/init', 'tm_register_blocks');
function tm_register_blocks() {

  // check function exists.
  if( function_exists('acf_register_block_type') ) {

  // Portfolio Block
  acf_register_block_type(array(
    'name'        => 'portfolio-block',
    'title'       => __( 'Portfolio Block'),
    'description'   => __( 'Portfolio Block.'),
    'render_template'   => 'template-parts/blocks/portfolio-block/portfolio-block.php',
    'category'      => 'formatting',
    'icon'        => 'archive',
    'keywords'      => array( 'portfolio-block' ),
  ));
  }
}