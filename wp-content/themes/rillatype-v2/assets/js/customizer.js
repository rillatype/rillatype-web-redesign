/**
 * Rillatype V2 — Customizer Live Preview
 */
(function($) {
  var api = wp.customize;

  // Colors
  api('rillatype_accent_color', function(value) {
    value.bind(function(to) {
      document.documentElement.style.setProperty('--accent', to);
    });
  });
  api('rillatype_bg_color', function(value) {
    value.bind(function(to) {
      document.documentElement.style.setProperty('--bg', to);
    });
  });
  api('rillatype_text_color', function(value) {
    value.bind(function(to) {
      document.documentElement.style.setProperty('--text', to);
    });
  });
  api('rillatype_text_muted', function(value) {
    value.bind(function(to) {
      document.documentElement.style.setProperty('--text-muted', to);
    });
  });
  api('rillatype_border_color', function(value) {
    value.bind(function(to) {
      document.documentElement.style.setProperty('--border', to);
    });
  });

  // Logo text
  api('rillatype_logo_text', function(value) {
    value.bind(function(to) {
      $('.nav-logo').text(to);
    });
  });

  // Copyright
  api('rillatype_copyright', function(value) {
    value.bind(function(to) {
      if (to) {
        $('.footer-copy').html(to);
      } else {
        var year = new Date().getFullYear();
        $('.footer-copy').html('&copy; ' + year + ' <a href="/">Rillatype</a>. All rights reserved.');
      }
    });
  });

})(jQuery);
