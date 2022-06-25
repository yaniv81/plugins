<?php

/**
 * city-17 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package city-17
 */
if (!defined('_S_VERSION')) {
// Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function city_17_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on city-17, use a find and replace
     * to change 'city-17' to the name of your theme in all the template files.
     */
    load_theme_textdomain('city-17', get_template_directory() . '/languages');

// Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

// This theme uses wp_nav_menu() in one location.
    register_nav_menus(
            array(
                'menu-1' => esc_html__('Primary', 'city-17'),
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
                    'city_17_custom_background_args',
                    array(
                        'default-color' => 'ffffff',
                        'default-image' => '',
                    )
            )
    );

// Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
            'custom-logo',
            array(
                'height' => 250,
                'width' => 250,
                'flex-width' => true,
                'flex-height' => true,
            )
    );
}

add_action('after_setup_theme', 'city_17_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function city_17_content_width() {
    $GLOBALS['content_width'] = apply_filters('city_17_content_width', 640);
}

add_action('after_setup_theme', 'city_17_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function city_17_widgets_init() {
    register_sidebar(
            array(
                'name' => esc_html__('Sidebar', 'city-17'),
                'id' => 'sidebar-1',
                'description' => esc_html__('Add widgets here.', 'city-17'),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2>',
            )
    );
}

add_action('widgets_init', 'city_17_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function city_17_scripts() {
    wp_enqueue_style('city-17-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_style_add_data('city-17-style', 'rtl', 'replace');

    wp_register_script('validate', '//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js', array('jquery'), _S_VERSION);
    wp_register_script('lp-js', get_template_directory_uri() . '/js/lp.js', array('jquery', 'validate'), _S_VERSION);

    if (is_page_template('template-contact.php')) {
        wp_enqueue_script('validate');
        wp_enqueue_script('lp-js');
    }

    $dataToBePassed = array(
        'ajax_url' => admin_url("admin-ajax.php"),
        'security' => wp_create_nonce('security-nonce')
    );

    wp_localize_script('lp-js', 'php_vars', $dataToBePassed);
}

add_action('wp_enqueue_scripts', 'city_17_scripts');

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
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

add_action('wp_ajax_nopriv_city17_update_db', 'city17_update_db');
add_action('wp_ajax_city17_update_db', 'city17_update_db');

function city17_update_db($args) {

    if (!check_ajax_referer('security-nonce', 'security')) {
        wp_send_json_error('Invalid security token sent.');
        wp_die();
    }

    if (empty(get_option('db_input'))) {
        echo "nodb";
        die();
    }
    $formdata = filter_input(INPUT_POST, 'formdata', FILTER_SANITIZE_STRING);
    parse_str($formdata, $formdataArry);
    $fname = $formdataArry['fname'];
    $lname = $formdataArry['lname'];
    $email = $formdataArry['email'];
    $phone = $formdataArry['phone'];
    $country = $formdataArry['select_country'];
    $date = $formdataArry['date'];

    global $wpdb;
    $table_name = $wpdb->prefix . get_option('db_input');

    $sql = "INSERT INTO `" . $table_name . "`";
    $sql .= " (`fname`, `lname`, `email`, `phone`, `country`, `date`)";
    $sql .= " VALUES";
    $sql .= " ('" . $fname . "', '" . $lname . "', '" . $email . "', '" . $phone . "', '" . $country . "' , '" . $date . "')";

    $post_id = $wpdb->query($sql);
    echo "ok";
    die();
}
