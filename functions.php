<?php
//Ensuring that is_plugin_active() exists
if ( ! function_exists( 'is_plugin_active' ) ) {
 require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}

//Include Theme Cuztomizer Options
include_once(get_template_directory() . '/admin/customizer.php');

//Stylesheets
function krakatoa_theme_styles() {
  //Bootstrap Icons
  wp_enqueue_style('bootstrap_icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css');
  //Bootstrap CSS
  wp_enqueue_style('boostrap_css', get_template_directory_uri() . '/assets/css/vendor/bootstrap.min.css');
  //Base CSS
  wp_enqueue_style('base_css', get_template_directory_uri() . '/assets/css/krakatoa-base.css');
  //Main CSS
  wp_enqueue_style('main_css', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'krakatoa_theme_styles', 1);

function krakatoa_admin_styles() {
  wp_enqueue_style('admin_css', get_template_directory_uri() . '/assets/css/admin.css');
}

add_action('admin_head', 'krakatoa_admin_styles');

//Javascript
function krakatoa_theme_js() {
  //Bootstrap
  wp_enqueue_script('bootstrap_js', get_template_directory_uri() . '/assets/js/vendor/bootstrap.bundle.min.js', array('jquery'), '', true);
  //Base JS
  wp_enqueue_script('base_js', get_template_directory_uri() . '/assets/js/krakatoa-base.js', array('jquery'), '', true);
}

add_action('wp_enqueue_scripts', 'krakatoa_theme_js');

//Custom Scripts
function krakatoa_header_scripts() {
  echo get_theme_mod( 'krakatoa_header_scripts' );
}

add_action('wp_head', 'krakatoa_header_scripts');


function krakatoa_footer_scripts() {
  echo get_theme_mod( 'krakatoa_footer_scripts' );
}

add_action('wp_footer', 'krakatoa_footer_scripts');

//Enable features
function krakatoa_enable_feautres() {
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'menus' );
  add_theme_support( 'wp-block-styles' );
}

add_action('init', 'krakatoa_enable_feautres');

//Disable Adding Paragraphs
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

//Remove the Read More Dots
function krakatoa_excerpt_more( $more ) {
    return '';
}
add_filter( 'excerpt_more', 'krakatoa_excerpt_more' );

//Navigation Menus
function krakatoa_register_theme_menus() {
  register_nav_menu( 'primary', __( 'Primary Menu', 'krakatoa' ) );
}

add_action('init', 'krakatoa_register_theme_menus');

//WooCommerce
function krakatoa_woocommerce_setup() {
  //Declare WooCommerce Support
  add_theme_support( 'woocommerce' );

  //Add support for image gallery options
  add_theme_support( 'wc-product-gallery-zoom' );
  add_theme_support( 'wc-product-gallery-lightbox' );
  add_theme_support( 'wc-product-gallery-slider' );
}

add_action( 'after_setup_theme', 'krakatoa_woocommerce_setup' );

function krakatoa_woocommerce_edit_actions() {
  remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
  remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
  remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
}

add_action( 'after_setup_theme', 'krakatoa_woocommerce_edit_actions' );

//Shortcodes
function krakatoa_shortcode_title(){
  return get_the_title();
}

function krakatoa_shortcode_content(){
  return get_the_content();
}

function krakatoa_shortcode_excerpt(){
  return get_the_excerpt();
}

function krakatoa_shortcode_featured_image(){
  return get_the_post_thumbnail();
}

function krakatoa_shortcode_category(){
  return '<?php
  $whitspace_category_post_id = get_the_ID();
  $cats = get_the_category(); ?>
  <a href="<?php echo get_category_link($cats[0]->cat_ID); ?>"><?php echo $cats[0]->name; ?></a>';
}

function krakatoa_shortcode_featured_image_url(){
  return get_the_post_thumbnail_url();
}

function krakatoa_shortcode_permalink(){
  return get_the_permalink();
}

function krakatoa_shortcode_search_form(){
  return '<?php get_search_form(); ?>';
}

add_shortcode( 'the_title', 'krakatoa_shortcode_title' );
add_shortcode( 'the_content', 'krakatoa_shortcode_content' );
add_shortcode( 'the_excerpt', 'krakatoa_shortcode_excerpt' );
add_shortcode( 'featured_image', 'krakatoa_shortcode_featured_image' );
add_shortcode( 'the_category', 'krakatoa_shortcode_category' );
add_shortcode( 'featured_image_url', 'krakatoa_shortcode_featured_image_url' );
add_shortcode( 'the_permalink', 'krakatoa_shortcode_permalink' );
add_shortcode( 'search_form', 'krakatoa_shortcode_search_form' );

//Widgets
  //Allow Shortcodes in Widgets
  add_filter( 'widget_text', 'shortcode_unautop');
  add_filter('widget_text', 'do_shortcode', 101);
  add_filter('widget_custom_html_content', 'do_shortcode');
?>
