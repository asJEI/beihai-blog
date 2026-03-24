<?php
/**
 * 单篇文章模板
 *
 * @package Beihai_Blog
 */

get_header();
?>

<div class="content-area">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="entry-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <h1 class="entry-title"><?php the_title(); ?></h1>
                
                <div class="entry-meta">
                    <span class="posted-on">
                        <?php _e('发布于：', 'beihai-blog'); ?>
                        <time datetime="<?php echo esc_attr(get_the_date(DATE_W3C)); ?>">
                            <?php echo esc_html(get_the_date('Y年m月d日')); ?>
                        </time>
                    </span>
                    <span class="byline">
                        <?php _e('作者：', 'beihai-blog'); ?>
                        <?php the_author_posts_link(); ?>
                    </span>
                    <?php if (has_category()) : ?>
                        <span class="cat-links">
                            <?php _e('分类：', 'beihai-blog'); ?>
                            <?php the_category(', '); ?>
                        </span>
                    <?php endif; ?>
                    <?php if (has_tag()) : ?>
                        <span class="tags-links">
                            <?php _e('标签：', 'beihai-blog'); ?>
                            <?php the_tags('', ', '); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </header>

            <div class="entry-content">
                <?php
                the_content();

                wp_link_pages(array(
                    'before' => '<div class="page-links">' . __('页码：', 'beihai-blog'),
                    'after'  => '</div>',
                ));
                ?>
            </div>

            <footer class="entry-footer">
                <?php
                // 上一篇/下一篇导航
                the_post_navigation(array(
                    'prev_text' => '<span class="nav-subtitle">' . __('← 上一篇', 'beihai-blog') . '</span> <span class="nav-title">%title</span>',
                    'next_text' => '<span class="nav-subtitle">' . __('下一篇 →', 'beihai-blog') . '</span> <span class="nav-title">%title</span>',
                ));
                ?>
            </footer>
        </article>

        <?php
        // 显示评论区域
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;

    endwhile;
    ?>
</div>

<?php
get_footer();
