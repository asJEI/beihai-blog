<?php
/**
 * 评论模板
 *
 * @package Beihai_Blog
 */

/*
 * 如果当前文章被密码保护，并且访问者没有输入密码，则不显示评论。
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    esc_html__('一条评论', 'beihai-blog'),
                    '<span>' . get_the_title() . '</span>'
                );
            } else {
                printf(
                    esc_html(_nx('%1$s 条评论', '%1$s 条评论', $comment_count, 'comments title', 'beihai-blog')),
                    number_format_i18n($comment_count),
                    '<span>' . get_the_title() . '</span>'
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size' => 56,
                'callback'   => 'beihai_comment_callback',
            ));
            ?>
        </ol>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <nav class="comment-navigation">
                <?php
                paginate_comments_links(array(
                    'prev_text' => '<span class="nav-prev">← ' . __('上一页', 'beihai-blog') . '</span>',
                    'next_text' => '<span class="nav-next">' . __('下一页', 'beihai-blog') . ' →</span>',
                ));
                ?>
            </nav>
        <?php endif; ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php esc_html_e('评论已关闭', 'beihai-blog'); ?></p>
    <?php endif; ?>

    <?php
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');
    $html_req = ($req ? " required='required'" : '');

    $fields = array(
        'author' => '<div class="comment-form-row"><div class="comment-form-field comment-form-author">' .
                    '<label for="author">' . __('昵称', 'beihai-blog') . ($req ? ' <span class="required">*</span>' : '') . '</label>' .
                    '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245"' . $aria_req . $html_req . ' placeholder="' . esc_attr__('您的昵称', 'beihai-blog') . '" /></div>',
        'email'  => '<div class="comment-form-field comment-form-email"><label for="email">' . __('邮箱', 'beihai-blog') . ($req ? ' <span class="required">*</span>' : '') . '</label>' .
                    '<input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $aria_req . $html_req . ' placeholder="' . esc_attr__('您的邮箱', 'beihai-blog') . '" /></div>',
        'url'    => '<div class="comment-form-field comment-form-url"><label for="url">' . __('网站', 'beihai-blog') . '</label>' .
                    '<input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" placeholder="' . esc_attr__('您的网站（选填）', 'beihai-blog') . '" /></div></div>',
    );

    $comments_args = array(
        'fields'               => $fields,
        'comment_field'        => '<div class="comment-form-comment"><label for="comment">' . _x('评论', 'noun', 'beihai-blog') . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="5" maxlength="65525" aria-required="true" required="required" placeholder="' . esc_attr__('写下您的想法...', 'beihai-blog') . '"></textarea></div>',
        'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s">%4$s</button>',
        'submit_field'         => '<div class="form-submit-wrapper">%1$s %2$s</div>',
        'title_reply'          => __('发表评论', 'beihai-blog'),
        'title_reply_to'       => __('回复 %s', 'beihai-blog'),
        'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
        'title_reply_after'    => '</h3>',
        'cancel_reply_before'  => '<span class="cancel-reply-link">',
        'cancel_reply_after'   => '</span>',
        'cancel_reply_link'    => __('取消回复', 'beihai-blog'),
        'label_submit'         => __('发送评论', 'beihai-blog'),
        'class_submit'         => 'submit-btn',
        'format'               => 'xhtml',
    );

    comment_form($comments_args);
    ?>

</div>
