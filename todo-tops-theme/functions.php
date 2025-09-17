<?php
/**
 * Todo Tops Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function todo_tops_setup() {
    // Add theme support for post thumbnails
    add_theme_support('post-thumbnails');

    // Add theme support for WooCommerce
    add_theme_support('woocommerce');

    // Add theme support for WooCommerce gallery features
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Add theme support for title tag
    add_theme_support('title-tag');

    // Add theme support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'todo-tops'),
        'footer'  => __('Footer Menu', 'todo-tops'),
    ));
}
add_action('after_setup_theme', 'todo_tops_setup');

/**
 * Enqueue Scripts and Styles
 */
function todo_tops_scripts() {
    // Enqueue theme stylesheet
    wp_enqueue_style('todo-tops-style', get_stylesheet_uri(), array(), '1.0.0');

    // Enqueue custom JavaScript
    wp_enqueue_script('todo-tops-script', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), '1.0.0', true);

    // Localize script for AJAX
    wp_localize_script('todo-tops-script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('todo_tops_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'todo_tops_scripts');

/**
 * WooCommerce Customizations
 */

// Remove WooCommerce default styles
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Customize WooCommerce shop loop
function todo_tops_shop_loop_item_title() {
    echo '<h3 class="product-title">' . get_the_title() . '</h3>';
}

// Customize product price display
function todo_tops_price_html($price, $product) {
    return '<span class="product-price">' . $price . '</span>';
}
add_filter('woocommerce_get_price_html', 'todo_tops_price_html', 10, 2);

// Customize add to cart button
function todo_tops_loop_add_to_cart_link($link, $product) {
    return sprintf(
        '<a href="%s" data-quantity="%s" class="%s btn btn-add-cart" %s>%s</a>',
        esc_url($product->add_to_cart_url()),
        esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
        esc_attr(isset($args['class']) ? $args['class'] : 'button'),
        isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
        esc_html($product->add_to_cart_text())
    );
}
add_filter('woocommerce_loop_add_to_cart_link', 'todo_tops_loop_add_to_cart_link', 10, 2);

/**
 * Custom Post Types and Taxonomies
 */

// Register custom post type for testimonials
function todo_tops_register_testimonials() {
    $args = array(
        'public'    => true,
        'label'     => 'Testimonials',
        'menu_icon' => 'dashicons-format-quote',
        'supports'  => array('title', 'editor', 'thumbnail')
    );
    register_post_type('testimonial', $args);
}
add_action('init', 'todo_tops_register_testimonials');

/**
 * Customizer Settings
 */
function todo_tops_customizer($wp_customize) {
    // Hero Section
    $wp_customize->add_section('hero_section', array(
        'title'    => __('Hero Section', 'todo-tops'),
        'priority' => 30,
    ));

    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default'           => '¡Bienvenido a Todo Tops!',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_title', array(
        'label'   => __('Hero Title', 'todo-tops'),
        'section' => 'hero_section',
        'type'    => 'text',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => 'La mejor tienda virtual con productos de calidad premium',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('hero_subtitle', array(
        'label'   => __('Hero Subtitle', 'todo-tops'),
        'section' => 'hero_section',
        'type'    => 'textarea',
    ));

    // Contact Information
    $wp_customize->add_section('contact_info', array(
        'title'    => __('Contact Information', 'todo-tops'),
        'priority' => 35,
    ));

    // Phone
    $wp_customize->add_setting('contact_phone', array(
        'default'           => '+1 (555) 123-4567',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_phone', array(
        'label'   => __('Phone Number', 'todo-tops'),
        'section' => 'contact_info',
        'type'    => 'text',
    ));

    // Email
    $wp_customize->add_setting('contact_email', array(
        'default'           => 'info@todotops.com',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('contact_email', array(
        'label'   => __('Email Address', 'todo-tops'),
        'section' => 'contact_info',
        'type'    => 'email',
    ));

    // WhatsApp Number
    $wp_customize->add_setting('whatsapp_number', array(
        'default'           => '1234567890',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('whatsapp_number', array(
        'label'   => __('WhatsApp Number', 'todo-tops'),
        'section' => 'contact_info',
        'type'    => 'text',
    ));
}
add_action('customize_register', 'todo_tops_customizer');

/**
 * AJAX Functions
 */

// Add to cart via AJAX
function todo_tops_ajax_add_to_cart() {
    check_ajax_referer('todo_tops_nonce', 'nonce');

    $product_id = absint($_POST['product_id']);
    $quantity = absint($_POST['quantity']);

    $result = WC()->cart->add_to_cart($product_id, $quantity);

    if ($result) {
        wp_send_json_success(array(
            'message' => 'Product added to cart',
            'cart_count' => WC()->cart->get_cart_contents_count()
        ));
    } else {
        wp_send_json_error('Failed to add product to cart');
    }
}
add_action('wp_ajax_add_to_cart', 'todo_tops_ajax_add_to_cart');
add_action('wp_ajax_nopriv_add_to_cart', 'todo_tops_ajax_add_to_cart');

/**
 * Widget Areas
 */
function todo_tops_widgets_init() {
    register_sidebar(array(
        'name'          => __('Footer Widget 1', 'todo-tops'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here.', 'todo-tops'),
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Widget 2', 'todo-tops'),
        'id'            => 'footer-2',
        'description'   => __('Add widgets here.', 'todo-tops'),
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ));
}
add_action('widgets_init', 'todo_tops_widgets_init');

/**
 * Utility Functions
 */

// Get hero title from customizer
function todo_tops_get_hero_title() {
    return get_theme_mod('hero_title', '¡Bienvenido a Todo Tops!');
}

// Get hero subtitle from customizer
function todo_tops_get_hero_subtitle() {
    return get_theme_mod('hero_subtitle', 'La mejor tienda virtual con productos de calidad premium');
}

// Get contact phone from customizer
function todo_tops_get_contact_phone() {
    return get_theme_mod('contact_phone', '+1 (555) 123-4567');
}

// Get contact email from customizer
function todo_tops_get_contact_email() {
    return get_theme_mod('contact_email', 'info@todotops.com');
}

// Get WhatsApp number from customizer
function todo_tops_get_whatsapp_number() {
    return get_theme_mod('whatsapp_number', '1234567890');
}

/**
 * Security Enhancements
 */

// Remove WordPress version from head
remove_action('wp_head', 'wp_generator');

// Disable file editing from admin
define('DISALLOW_FILE_EDIT', true);

/**
 * Performance Optimizations
 */

// Remove query strings from static resources
function todo_tops_remove_query_strings($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'todo_tops_remove_query_strings', 10, 1);
add_filter('script_loader_src', 'todo_tops_remove_query_strings', 10, 1);

// Defer parsing of JavaScript
function todo_tops_defer_parsing_of_js($url) {
    if (is_admin()) return $url;
    if (FALSE === strpos($url, '.js')) return $url;
    if (strpos($url, 'jquery.js')) return $url;
    return str_replace(' src', ' defer src', $url);
}
add_filter('script_loader_tag', 'todo_tops_defer_parsing_of_js', 10, 1);
?>