<?php
/**
 * 自定义模板标签
 *
 * @package Beihai_Blog
 */

/**
 * 获取文章字数（中文按字符、英文按单词）
 *
 * @param int|null $post_id Post ID.
 * @return int
 */
function beihai_get_word_count($post_id = null)
{
    $post = get_post($post_id);
    if (!$post) {
        return 0;
    }

    $content = strip_shortcodes($post->post_content);
    $content = wp_strip_all_tags($content);
    $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');

    preg_match_all('/[\x{4e00}-\x{9fff}\x{3400}-\x{4dbf}\x{f900}-\x{faf}]/u', $content, $cjk_matches);
    $cjk_count = count($cjk_matches[0]);

    $latin_content = preg_replace('/[\x{4e00}-\x{9fff}\x{3400}-\x{4dbf}\x{f900}-\x{faf}]/u', ' ', $content);
    $latin_content = preg_replace('/[^\p{L}\p{N}\']/u', ' ', $latin_content);
    $latin_words = preg_split('/\s+/u', trim($latin_content), -1, PREG_SPLIT_NO_EMPTY);
    $latin_count = is_array($latin_words) ? count($latin_words) : 0;

    return $cjk_count + $latin_count;
}

/**
 * 获取阅读时长（分钟）
 *
 * @param int|null $post_id Post ID.
 * @return int
 */
function beihai_get_reading_minutes($post_id = null)
{
    $post = get_post($post_id);
    if (!$post) {
        return 1;
    }

    $content = strip_shortcodes($post->post_content);
    $content = wp_strip_all_tags($content);
    $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');

    preg_match_all('/[\x{4e00}-\x{9fff}\x{3400}-\x{4dbf}\x{f900}-\x{faf}]/u', $content, $cjk_matches);
    $cjk_count = count($cjk_matches[0]);

    $latin_content = preg_replace('/[\x{4e00}-\x{9fff}\x{3400}-\x{4dbf}\x{f900}-\x{faf}]/u', ' ', $content);
    $latin_content = preg_replace('/[^\p{L}\p{N}\']/u', ' ', $latin_content);
    $latin_words = preg_split('/\s+/u', trim($latin_content), -1, PREG_SPLIT_NO_EMPTY);
    $latin_count = is_array($latin_words) ? count($latin_words) : 0;

    $minutes = ($cjk_count / 300) + ($latin_count / 200);

    return max(1, (int) ceil($minutes));
}

/**
 * 输出阅读时长标签
 *
 * @param int|null $post_id Post ID.
 * @return string
 */
function beihai_reading_time($post_id = null)
{
    $minutes = beihai_get_reading_minutes($post_id);

    return sprintf(
        esc_html(_n('约 %d 分钟阅读', '约 %d 分钟阅读', $minutes, 'beihai-blog')),
        $minutes
    );
}

/**
 * 输出字数统计标签
 *
 * @param int|null $post_id Post ID.
 * @return string
 */
function beihai_word_count_label($post_id = null)
{
    $count = beihai_get_word_count($post_id);

    return sprintf(
        esc_html__('共 %d 字', 'beihai-blog'),
        $count
    );
}

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

/**
 * 文章卡片 meta 信息
 */
function beihai_post_card_meta()
{
    ?>
    <div class="post-meta">
        <span class="post-date">
            <time datetime="<?php echo esc_attr(get_the_date(DATE_W3C)); ?>">
                <?php echo esc_html(get_the_date('Y年m月d日')); ?>
            </time>
        </span>
        <span class="post-author">
            <?php echo esc_html(get_the_author()); ?>
        </span>
        <span class="post-reading-time">
            <?php echo esc_html(beihai_reading_time()); ?>
        </span>
        <?php if (has_category()) : ?>
            <span class="post-category">
                <?php the_category(', '); ?>
            </span>
        <?php endif; ?>
        <?php if (has_tag()) : ?>
            <span class="post-tags">
                <?php the_tags('', ', '); ?>
            </span>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * 是否启用侧边栏
 *
 * @return bool
 */
function beihai_has_sidebar()
{
    return (bool) get_theme_mod('beihai_enable_sidebar', false) && is_active_sidebar('sidebar-main');
}
