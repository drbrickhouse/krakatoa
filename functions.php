<?php
//Ensuring that is_plugin_active() exists
if ( ! function_exists( 'is_plugin_active' ) ) {
 require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}

//Include Theme Cuztomizer Options
//include_once(get_template_directory() . '/admin/customizer.php');

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
  return '<?php the_title(); ?>';
}

function krakatoa_shortcode_content(){
  return '<?php the_content(); ?>';
}

function krakatoa_shortcode_excerpt(){
  return'<?php the_excerpt(); ?>';
}

function krakatoa_shortcode_featured_image(){
  return '<?php the_post_thumbnail(); ?>';
}

function krakatoa_shortcode_category(){
  return '<?php
  $whitspace_category_post_id = get_the_ID();
  $cats = get_the_category(); ?>
  <a href="<?php echo get_category_link($cats[0]->cat_ID); ?>"><?php echo $cats[0]->name; ?></a>';
}

function krakatoa_shortcode_featured_image_url(){
  return '<?php the_post_thumbnail_url(); ?>';
}

function krakatoa_shortcode_permalink(){
  return '<?php the_permalink(); ?>';
}

function krakatoa_shortcode_search_form(){
  return '<?php get_search_form(); ?>';
}

function krakatoa_shortcode_cta_link(){
  return '<?php the_field(link); ?>';
}

function krakatoa_shortcode_cta_icon() {
  return '<i class="fa <?php the_field(font_awesome_icon_class); ?>"></i>';
}

function krakatoa_shortcode_event_start_date($format) {
  extract (shortcode_atts(array(
    'dateformat' => 'M jS'
  ), $format));

  $output = '<?php echo eo_get_the_start("' . $dateformat . '"); ?>';

  return $output;
}

function krakatoa_shortcode_event_end_date($format) {
  extract (shortcode_atts(array(
    'dateformat' => 'M jS'
  ), $format));

  $output = '<?php echo eo_get_the_end("' . $dateformat . '"); ?>';

  return $output;
}

function krakatoa_shortcode_event_start_time($format) {
  extract (shortcode_atts(array(
    'timeformat' => 'g:i A'
  ), $format));

  $output = '<?php echo eo_get_the_start("' . $timeformat . '"); ?>';

  return $output;
}

add_shortcode( 'the_title', 'krakatoa_shortcode_title' );
add_shortcode( 'the_content', 'krakatoa_shortcode_content' );
add_shortcode( 'the_excerpt', 'krakatoa_shortcode_excerpt' );
add_shortcode( 'featured_image', 'krakatoa_shortcode_featured_image' );
add_shortcode( 'the_category', 'krakatoa_shortcode_category' );
add_shortcode( 'featured_image_url', 'krakatoa_shortcode_featured_image_url' );
add_shortcode( 'the_permalink', 'krakatoa_shortcode_permalink' );
add_shortcode( 'search_form', 'krakatoa_shortcode_search_form' );
add_shortcode( 'cta_link', 'krakatoa_shortcode_cta_link' );
add_shortcode( 'cta_icon', 'krakatoa_shortcode_cta_icon' );
add_shortcode( 'event_start_date', 'krakatoa_shortcode_event_start_date' );
add_shortcode( 'event_end_date', 'krakatoa_shortcode_event_end_date' );
add_shortcode( 'event_start_time', 'krakatoa_shortcode_event_start_time' );

//Custom fields
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_ctas',
		'title' => 'CTAs',
		'fields' => array (
			array (
				'key' => 'field_58f2f06cb45e7',
				'label' => 'Link',
				'name' => 'link',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
      array (
				'key' => 'field_59753a49a55db',
				'label' => 'Font Awesome Icon Class',
				'name' => 'font_awesome_icon_class',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => 'fa-icon-name',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'ctas',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_portfolio',
		'title' => 'Portfolio',
		'fields' => array (
			array (
				'key' => 'field_58f2efb43e07f',
				'label' => 'CMS',
				'name' => 'cms',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'portfolio',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
  register_field_group(array (
		'id' => 'acf_locations',
		'title' => 'Locations',
		'fields' => array (
			array (
				'key' => 'field_5a95ae4f2cfbd',
				'label' => 'Address Line 1',
				'name' => 'address_line_1',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5a95ae8e2cfbe',
				'label' => 'Address Line 2',
				'name' => 'address_line_2',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5a95aeaf2cfbf',
				'label' => 'City',
				'name' => 'city',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5a95aeb72cfc0',
				'label' => 'State',
				'name' => 'state',
				'type' => 'select',
				'choices' => array (
					'Alabama' => 'Alabama',
					'Alaska' => 'Alaska',
					'Arizona' => 'Arizona',
					'Arkansas' => 'Arkansas',
					'California' => 'California',
					'Colorado' => 'Colorado',
					'Connecticut' => 'Connecticut',
					'Delaware' => 'Delaware',
					'Florida' => 'Florida',
					'Georgia' => 'Georgia',
					'Hawaii' => 'Hawaii',
					'Idaho' => 'Idaho',
					'Illinois' => 'Illinois',
					'Indiana' => 'Indiana',
					'Iowa' => 'Iowa',
					'Kansas' => 'Kansas',
					'Kentucky' => 'Kentucky',
					'Louisiana' => 'Louisiana',
					'Maine' => 'Maine',
					'Maryland' => 'Maryland',
					'Massachusetts' => 'Massachusetts',
					'Michigan' => 'Michigan',
					'Minnesota' => 'Minnesota',
					'Mississippi' => 'Mississippi',
					'Missouri' => 'Missouri',
					'Montana' => 'Montana',
					'Nebraska' => 'Nebraska',
					'Nevada' => 'Nevada',
					'New Hampshire' => 'New Hampshire',
					'New Jersey' => 'New Jersey',
					'New Mexico' => 'New Mexico',
					'New York' => 'New York',
					'North Carolina' => 'North Carolina',
					'North Dakota' => 'North Dakota',
					'Ohio' => 'Ohio',
					'Oklahoma' => 'Oklahoma',
					'Oregon' => 'Oregon',
					'Pennsylvania' => 'Pennsylvania',
					'Rhode Island' => 'Rhode Island',
					'South Carolina' => 'South Carolina',
					'South Dakota' => 'South Dakota',
					'Tennessee' => 'Tennessee',
					'Texas' => 'Texas',
					'Utah' => 'Utah',
					'Vermont' => 'Vermont',
					'Virginia' => 'Virginia',
					'Washington' => 'Washington',
					'Washington DC' => 'Washington DC',
					'West Virginia' => 'West Virginia',
					'Wisconsin' => 'Wisconsin',
					'Wyoming' => 'Wyoming',
				),
				'default_value' => 'Alabama',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_5a95af542cfc1',
				'label' => 'ZIP Code',
				'name' => 'zip_code',
				'type' => 'number',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
        'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5a95af6a2cfc2',
				'label' => 'Phone Number',
				'name' => 'phone_number',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
        'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5a95af9b2cfc3',
				'label' => 'Fax Number',
				'name' => 'fax_number',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array (
				'key' => 'field_5a95afe42cfc4',
				'label' => 'Email Address',
				'name' => 'email_address',
				'type' => 'email',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'locations',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
  register_field_group(array (
		'id' => 'acf_staff',
		'title' => 'Staff',
		'fields' => array (
      array(
  			'key' => 'field_5c9cbd405861b',
  			'label' => 'Position',
  			'name' => 'staff_position',
  			'type' => 'text',
  			'instructions' => '',
  			'required' => 0,
  			'conditional_logic' => 0,
  			'wrapper' => array(
  				'width' => '',
  				'class' => '',
  				'id' => '',
  			),
  			'default_value' => '',
  			'placeholder' => '',
  			'prepend' => '',
  			'append' => '',
  			'maxlength' => '',
  		),
			array (
				'key' => 'field_5a99cbc902e95',
				'label' => 'Phone Number',
				'name' => 'phone_number',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5a99cc0a02e96',
				'label' => 'Email Address',
				'name' => 'email_address',
				'type' => 'email',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'staff',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
  acf_add_local_field_group(array(
  	'key' => 'group_5c87fc5b17270',
  	'title' => 'Testimonials',
  	'fields' => array(
  		array(
  			'key' => 'field_5c87fc66deda4',
  			'label' => 'Reviewer Name',
  			'name' => 'reviewer_name',
  			'type' => 'text',
  			'instructions' => '',
  			'required' => 0,
  			'conditional_logic' => 0,
  			'wrapper' => array(
  				'width' => '',
  				'class' => '',
  				'id' => '',
  			),
  			'default_value' => '',
  			'placeholder' => 'John Doe',
  			'prepend' => '',
  			'append' => '',
  			'maxlength' => '',
  		),
  		array(
  			'key' => 'field_5c87fcb5deda5',
  			'label' => 'Star Rating',
  			'name' => 'star_rating',
  			'type' => 'number',
  			'instructions' => '',
  			'required' => 1,
  			'conditional_logic' => 0,
  			'wrapper' => array(
  				'width' => '',
  				'class' => '',
  				'id' => '',
  			),
  			'default_value' => '',
  			'placeholder' => '',
  			'prepend' => '',
  			'append' => 'Stars',
  			'min' => 1,
  			'max' => 5,
  			'step' => 1,
  		),
  	),
  	'location' => array(
  		array(
  			array(
  				'param' => 'post_type',
  				'operator' => '==',
  				'value' => 'testimonials',
  			),
  		),
  	),
  	'menu_order' => 0,
  	'position' => 'normal',
  	'style' => 'default',
  	'label_placement' => 'top',
  	'instruction_placement' => 'label',
  	'hide_on_screen' => '',
  	'active' => 1,
  	'description' => '',
  ));
}

//Widgets
  //Allow Shortcodes in Widgets
  add_filter( 'widget_text', 'shortcode_unautop');
  add_filter('widget_text', 'do_shortcode', 101);
  add_filter('widget_custom_html_content', 'do_shortcode');

function krakatoa_create_widget($name, $id, $description) {
  register_sidebar(array(
    'name' => __($name),
    'id' => $id,
    'description' => __($description),
    'before_widget' => '<div class="row widget'.' '.$id.' '.'"><div class="col-12"><div class="row widget-inner"><div class="col-12">',
    'after_widget' => '</div></div></div></div>',
    'before_title' => '<h2 class="module-heading">',
    'after_title' => '</h2>'
  ));
}

krakatoa_create_widget('Top Bar', 'top-bar', 'The topmost section of the website, generally used for a phone number or CTA');
krakatoa_create_widget('Header A1', 'header-a1', '');
krakatoa_create_widget('Header A2', 'header-a2', '');
krakatoa_create_widget('Header A3', 'header-a3', '');
krakatoa_create_widget('Header B1', 'header-b1', '');
krakatoa_create_widget('Header B1-1', 'header-b1-1', '');
krakatoa_create_widget('Header B2', 'header-b2', '');
krakatoa_create_widget('Header B3', 'header-b3', '');
krakatoa_create_widget('Footer A1', 'footer-a1', '');
krakatoa_create_widget('Footer B1', 'footer-b1', '');
krakatoa_create_widget('Footer B2', 'footer-b2', '');
krakatoa_create_widget('Footer B3', 'footer-b3', '');
?>
