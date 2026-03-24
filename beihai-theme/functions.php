<?php
/**
 * Beihai Blog Theme functions and definitions
 *
 * @package Beihai_Blog
 */

// 定义主题版本
if (!defined('BEIHAI_THEME_VERSION')) {
    define('BEIHAI_THEME_VERSION', '1.2.0');
}

// 加载模板标签文件
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * 主题设置和初始化
 */
function beihai_theme_setup()
{
    // 添加主题支持
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style',
    ));
    add_theme_support('responsive-embeds');
    add_theme_support('customize-selective-refresh-widgets');

    // 自定义背景支持
    add_theme_support('custom-background', array(
        'default-color' => 'f9fafb',
        'default-image' => '',
    ));

    // 自定义Logo支持
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // 注册导航菜单
    register_nav_menus(array(
        'primary' => __('主导航菜单', 'beihai-blog'),
        'footer'  => __('页脚菜单', 'beihai-blog'),
    ));

    // 设置特色图片尺寸
    set_post_thumbnail_size(800, 450, array('center', 'center'));
    add_image_size('post-thumbnail', 800, 450, true);
    add_image_size('hero-background', 1920, 600, true);
}
add_action('after_setup_theme', 'beihai_theme_setup');

/**
 * 根据东八时区获取当前时间问候语
 *
 * @return string 问候语
 */
function beihai_get_greeting()
{
    // 设置东八时区（北京时间）
    date_default_timezone_set('Asia/Shanghai');
    
    $hour = (int) date('G'); // 获取24小时制的小时数（0-23）
    
    if ($hour >= 5 && $hour < 12) {
        $greeting = '上午好';
        $icon = '☀️';
    } elseif ($hour >= 12 && $hour < 18) {
        $greeting = '下午好';
        $icon = '🌤️';
    } else {
        $greeting = '晚上好';
        $icon = '🌙';
    }
    
    return array(
        'text' => $greeting,
        'icon' => $icon,
    );
}

/**
 * 加载主题资源
 */
function beihai_enqueue_assets()
{
    // 主题样式
    wp_enqueue_style(
        'beihai-theme-style',
        get_stylesheet_uri(),
        array(),
        BEIHAI_THEME_VERSION
    );

    // 主题脚本
    wp_enqueue_script(
        'beihai-theme-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        BEIHAI_THEME_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'beihai_enqueue_assets');

/**
 * 添加自定义CSS变量（支持主题自定义）
 */
function beihai_custom_css()
{
    $hero_bg = get_theme_mod('hero_background_image', '');
    
    $custom_css = '';
    if (!empty($hero_bg)) {
        $custom_css .= ".hero-banner .hero-background { background-image: url('{$hero_bg}'); }";
    }
    
    if (!empty($custom_css)) {
        wp_add_inline_style('beihai-theme-style', $custom_css);
    }
}
add_action('wp_enqueue_scripts', 'beihai_custom_css', 20);

/**
 * 主题自定义器设置
 *
 * @param WP_Customize_Manager $wp_customize
 */
function beihai_customize_register($wp_customize)
{
    // Hero区域设置面板
    $wp_customize->add_section('hero_section', array(
        'title'    => __('横幅区域设置', 'beihai-blog'),
        'priority' => 50,
    ));

    // 横幅背景图片设置
    $wp_customize->add_setting('hero_background_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'hero_background_image',
        array(
            'label'       => __('横幅背景图片', 'beihai-blog'),
            'description' => __('建议尺寸：1920x600像素', 'beihai-blog'),
            'section'     => 'hero_section',
            'settings'    => 'hero_background_image',
        )
    ));

    // 横幅标题设置
    $wp_customize->add_setting('hero_title', array(
        'default'           => __('欢迎来到北海博客', 'beihai-blog'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('hero_title', array(
        'label'   => __('横幅标题', 'beihai-blog'),
        'section' => 'hero_section',
        'type'    => 'text',
    ));

    // 横幅描述设置
    $wp_customize->add_setting('hero_description', array(
        'default'           => __('记录生活，分享思考，探索技术的无限可能', 'beihai-blog'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('hero_description', array(
        'label'   => __('横幅描述', 'beihai-blog'),
        'section' => 'hero_section',
        'type'    => 'textarea',
    ));

    // 显示问候语开关
    $wp_customize->add_setting('show_greeting', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('show_greeting', array(
        'label'   => __('显示时间问候语', 'beihai-blog'),
        'section' => 'hero_section',
        'type'    => 'checkbox',
    ));

    // 作者信息设置面板
    $wp_customize->add_section('author_section', array(
        'title'    => __('作者信息悬浮框', 'beihai-blog'),
        'priority' => 51,
    ));

    // 显示作者悬浮框开关
    $wp_customize->add_setting('show_author_widget', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('show_author_widget', array(
        'label'   => __('显示作者信息悬浮框', 'beihai-blog'),
        'section' => 'author_section',
        'type'    => 'checkbox',
    ));

    // 作者名称
    $wp_customize->add_setting('author_name', array(
        'default'           => get_bloginfo('name'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('author_name', array(
        'label'   => __('作者名称', 'beihai-blog'),
        'section' => 'author_section',
        'type'    => 'text',
    ));

    // 作者头像
    $wp_customize->add_setting('author_avatar', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'author_avatar',
        array(
            'label'       => __('作者头像', 'beihai-blog'),
            'description' => __('建议尺寸：200x200像素，正方形', 'beihai-blog'),
            'section'     => 'author_section',
            'settings'    => 'author_avatar',
        )
    ));

    // 作者简介
    $wp_customize->add_setting('author_description', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('author_description', array(
        'label'       => __('作者简介', 'beihai-blog'),
        'description' => __('简短介绍作者的一句话', 'beihai-blog'),
        'section'     => 'author_section',
        'type'        => 'textarea',
    ));

    // 随笔栏（个人签名）
    $wp_customize->add_setting('author_signature', array(
        'default'           => __('心之所向，素履以往', 'beihai-blog'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('author_signature', array(
        'label'       => __('随笔栏（个人签名）', 'beihai-blog'),
        'description' => __('显示在作者信息下方的个人签名或座右铭', 'beihai-blog'),
        'section'     => 'author_section',
        'type'        => 'text',
    ));
}
add_action('customize_register', 'beihai_customize_register');

/**
 * 小工具区域注册
 */
function beihai_widgets_init()
{
    register_sidebar(array(
        'name'          => __('页脚区域 1', 'beihai-blog'),
        'id'            => 'footer-1',
        'description'   => __('页脚第一栏小工具区域', 'beihai-blog'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('页脚区域 2', 'beihai-blog'),
        'id'            => 'footer-2',
        'description'   => __('页脚第二栏小工具区域', 'beihai-blog'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('页脚区域 3', 'beihai-blog'),
        'id'            => 'footer-3',
        'description'   => __('页脚第三栏小工具区域', 'beihai-blog'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'beihai_widgets_init');

/**
 * 修改摘要长度
 */
function beihai_excerpt_length($length)
{
    return 120;
}
add_filter('excerpt_length', 'beihai_excerpt_length');

/**
 * 修改摘要后缀
 */
function beihai_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'beihai_excerpt_more');

/**
 * 添加自定义body类
 */
function beihai_body_classes($classes)
{
    if (is_singular()) {
        $classes[] = 'single-post';
    }
    return $classes;
}
add_filter('body_class', 'beihai_body_classes');
