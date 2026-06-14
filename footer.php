  <footer id="colophon" class="site-footer">
    <div class="footer-inner container">
      <div class="footer-links">
        <?php if (has_nav_menu('footer')) : ?>
          <?php
          wp_nav_menu(array(
            'theme_location' => 'footer',
            'container'      => false,
            'items_wrap'     => '%3$s',
            'fallback_cb'    => false,
            'depth'          => 1,
          ));
          ?>
        <?php else : ?>
          <a href="https://instagram.com/rillatype" rel="me" target="_blank" rel="noopener">Instagram</a>
          <a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact', 'rillatype-v2'); ?></a>
          <a href="<?php echo esc_url(home_url('/font-license/')); ?>"><?php esc_html_e('License', 'rillatype-v2'); ?></a>
          <a href="<?php echo esc_url(home_url('/privacy/')); ?>"><?php esc_html_e('Privacy', 'rillatype-v2'); ?></a>
          <a href="<?php echo esc_url(home_url('/terms/')); ?>"><?php esc_html_e('Terms', 'rillatype-v2'); ?></a>
        <?php endif; ?>
      </div>
      <p class="footer-copy">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
    </div>
  </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
