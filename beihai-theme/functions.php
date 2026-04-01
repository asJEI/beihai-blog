<?php
/**
 * Beihai Blog Theme functions and definitions
 *
 * @package Beihai_Blog
 */

// 定义主题版本
if (!defined('BEIHAI_THEME_VERSION')) {
    define('BEIHAI_THEME_VERSION', '1.4.1');
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
        'primary'        => __('主导航菜单', 'beihai-blog'),
        'footer-archives' => __('页脚归档菜单', 'beihai-blog'),
        'footer-links'   => __('页脚站外链接菜单', 'beihai-blog'),
    ));

    // 设置特色图片尺寸
    set_post_thumbnail_size(800, 450, array('center', 'center'));
    add_image_size('post-thumbnail', 800, 450, true);
    add_image_size('hero-background', 1920, 600, true);
}
add_action('after_setup_theme', 'beihai_theme_setup');

/**
 * 归档菜单默认回调函数
 * 当没有设置归档菜单时显示默认的文章归档链接
 */
function beihai_fallback_archives_menu()
{
    $archives = wp_get_archives(array(
        'type'            => 'monthly',
        'limit'           => 6,
        'format'          => 'html',
        'before'          => '',
        'after'           => '',
        'show_post_count' => false,
        'echo'            => 0,
    ));
    
    if ($archives) {
        echo '<ul class="footer-menu archives-menu">';
        echo $archives;
        echo '</ul>';
    }
}

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

    // 页脚设置面板
    $wp_customize->add_section('footer_section', array(
        'title'    => __('页脚设置', 'beihai-blog'),
        'priority' => 52,
    ));

    // 备案信息HTML内容
    $wp_customize->add_setting('footer_icp_content', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('footer_icp_content', array(
        'label'       => __('备案信息HTML', 'beihai-blog'),
        'description' => __('在此输入备案信息HTML代码，例如ICP备案号、公安备案号等', 'beihai-blog'),
        'section'     => 'footer_section',
        'type'        => 'textarea',
    ));

    // GitHub链接
    $wp_customize->add_setting('github_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('github_url', array(
        'label'       => __('GitHub链接', 'beihai-blog'),
        'description' => __('输入GitHub个人主页链接', 'beihai-blog'),
        'section'     => 'footer_section',
        'type'        => 'url',
    ));

    // Twitter链接
    $wp_customize->add_setting('twitter_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('twitter_url', array(
        'label'       => __('Twitter链接', 'beihai-blog'),
        'description' => __('输入Twitter/X个人主页链接', 'beihai-blog'),
        'section'     => 'footer_section',
        'type'        => 'url',
    ));

    // 微博链接
    $wp_customize->add_setting('weibo_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('weibo_url', array(
        'label'       => __('微博链接', 'beihai-blog'),
        'description' => __('输入微博个人主页链接', 'beihai-blog'),
        'section'     => 'footer_section',
        'type'        => 'url',
    ));

    // 自定义RSS链接
    $wp_customize->add_setting('rss_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('rss_url', array(
        'label'       => __('自定义RSS链接', 'beihai-blog'),
        'description' => __('如不填写则使用WordPress默认RSS链接', 'beihai-blog'),
        'section'     => 'footer_section',
        'type'        => 'url',
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

/**
 * 自定义评论输出回调函数
 * 优化评论显示结构：日期时间以小字显示在右下角
 */
function beihai_comment_callback($comment, $args, $depth)
{
    $tag = ('div' === $args['style']) ? 'div' : 'li';
    $comment_classes = get_comment_class('', $comment);
    $comment_class_str = implode(' ', $comment_classes);
    ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" class="<?php echo esc_attr($comment_class_str); ?>">
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <div class="comment-author-avatar">
                <?php echo get_avatar($comment, $args['avatar_size']); ?>
            </div>
            <div class="comment-content-wrapper">
                <header class="comment-meta">
                    <div class="comment-author-info">
                        <?php printf('<span class="comment-author-name">%s</span>', get_comment_author_link($comment)); ?>
                        <?php if ($comment->user_id === get_the_author_meta('ID')) : ?>
                            <span class="author-badge"><?php _e('作者', 'beihai-blog'); ?></span>
                        <?php endif; ?>
                    </div>
                </header>
                <div class="comment-content">
                    <?php comment_text(); ?>
                    <?php if ($comment->comment_approved == '0') : ?>
                        <p class="comment-awaiting-moderation"><?php _e('您的评论正在等待审核。', 'beihai-blog'); ?></p>
                    <?php endif; ?>
                    <footer class="comment-footer-meta">
                        <time class="comment-time" datetime="<?php comment_time('c'); ?>">
                            <?php
                            printf(
                                __('%1$s %2$s', 'beihai-blog'),
                                get_comment_date('Y年m月d日', $comment),
                                get_comment_time('H:i', $comment)
                            );
                            ?>
                        </time>
                        <?php
                        comment_reply_link(array_merge($args, array(
                            'add_below' => 'div-comment',
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'],
                            'before'    => '<span class="reply-btn-wrapper">',
                            'after'     => '</span>',
                            'reply_text' => __('回复', 'beihai-blog'),
                        )));
                        ?>
                        <?php edit_comment_link(__('编辑', 'beihai-blog'), '<span class="edit-link">', '</span>'); ?>
                    </footer>
                </div>
            </div>
        </article>
    <?php
}

/**
 * 添加评论相关的 CSS 类
 */
function beihai_comment_class($classes, $class, $comment_id, $post_id)
{
    $classes[] = 'modern-comment';
    return $classes;
}
add_filter('comment_class', 'beihai_comment_class', 10, 4);
