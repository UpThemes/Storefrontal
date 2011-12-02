            </div>
            <div id="footer">
                <div class="footer-holder">
                    <div class="footer-frame">
                        <?php dynamic_sidebar('about'); ?>
                        <?php if (is_active_sidebar('footer-section')) : ?>
                        <div class="block-holder">
                            <?php dynamic_sidebar('footer-section'); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
        </div>
        <?php wp_footer(); ?>
</body>
</html>