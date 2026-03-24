<?php
/**
 * 搜索表单模板
 *
 * @package Beihai_Blog
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>" style="
    display: flex;
    max-width: 480px;
    margin: 0 auto;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    overflow: hidden;
    background: var(--bg-white);
">
    <input type="search" class="search-field" placeholder="<?php echo esc_attr_x('搜索文章...', 'placeholder', 'beihai-blog'); ?>" 
        value="<?php echo get_search_query(); ?>" name="s" style="
        flex: 1;
        padding: 12px 16px;
        border: none;
        outline: none;
        font-size: 1rem;
        background: transparent;
    "/>
    <button type="submit" class="search-submit" style="
        padding: 12px 24px;
        background: var(--primary-color);
        color: #fff;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 500;
        transition: var(--transition);
    ">
        <?php echo esc_html_x('搜索', 'submit button', 'beihai-blog'); ?>
    </button>
</form>
