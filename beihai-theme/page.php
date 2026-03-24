<?php
/**
 * 页面模板
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
                <h1 class="entry-title"><?php the_title(); ?></h1>
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
        </article>

        <?php
        // 显示评论区域（如果页面允许评论）
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;

    endwhile;
    ?>
</div>

<?php
get_footer();
