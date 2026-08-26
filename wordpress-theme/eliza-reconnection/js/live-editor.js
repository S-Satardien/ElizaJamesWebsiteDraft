
(function ($) {
  'use strict';

  $(document).ready(function () {
    let isEditMode = true;
    const editableSelectors = 'h1, h2, h3, h4, p, .lede, .hero-subtitle, .tag, .card-subtitle, .box-label, .btn, .eyebrow, .glass-chip span:not(.pulse-dot), .portrait-floating-badge, .bio-photo-badge, .bio-photo-caption p';

    // Initialize Edit Mode
    function enableLiveEditing() {
      $('body').addClass('eliza-edit-active');
      $('#main').find(editableSelectors).each(function () {
        $(this).attr('contenteditable', 'true');
        $(this).attr('spellcheck', 'false');
      });

      // Wrap images for click-to-change
      $('#main img').each(function () {
        if (!$(this).parent().hasClass('eliza-editable-img-wrap')) {
          $(this).wrap('<div class="eliza-editable-img-wrap"></div>');
        }
      });
    }

    function disableLiveEditing() {
      $('body').removeClass('eliza-edit-active');
      $('#main').find('[contenteditable="true"]').removeAttr('contenteditable');
    }

    // Toggle Edit Mode Button
    $('#eliza-toggle-edit-mode').on('click', function () {
      isEditMode = !isEditMode;
      if (isEditMode) {
        enableLiveEditing();
        $('#eliza-mode-label').text('Editing Active');
        $(this).removeClass('eliza-btn-preview');
        showToast('✏️ Edit Mode Active - Click any text or image');
      } else {
        disableLiveEditing();
        $('#eliza-mode-label').text('Preview Mode');
        $(this).addClass('eliza-btn-preview');
        showToast('👁️ Preview Mode Active');
      }
    });

    // Image Click Handler (WordPress Media Uploader)
    $(document).on('click', '.eliza-editable-img-wrap', function (e) {
      if (!isEditMode) return;
      e.preventDefault();
      const $img = $(this).find('img');

      if (typeof wp !== 'undefined' && wp.media) {
        const customUploader = wp.media({
          title: 'Select or Upload Replacement Image',
          button: { text: 'Use This Photo' },
          multiple: false
        });

        customUploader.on('select', function () {
          const attachment = customUploader.state().get('selection').first().toJSON();
          $img.attr('src', attachment.url);
          showToast('✓ Photo swapped! Click Save Changes.');
        });

        customUploader.open();
      } else {
        const newUrl = prompt('Enter image URL:', $img.attr('src'));
        if (newUrl) {
          $img.attr('src', newUrl);
          showToast('✓ Photo URL updated! Click Save Changes.');
        }
      }
    });

    // Save Changes via AJAX
    $('#eliza-save-live-btn').on('click', function () {
      const $btn = $(this);
      $btn.prop('disabled', true).find('span:last').text('Saving...');

      // Clone #main to clean live-editor temporary wrappers
      const $clone = $('#main').clone();
      $clone.find('[contenteditable]').removeAttr('contenteditable').removeAttr('spellcheck');
      $clone.find('.eliza-editable-img-wrap').each(function () {
        const $innerImg = $(this).find('img');
        $(this).replaceWith($innerImg);
      });

      const cleanHtml = $clone.html().trim();

      $.ajax({
        url: eliza_live_editor.ajax_url,
        type: 'POST',
        data: {
          action: 'eliza_save_live_page',
          nonce: eliza_live_editor.nonce,
          post_id: eliza_live_editor.post_id,
          content: cleanHtml
        },
        success: function (res) {
          $btn.prop('disabled', false).find('span:last').text('Save Changes');
          if (res.success) {
            showToast('✓ ' + res.data.message);
          } else {
            showToast('❌ Error: ' + (res.data.message || 'Could not save.'));
          }
        },
        error: function () {
          $btn.prop('disabled', false).find('span:last').text('Save Changes');
          showToast('❌ Network error while saving changes.');
        }
      });
    });

    function showToast(msg) {
      const $toast = $('#eliza-live-toast');
      $toast.text(msg).addClass('show');
      setTimeout(function () {
        $toast.removeClass('show');
      }, 3500);
    }

    // Auto-enable upon loading
    enableLiveEditing();
    console.log('Eliza Frontend Live Visual Editor initialized!');
  });
})(jQuery);
