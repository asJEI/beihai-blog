    </main><!-- #primary -->

    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-content">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <?php dynamic_sidebar('footer-1'); ?>
                <?php else : ?>
                    <div class="footer-widget">
                        <h3><?php _e('关于博客', 'beihai-blog'); ?></h3>
                        <p><?php bloginfo('description'); ?></p>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-2')) : ?>
                    <?php dynamic_sidebar('footer-2'); ?>
                <?php else : ?>
                    <div class="footer-widget">
                        <h3><?php _e('快速链接', 'beihai-blog'); ?></h3>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_class'     => 'footer-menu',
                            'container'      => false,
                            'fallback_cb'    => false,
                            'depth'          => 1,
                        ));
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-3')) : ?>
                    <?php dynamic_sidebar('footer-3'); ?>
                <?php else : ?>
                    <div class="footer-widget">
                        <h3><?php _e('联系方式', 'beihai-blog'); ?></h3>
                        <p><?php _e('如有任何问题或建议，欢迎随时与我联系。', 'beihai-blog'); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="footer-bottom">
                <div class="copyright">
                    <?php
                    printf(
                        __('&copy; %s %s. 保留所有权利。', 'beihai-blog'),
                        date('Y'),
                        get_bloginfo('name')
                    );
                    ?>
                </div>
                <div class="theme-credit">
                    <?php _e('主题：北海博客', 'beihai-blog'); ?>
                </div>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
