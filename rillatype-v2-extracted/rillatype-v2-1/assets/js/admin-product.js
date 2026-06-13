(function ($) {
  'use strict';

  $('<style>.rillatype-tester-font-name{display:inline-block;max-width:260px;margin:0 8px 8px 0;padding:6px 10px;background:#f6f7f7;border:1px solid #dcdcde;border-radius:4px;vertical-align:middle;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.rillatype-tester-font-parent-field .button{margin:0 6px 8px 0}</style>').appendTo('head');

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
        targetInput.siblings('.rillatype-tester-font-name').text(attachment.filename || attachment.url.split('/').pop());
      }
    });

    frame.open();
  });

  $(document).on('click', '.rillatype-clear-tester-font', function (event) {
    event.preventDefault();
    var input = $($(this).data('target'));
    input.val('').trigger('change');
    input.siblings('.rillatype-tester-font-name').text('No font selected');
  });
})(jQuery);
