<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- 固定导航栏 -->
<header class="site-header">
    <div class="header-container">
        <!-- 左侧：站点Logo -->
        <div class="header-left">
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <div class="site-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (display_header_text() || !has_custom_logo()) : ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                <?php endif; ?>
            </div>
        </div>

        <!-- 中间：主导航菜单 -->
        <nav class="main-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class'     => 'nav-menu',
                'container'      => false,
                'fallback_cb'    => false,
            ));
            ?>
            
            <!-- 移动端菜单按钮 -->
            <button class="menu-toggle" aria-label="<?php esc_attr_e('切换菜单', 'beihai-blog'); ?>" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </nav>

        <!-- 右侧：搜索栏 -->
        <div class="header-right">
            <div class="header-search">
                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="search" 
                           class="search-field" 
                           placeholder="<?php echo esc_attr_x('搜索文章...', 'placeholder', 'beihai-blog'); ?>" 
                           value="<?php echo get_search_query(); ?>" 
                           name="s" />
                    <button type="submit" class="search-submit" aria-label="<?php esc_attr_e('搜索', 'beihai-blog'); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                    </button>
                </form>
                <!-- 移动端搜索按钮 -->
                <button class="mobile-search-toggle" aria-label="<?php esc_attr_e('打开搜索', 'beihai-blog'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- 移动端搜索面板 -->
    <div class="mobile-search-panel">
        <form role="search" method="get" class="mobile-search-form" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="search" 
                   class="mobile-search-field" 
                   placeholder="<?php echo esc_attr_x('搜索站内文章...', 'placeholder', 'beihai-blog'); ?>" 
                   value="<?php echo get_search_query(); ?>" 
                   name="s" 
                   autocomplete="off" />
            <button type="submit" class="mobile-search-submit">
                <?php echo esc_html_x('搜索', 'submit button', 'beihai-blog'); ?>
            </button>
        </form>
        <button class="mobile-search-close" aria-label="<?php esc_attr_e('关闭搜索', 'beihai-blog'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
            </svg>
        </button>
    </div>
</header>

<!-- 横幅区域（仅在首页显示） -->
<?php if (is_front_page() || is_home()) : ?>
    <?php
    $hero_bg = get_theme_mod('hero_background_image', '');
    $hero_title = get_theme_mod('hero_title', __('欢迎来到北海博客', 'beihai-blog'));
    $hero_desc = get_theme_mod('hero_description', __('记录生活，分享思考，探索技术的无限可能', 'beihai-blog'));
    $show_greeting = get_theme_mod('show_greeting', true);
    $greeting = beihai_get_greeting();
    ?>
    
    <section class="hero-banner">
        <div class="hero-background" <?php if ($hero_bg) echo 'style="background-image: url(' . esc_url($hero_bg) . ');"'; ?>></div>
        
        <div class="hero-content">
            <?php if ($show_greeting) : ?>
                <div class="hero-greeting">
                    <span class="greeting-icon"><?php echo esc_html($greeting['icon']); ?></span>
                    <span class="greeting-text"><?php echo esc_html($greeting['text']); ?></span>
                </div>
            <?php endif; ?>
            
            <h2 class="hero-title"><?php echo esc_html($hero_title); ?></h2>
            <p class="hero-description"><?php echo esc_html($hero_desc); ?></p>
        </div>
    </section>
<?php endif; ?>

<!-- 作者信息悬浮框（左侧） -->
<?php
$author_name = get_theme_mod('author_name', get_bloginfo('name'));
$author_description = get_theme_mod('author_description', '');
$author_avatar = get_theme_mod('author_avatar', '');
$author_signature = get_theme_mod('author_signature', __('心之所向，素履以往', 'beihai-blog'));
$show_author_widget = get_theme_mod('show_author_widget', true);

if ($show_author_widget) :
?>
<div class="author-float-widget" id="authorFloatWidget">
    <button class="author-float-toggle" aria-label="<?php esc_attr_e('展开/收起作者信息', 'beihai-blog'); ?>">
        <span class="author-toggle-icon">👤</span>
        <span class="author-toggle-text"><?php _e('关于', 'beihai-blog'); ?></span>
    </button>
    <div class="author-float-content">
        <div class="author-float-header">
            <button class="author-float-close" aria-label="<?php esc_attr_e('关闭', 'beihai-blog'); ?>">×</button>
        </div>
        <div class="author-info">
            <?php if ($author_avatar) : ?>
                <div class="author-avatar">
                    <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>">
                </div>
            <?php else : ?>
                <div class="author-avatar-default">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
            <?php endif; ?>
            <h3 class="author-name"><?php echo esc_html($author_name); ?></h3>
            <?php if ($author_description) : ?>
                <p class="author-bio"><?php echo esc_html($author_description); ?></p>
            <?php endif; ?>
            
            <!-- 随笔栏（个人签名） -->
            <?php if ($author_signature) : ?>
                <div class="author-signature">
                    <span class="signature-quote">"</span>
                    <p class="signature-text"><?php echo esc_html($author_signature); ?></p>
                    <span class="signature-quote">"</span>
                </div>
            <?php endif; ?>
            
            <!-- 日间/夜间模式切换开关 -->
            <div class="theme-switcher">
                <span class="theme-label"><?php _e('主题', 'beihai-blog'); ?></span>
                <button class="theme-toggle" id="themeToggle" aria-label="<?php esc_attr_e('切换日间/夜间模式', 'beihai-blog'); ?>" aria-pressed="false">
                    <span class="theme-toggle-track">
                        <span class="theme-toggle-thumb">
                            <span class="theme-icon-light">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="5"></circle>
                                    <path d="M12 1v2"></path>
                                    <path d="M12 21v2"></path>
                                    <path d="M4.22 4.22l1.42 1.42"></path>
                                    <path d="M18.36 18.36l1.42 1.42"></path>
                                    <path d="M1 12h2"></path>
                                    <path d="M21 12h2"></path>
                                    <path d="M4.22 19.78l1.42-1.42"></path>
                                    <path d="M18.36 5.64l1.42-1.42"></path>
                                </svg>
                            </span>
                            <span class="theme-icon-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
                                </svg>
                            </span>
                        </span>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- 主内容区域开始 -->
<main id="primary" class="site-main">
