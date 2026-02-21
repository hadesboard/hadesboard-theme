<?php
/**
 * HadesBoard Theme Functions
 *
 * @package HadesBoard
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

define('HADESBOARD_VERSION', '1.0.0');

/**
 * Theme Setup
 */
function hadesboard_setup() {
    // Load text domain for translations
    load_theme_textdomain('hadesboard', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable featured images
    add_theme_support('post-thumbnails');
    add_image_size('hadesboard-featured', 1200, 630, true);

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('منوی اصلی', 'hadesboard'),
        'footer'  => __('منوی فوتر', 'hadesboard'),
    ));

    // HTML5 support
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Custom logo support
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    // Responsive embeds
    add_theme_support('responsive-embeds');

    // Align wide support
    add_theme_support('align-wide');
}
add_action('after_setup_theme', 'hadesboard_setup');

/**
 * Enqueue Scripts and Styles
 */
function hadesboard_scripts() {
    // Main stylesheet
    wp_enqueue_style(
        'hadesboard-style',
        get_stylesheet_uri(),
        array(),
        HADESBOARD_VERSION
    );

    // Google Fonts - Vazirmatn (preconnect for performance)
    wp_enqueue_style(
        'hadesboard-fonts',
        'https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;700&display=swap',
        array(),
        null
    );

    // Add preconnect for Google Fonts
    add_filter('style_loader_tag', 'hadesboard_font_preconnect', 10, 2);

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'hadesboard_scripts');

/**
 * Add preconnect for Google Fonts
 */
function hadesboard_font_preconnect($html, $handle) {
    if ($handle === 'hadesboard-fonts') {
        $html = '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        $html .= '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
        $html .= '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;700&display=swap" media="print" onload="this.media=\'all\'">' . "\n";
        $html .= '<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;700&display=swap"></noscript>';
    }
    return $html;
}

/**
 * Register Sidebars
 */
function hadesboard_widgets_init() {
    register_sidebar(array(
        'name'          => __('سایدبار', 'hadesboard'),
        'id'            => 'sidebar-1',
        'description'   => __('ویجت‌های سایدبار را اینجا اضافه کنید.', 'hadesboard'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'hadesboard_widgets_init');

/**
 * Register Custom Post Type: Projects
 */
function hadesboard_register_projects() {
    $labels = array(
        'name'               => __('پروژه‌ها', 'hadesboard'),
        'singular_name'      => __('پروژه', 'hadesboard'),
        'menu_name'          => __('پروژه‌ها', 'hadesboard'),
        'add_new'            => __('افزودن پروژه', 'hadesboard'),
        'add_new_item'       => __('افزودن پروژه جدید', 'hadesboard'),
        'edit_item'          => __('ویرایش پروژه', 'hadesboard'),
        'new_item'           => __('پروژه جدید', 'hadesboard'),
        'view_item'          => __('مشاهده پروژه', 'hadesboard'),
        'search_items'       => __('جستجوی پروژه', 'hadesboard'),
        'not_found'          => __('پروژه‌ای یافت نشد', 'hadesboard'),
        'not_found_in_trash' => __('پروژه‌ای در زباله‌دان یافت نشد', 'hadesboard'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'project'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true,
    );

    register_post_type('project', $args);

    // Project Technologies Taxonomy
    register_taxonomy('project_tech', 'project', array(
        'labels' => array(
            'name'          => __('تکنولوژی‌ها', 'hadesboard'),
            'singular_name' => __('تکنولوژی', 'hadesboard'),
        ),
        'hierarchical' => false,
        'show_in_rest' => true,
        'rewrite'      => array('slug' => 'tech'),
    ));
}
add_action('init', 'hadesboard_register_projects');

/**
 * Add Project Meta Box for URL
 */
function hadesboard_project_meta_boxes() {
    add_meta_box(
        'hadesboard_project_url',
        __('لینک پروژه', 'hadesboard'),
        'hadesboard_project_url_callback',
        'project',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'hadesboard_project_meta_boxes');

function hadesboard_project_url_callback($post) {
    wp_nonce_field('hadesboard_project_url', 'hadesboard_project_url_nonce');
    $value = get_post_meta($post->ID, '_project_url', true);
    echo '<input type="url" id="project_url" name="project_url" value="' . esc_attr($value) . '" style="width:100%;" placeholder="https://example.com">';
}

function hadesboard_save_project_url($post_id) {
    if (!isset($_POST['hadesboard_project_url_nonce']) ||
        !wp_verify_nonce($_POST['hadesboard_project_url_nonce'], 'hadesboard_project_url')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['project_url'])) {
        update_post_meta($post_id, '_project_url', esc_url_raw($_POST['project_url']));
    }
}
add_action('save_post', 'hadesboard_save_project_url');

/**
 * SEO: Add Schema.org JSON-LD
 */
function hadesboard_schema_markup() {
    if (is_front_page()) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => get_theme_mod('hadesboard_name', get_bloginfo('name')),
            'jobTitle' => get_theme_mod('hadesboard_job_title', __('توسعه‌دهنده وردپرس', 'hadesboard')),
            'url' => home_url(),
            'sameAs' => array_filter(array(
                get_theme_mod('hadesboard_github'),
                get_theme_mod('hadesboard_telegram'),
            )),
        );
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }

    if (is_singular('post')) {
        global $post;
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => get_the_title(),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author(),
            ),
            'publisher' => array(
                '@type' => 'Person',
                'name' => get_bloginfo('name'),
            ),
            'mainEntityOfPage' => get_permalink(),
        );
        if (has_post_thumbnail()) {
            $schema['image'] = get_the_post_thumbnail_url(null, 'large');
        }
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }
}
add_action('wp_head', 'hadesboard_schema_markup');

/**
 * SEO: Optimize Meta Tags
 */
function hadesboard_meta_tags() {
    // Open Graph
    if (is_singular()) {
        global $post;
        echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta property="og:type" content="article">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
        if (has_post_thumbnail()) {
            echo '<meta property="og:image" content="' . esc_url(get_the_post_thumbnail_url(null, 'large')) . '">' . "\n";
        }
        if (has_excerpt()) {
            echo '<meta property="og:description" content="' . esc_attr(get_the_excerpt()) . '">' . "\n";
        }
    } else {
        echo '<meta property="og:title" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
        echo '<meta property="og:type" content="website">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(home_url()) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr(get_bloginfo('description')) . '">' . "\n";
    }
    echo '<meta property="og:locale" content="fa_IR">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";

    // Twitter Card
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
}
add_action('wp_head', 'hadesboard_meta_tags');

/**
 * Performance: Remove unnecessary stuff
 */
function hadesboard_cleanup() {
    // Remove emoji support
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');

    // Remove RSD link
    remove_action('wp_head', 'rsd_link');

    // Remove Windows Live Writer link
    remove_action('wp_head', 'wlwmanifest_link');

    // Remove shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');

    // Remove REST API link
    remove_action('wp_head', 'rest_output_link_wp_head');

    // Remove oEmbed discovery links
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    // Remove generator meta tag
    remove_action('wp_head', 'wp_generator');
}
add_action('init', 'hadesboard_cleanup');

/**
 * Performance: Disable embeds
 */
function hadesboard_disable_embeds() {
    wp_dequeue_script('wp-embed');
}
add_action('wp_footer', 'hadesboard_disable_embeds');

/**
 * Performance: Add resource hints
 */
function hadesboard_resource_hints($hints, $relation_type) {
    if ('preconnect' === $relation_type) {
        $hints[] = array(
            'href' => 'https://fonts.googleapis.com',
        );
        $hints[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    }
    return $hints;
}
add_filter('wp_resource_hints', 'hadesboard_resource_hints', 10, 2);

/**
 * Customizer Settings
 */
function hadesboard_customize_register($wp_customize) {
    // Theme Options Panel
    $wp_customize->add_panel('hadesboard_options', array(
        'title'       => __('تنظیمات هادس‌بورد', 'hadesboard'),
        'priority'    => 30,
    ));

    // Personal Info Section
    $wp_customize->add_section('hadesboard_personal', array(
        'title'    => __('اطلاعات شخصی', 'hadesboard'),
        'panel'    => 'hadesboard_options',
        'priority' => 10,
    ));

    // Name
    $wp_customize->add_setting('hadesboard_name', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hadesboard_name', array(
        'label'   => __('نام', 'hadesboard'),
        'section' => 'hadesboard_personal',
        'type'    => 'text',
    ));

    // Job Title
    $wp_customize->add_setting('hadesboard_job_title', array(
        'default'           => __('توسعه‌دهنده وردپرس', 'hadesboard'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hadesboard_job_title', array(
        'label'   => __('عنوان شغلی', 'hadesboard'),
        'section' => 'hadesboard_personal',
        'type'    => 'text',
    ));

    // About Text
    $wp_customize->add_setting('hadesboard_about', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('hadesboard_about', array(
        'label'   => __('درباره من', 'hadesboard'),
        'section' => 'hadesboard_personal',
        'type'    => 'textarea',
    ));

    // Skills
    $wp_customize->add_setting('hadesboard_skills', array(
        'default'           => 'WordPress, PHP, WooCommerce, JavaScript, MySQL, HTML/CSS, Git',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hadesboard_skills', array(
        'label'       => __('مهارت‌ها', 'hadesboard'),
        'description' => __('با کاما جدا کنید', 'hadesboard'),
        'section'     => 'hadesboard_personal',
        'type'        => 'text',
    ));

    // Social Links Section
    $wp_customize->add_section('hadesboard_social', array(
        'title'    => __('لینک‌های ارتباطی', 'hadesboard'),
        'panel'    => 'hadesboard_options',
        'priority' => 20,
    ));

    // Phone
    $wp_customize->add_setting('hadesboard_phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hadesboard_phone', array(
        'label'   => __('تلفن', 'hadesboard'),
        'section' => 'hadesboard_social',
        'type'    => 'text',
    ));

    // Email
    $wp_customize->add_setting('hadesboard_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('hadesboard_email', array(
        'label'   => __('ایمیل', 'hadesboard'),
        'section' => 'hadesboard_social',
        'type'    => 'email',
    ));

    // Telegram
    $wp_customize->add_setting('hadesboard_telegram', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hadesboard_telegram', array(
        'label'   => __('تلگرام', 'hadesboard'),
        'section' => 'hadesboard_social',
        'type'    => 'url',
    ));

    // GitHub
    $wp_customize->add_setting('hadesboard_github', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hadesboard_github', array(
        'label'   => __('گیت‌هاب', 'hadesboard'),
        'section' => 'hadesboard_social',
        'type'    => 'url',
    ));

    // Homepage Sections
    $wp_customize->add_section('hadesboard_homepage', array(
        'title'    => __('بخش‌های صفحه اصلی', 'hadesboard'),
        'panel'    => 'hadesboard_options',
        'priority' => 30,
    ));

    // Show Projects
    $wp_customize->add_setting('hadesboard_show_projects', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('hadesboard_show_projects', array(
        'label'   => __('نمایش پروژه‌ها', 'hadesboard'),
        'section' => 'hadesboard_homepage',
        'type'    => 'checkbox',
    ));

    // Projects Count
    $wp_customize->add_setting('hadesboard_projects_count', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('hadesboard_projects_count', array(
        'label'   => __('تعداد پروژه‌ها', 'hadesboard'),
        'section' => 'hadesboard_homepage',
        'type'    => 'number',
    ));

    // Show Blog
    $wp_customize->add_setting('hadesboard_show_blog', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('hadesboard_show_blog', array(
        'label'   => __('نمایش بلاگ', 'hadesboard'),
        'section' => 'hadesboard_homepage',
        'type'    => 'checkbox',
    ));

    // Blog Count
    $wp_customize->add_setting('hadesboard_blog_count', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('hadesboard_blog_count', array(
        'label'   => __('تعداد پست‌ها', 'hadesboard'),
        'section' => 'hadesboard_homepage',
        'type'    => 'number',
    ));

    // Section Titles
    $wp_customize->add_setting('hadesboard_skills_title', array(
        'default'           => __('چیزایی که بابتشون پول می‌گیرم', 'hadesboard'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hadesboard_skills_title', array(
        'label'   => __('عنوان بخش مهارت‌ها', 'hadesboard'),
        'section' => 'hadesboard_homepage',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('hadesboard_projects_title', array(
        'default'           => __('چیزایی که ساختم و هنوز زنده‌ان', 'hadesboard'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hadesboard_projects_title', array(
        'label'   => __('عنوان بخش پروژه‌ها', 'hadesboard'),
        'section' => 'hadesboard_homepage',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('hadesboard_blog_title', array(
        'default'           => __('چرت و پرت‌هایی که می‌نویسم', 'hadesboard'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hadesboard_blog_title', array(
        'label'   => __('عنوان بخش بلاگ', 'hadesboard'),
        'section' => 'hadesboard_homepage',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('hadesboard_contact_title', array(
        'default'           => __('اگه کار داشتین', 'hadesboard'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hadesboard_contact_title', array(
        'label'   => __('عنوان بخش تماس', 'hadesboard'),
        'section' => 'hadesboard_homepage',
        'type'    => 'text',
    ));
}
add_action('customize_register', 'hadesboard_customize_register');

/**
 * Helper: Get reading time
 */
function hadesboard_reading_time($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200);
    return sprintf(_n('%d دقیقه مطالعه', '%d دقیقه مطالعه', $reading_time, 'hadesboard'), $reading_time);
}

/**
 * Helper: Persian date
 */
function hadesboard_persian_date($format = 'Y/m/d') {
    if (function_exists('jdate')) {
        return jdate($format);
    }
    return get_the_date($format);
}

/**
 * Helper: Convert Persian/Arabic numerals to English
 */
function hadesboard_persian_to_english($string) {
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $arabic  = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $english = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

    $string = str_replace($persian, $english, $string);
    $string = str_replace($arabic, $english, $string);

    return $string;
}

/**
 * Include additional files
 */
require_once get_template_directory() . '/inc/template-tags.php';
