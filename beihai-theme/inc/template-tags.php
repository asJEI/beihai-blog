<?php
/**
 * 自定义模板标签
 *
 * @package Beihai_Blog
 */

/**
 * 获取文章发布时间和阅读时间
 *
 * @return string
 */
function beihai_get_post_meta()
{
    $time_string = '<time datetime="%1$s">%2$s</time>';
    $time_string = sprintf(
        $time_string,
        esc_attr(get_the_date(DATE_W3C)),
        esc_html(get_the_date('Y年m月d日'))
    );

    $posted_on = sprintf(
        esc_html_x('发布于 %s', 'post date', 'beihai-blog'),
        $time_string
    );

    $byline = sprintf(
        esc_html_x('作者 %s', 'post author', 'beihai-blog'),
        '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
    );

    echo '<span class="posted-on">' . $posted_on . '</span><span class="byline">' . $byline . '</span>';
}

/**
 * 获取文章分类链接
 */
function beihai_get_category_list()
{
    if ('post' === get_post_type()) {
        $categories_list = get_the_category_list(esc_html__(', ', 'beihai-blog'));
        if ($categories_list) {
            printf('<span class="cat-links">' . esc_html__('分类: %1$s', 'beihai-blog') . '</span>', $categories_list);
        }
    }
}

/**
 * 获取文章标签列表
 */
function beihai_get_tag_list()
{
    if ('post' === get_post_type()) {
        $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'beihai-blog'));
        if ($tags_list) {
            printf('<span class="tags-links">' . esc_html__('标签: %1$s', 'beihai-blog') . '</span>', $tags_list);
        }
    }
}
