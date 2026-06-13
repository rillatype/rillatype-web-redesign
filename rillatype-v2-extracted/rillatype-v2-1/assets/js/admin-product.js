(function ($) {
  'use strict';

  var frame;
  var targetInput;

  $(document).on('click', '.rillatype-upload-tester-font', function (event) {
    event.preventDefault();
    targetInput = $($(this).data('target'));

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
      if (targetInput && targetInput.length) {
        targetInput.val(attachment.url).trigger('change');
      }
    });

    frame.open();
  });

  $(document).on('click', '.rillatype-clear-tester-font', function (event) {
    event.preventDefault();
    $($(this).data('target')).val('').trigger('change');
  });
})(jQuery);
