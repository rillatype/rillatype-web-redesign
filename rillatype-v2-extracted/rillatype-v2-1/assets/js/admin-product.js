(function ($) {
  'use strict';

  var frame;

  $(document).on('click', '.rillatype-upload-tester-font', function (event) {
    event.preventDefault();

    if (frame) {
      frame.open();
      return;
    }

    frame = wp.media({
      title: 'Choose tester font file',
      button: { text: 'Use this font' },
      multiple: false,
    });

    frame.on('select', function () {
      var attachment = frame.state().get('selection').first().toJSON();
      $('#_rillatype_tester_font_url').val(attachment.url).trigger('change');
    });

    frame.open();
  });

  $(document).on('click', '.rillatype-clear-tester-font', function (event) {
    event.preventDefault();
    $('#_rillatype_tester_font_url').val('').trigger('change');
  });
})(jQuery);
