<?php
/**
 * 搜索结果模板
 *
 * @package Beihai_Blog
 */

get_header();
?>

<div class="content-area">
    <header class="page-header" style="margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid var(--border-color);">
        <h1 class="page-title" style="font-size: 1.75rem; font-weight: 600;">
            <?php
            printf(
                esc_html__('搜索结果: %s', 'beihai-blog'),
                '<span style="color: var(--primary-color);">' . get_search_query() . '</span>'
            );
            ?>
        </h1>
    </header>

    <?php if (have_posts()) : ?>
        <div class="post-list">
            <?php
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('post-thumbnail'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="post-content">
                        <div class="post-meta">
                            <span class="post-date">
                                <time datetime="<?php echo esc_attr(get_the_date(DATE_W3C)); ?>">
                                    <?php echo esc_html(get_the_date('Y年m月d日')); ?>
                                </time>
                            </span>
                            <span class="post-author">
                                <?php echo esc_html(get_the_author()); ?>
                            </span>
                        </div>
                        
                        <h2 class="post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
                        <div class="post-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="read-more">
                            <?php _e('阅读更多', 'beihai-blog'); ?> →
                        </a>
                    </div>
                </article>
                <?php
            endwhile;
            ?>
        </div>

        <div class="pagination">
            <?php
            echo paginate_links(array(
                'prev_text' => __('← 上一页', 'beihai-blog'),
                'next_text' => __('下一页 →', 'beihai-blog'),
            ));
            ?>
        </div>

    <?php else : ?>
        <div class="no-results" style="text-align: center; padding: 48px 24px;">
            <p style="font-size: 1.125rem; color: var(--text-secondary); margin-bottom: 24px;">
                <?php _e('没有找到匹配的结果。', 'beihai-blog'); ?>
            </p>
            <?php get_search_form(); ?>
        </div>
    <?php endif; ?>
</div>

<?php
get_footer();
