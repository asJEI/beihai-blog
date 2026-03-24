<?php
/**
 * 404页面模板
 *
 * @package Beihai_Blog
 */

get_header();
?>

<div class="content-area">
    <section class="error-404 not-found" style="text-align: center; padding: 64px 24px;">
        <header class="page-header">
            <h1 class="page-title" style="font-size: 6rem; font-weight: 700; color: var(--primary-color); margin-bottom: 16px;">404</h1>
            <p style="font-size: 1.25rem; color: var(--text-secondary); margin-bottom: 24px;">
                <?php _e('哎呀！页面找不到了。', 'beihai-blog'); ?>
            </p>
        </header>

        <div class="page-content">
            <p style="color: var(--text-secondary); margin-bottom: 32px;">
                <?php _e('您访问的页面可能已经删除、移动或暂时不可用。', 'beihai-blog'); ?>
            </p>

            <a href="<?php echo esc_url(home_url('/')); ?>" style="
                display: inline-block;
                padding: 12px 32px;
                background: var(--primary-color);
                color: #fff;
                border-radius: var(--radius-sm);
                font-weight: 500;
                transition: var(--transition);
            ">
                <?php _e('返回首页', 'beihai-blog'); ?>
            </a>
        </div>
    </section>
</div>

<?php
get_footer();
