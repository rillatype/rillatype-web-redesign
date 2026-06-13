(function ($) {
  'use strict';

  $('<style>.rillatype-product-preview-box .widefat td{vertical-align:middle}.rillatype-product-preview-box .widefat input[type=text]{min-width:180px}.rillatype-tester-font-name{display:block;max-width:320px;margin:0 0 8px;padding:8px 10px;background:#f6f7f7;border:1px solid #dcdcde;border-radius:4px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.rillatype-product-preview-box .button{margin:0 6px 8px 0}</style>').appendTo('head');

  var frame;
  var targetInput;
  var targetValueType;

  $(document).on('click', '.rillatype-upload-tester-font', function (event) {
    event.preventDefault();
    var button = $(this);
    targetInput = $(button.data('target'));
    targetValueType = button.data('value');

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
        targetInput.val(targetValueType === 'id' ? attachment.id : attachment.url).trigger('change');
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

  $(document).on('click', '.rillatype-add-font-row', function (event) {
    event.preventDefault();
    var table = $('.rillatype-font-data-table tbody');
    var index = table.find('tr').length;
    var row = table.find('tr:first').clone();

    row.find('input[type="text"]').val('');
    row.find('input[type="hidden"]').val('');
    row.find('.rillatype-tester-font-name').text('No font selected');
    row.find('input, button').each(function () {
      var el = $(this);
      var id = el.attr('id');
      var name = el.attr('name');

      if (name) el.attr('name', name.replace(/rillatype_font_data\[\d+\]/, 'rillatype_font_data[' + index + ']'));
      if (id) {
        var newId = id.replace(/_\d+$/, '_' + Date.now() + '_' + index);
        el.attr('id', newId);
        row.find('[data-target="#' + id + '"]').attr('data-target', '#' + newId);
      }
    });

    table.append(row);
  });

  $(document).on('click', '.rillatype-remove-font-row', function (event) {
    event.preventDefault();
    var rows = $('.rillatype-font-data-table tbody tr');
    if (rows.length > 1) {
      $(this).closest('tr').remove();
    }
  });
})(jQuery);
