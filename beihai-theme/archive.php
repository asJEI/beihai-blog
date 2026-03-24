<?php
/**
 * 归档页面模板
 *
 * @package Beihai_Blog
 */

get_header();
?>

<div class="content-area">
    <header class="page-header" style="margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid var(--border-color);">
        <?php
        the_archive_title('<h1 class="page-title" style="font-size: 1.75rem; font-weight: 600;">', '</h1>');
        the_archive_description('<p style="color: var(--text-secondary); margin-top: 12px;">', '</p>');
        ?>
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
        <div class="no-posts">
            <h2><?php _e('暂无文章', 'beihai-blog'); ?></h2>
            <p><?php _e('该分类暂无文章。', 'beihai-blog'); ?></p>
        </div>
    <?php endif; ?>
</div>

<?php
get_footer();
