    </main><!-- #primary -->

    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-content">
                <!-- 左侧：归档菜单 -->
                <div class="footer-widget footer-archives">
                    <h3><?php _e('文章归档', 'beihai-blog'); ?></h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-archives',
                        'menu_class'     => 'footer-menu',
                        'container'      => false,
                        'fallback_cb'    => 'beihai_fallback_archives_menu',
                        'depth'          => 1,
                    ));
                    ?>
                </div>

                <!-- 中间：备案信息区域（空置HTML代码区） -->
                <div class="footer-widget footer-icp">
                    <h3><?php _e('备案信息', 'beihai-blog'); ?></h3>
                    <div class="icp-content">
                        <!-- 在此区域添加备案信息HTML代码 -->

                        <?php echo wp_kses_post(get_theme_mod('footer_icp_content', '')); ?>
                    </div>
                </div>

                <!-- 右侧：站外链接菜单 + 社交链接 -->
                <div class="footer-widget footer-links">
                    <h3><?php _e('站外链接', 'beihai-blog'); ?></h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-links',
                        'menu_class'     => 'footer-menu',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ));
                    ?>
                    
                    <!-- 社交/GitHub链接区域 -->
                    <div class="social-links">
                        <?php if (get_theme_mod('github_url', '')) : ?>
                            <a href="<?php echo esc_url(get_theme_mod('github_url')); ?>" target="_blank" rel="noopener noreferrer" class="social-link github" aria-label="GitHub">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('twitter_url', '')) : ?>
                            <a href="<?php echo esc_url(get_theme_mod('twitter_url')); ?>" target="_blank" rel="noopener noreferrer" class="social-link twitter" aria-label="Twitter">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('weibo_url', '')) : ?>
                            <a href="<?php echo esc_url(get_theme_mod('weibo_url')); ?>" target="_blank" rel="noopener noreferrer" class="social-link weibo" aria-label="微博">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M10.098 20.323c-3.977.391-7.414-1.406-7.672-4.02-.259-2.609 2.759-5.047 6.74-5.441 3.979-.394 7.413 1.404 7.671 4.018.259 2.6-2.759 5.049-6.739 5.443zM9.05 17.219c-.384.616-1.208.884-1.829.602-.612-.279-.793-.991-.406-1.593.379-.595 1.176-.861 1.793-.601.622.263.82.972.442 1.592zm1.27-1.627c-.141.237-.449.353-.689.253-.236-.09-.313-.361-.177-.586.138-.227.436-.346.672-.24.239.09.315.36.194.573zm.176-2.719c-1.893-.493-4.033.45-4.857 2.118-.836 1.704-.026 3.591 1.886 4.21 1.983.64 4.318-.341 5.132-2.179.8-1.793-.201-3.642-2.161-4.149zm7.563-1.224c-.346-.105-.579-.18-.405-.649.389-1.061.428-1.979.012-2.636-.789-1.187-2.924-1.123-5.383-.032 0 0-.768.334-.571-.271.383-1.206.324-2.213-.27-2.8-1.336-1.313-4.895.045-7.949 3.038-2.281 2.237-3.603 4.61-3.603 6.631 0 3.867 4.971 6.217 9.835 6.217 6.383 0 10.632-3.711 10.632-6.658 0-1.78-1.504-2.789-2.298-2.84z"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('rss_url', '') || get_bloginfo('rss2_url')) : ?>
                            <a href="<?php echo esc_url(get_theme_mod('rss_url', get_bloginfo('rss2_url'))); ?>" target="_blank" rel="noopener noreferrer" class="social-link rss" aria-label="RSS">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19.199 24C19.199 13.467 10.533 4.8 0 4.8V0c13.165 0 24 10.835 24 24h-4.801zM3.803 24c0-8.837 7.163-16 16-16v4.8c-6.186 0-11.2 5.014-11.2 11.2h-4.8zM12 24c0-2.209 1.791-4 4-4s4 1.791 4 4-1.791 4-4 4-4-1.791-4-4z"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
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
