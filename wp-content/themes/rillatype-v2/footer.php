  <footer id="colophon" class="site-footer">
    <div class="container footer-inner">
      <div class="footer-links">
        <a href="<?php echo esc_url(home_url('/font-license/')); ?>"><?php esc_html_e('License', 'rillatype-v2'); ?></a>
        <a href="<?php echo esc_url(home_url('/privacy/')); ?>"><?php esc_html_e('Privacy', 'rillatype-v2'); ?></a>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact', 'rillatype-v2'); ?></a>
      </div>
      <p class="footer-copy">&copy; <?php echo date('Y'); ?> <a href="<?php echo esc_url(home_url('/')); ?>">Rillatype</a>. <?php esc_html_e('All rights reserved.', 'rillatype-v2'); ?></p>
    </div>
  </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
