/**
 * Frontend Live Visual Editor Suite
 * Supports inline text editing, photo swapping, and button text & URL management.
 * @package Eliza_Reconnection
 */
(function ($) {
  'use strict';

  if (window.elizaLiveEditorInitialized) {
    return;
  }
  window.elizaLiveEditorInitialized = true;

  $(document).ready(function () {
    let isEditMode = true;
    let $activeTargetBtn = null;
    let lastActiveEditable = null;
    let isDockOpen = false;
    let savedSelectionRange = null;

    // Comprehensive list of all text elements across all page templates
    const editableSelectors = [
      'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
      'p', 'li', 'td', 'th', 'dt', 'dd',
      'blockquote', 'cite', 'figcaption',
      '.who', '.kind', '.stat-item strong', '.stat-item span',
      '.stat-item', '.remarks-columns li', '.testi-card p',
      '.lede', '.hero-subtitle', '.tag', '.card-subtitle', '.box-label',
      '.eyebrow', '.glass-chip span:not(.pulse-dot)',
      '.portrait-floating-badge', '.bio-photo-badge', '.bio-photo-caption p',
      '.author-bio-tagline', '.single-author-sub', '.tea-cta strong', '.tea-cta p',
      '.glass-box h4', '.glass-box p', '.glass-box li',
      '.video-footer-link', '.video-footer-link a', '.video-footer-link span',
      '.offer-callout', '.offer-highlight-box p', '.offer-highlight-box .box-label',
      '.channel-title', '.channel-tag', '.channel-desc', '.price-val', '.price-currency',
      '.intl-heading', '.intl-subtext'
    ].join(', ');

    // Button & Link selectors for interactive URL/text editing
    const buttonSelectors = [
      '.btn', '.btn-primary', '.btn-ghost', '.btn-ghost-light', '.btn-ghost-dark',
      '.btn-primary-presence', '.btn-solid-cta', '.btn-solid-pending', '.open-order-modal',
      '.retailer-grid-presence a', '.retailer-grid-presence button',
      '.video-footer-link a',
      '#main a[class*="btn"]', '#main button[class*="btn"]'
    ].join(', ');

    function escapeHtml(str) {
      return String(str || '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
    }

    // Initialize Edit Mode
    function enableLiveEditing() {
      $('body').addClass('eliza-edit-active');

      // Make all standard text selectors editable
      $('#main').find(editableSelectors).each(function () {
        $(this).attr('contenteditable', 'true').attr('spellcheck', 'false');
      });

      // Special cards and books order card text
      $('#main .testi-card, #main .glass-box, #main .stat-list, #main .remarks-columns, #main .book-order-horizontal').find('p, span:not(.pulse-dot):not(.btn-arrow):not(.arrow-up):not(.eliza-btn-url-badge), strong, em, li, div.who, span.kind').each(function () {
        $(this).attr('contenteditable', 'true').attr('spellcheck', 'false');
      });

      // Explicitly ensure books order card elements are editable
      $('#main').find('.channel-tag, .intl-heading, .channel-price, .price-val, .channel-title, .channel-desc, .intl-subtext').each(function () {
        $(this).attr('contenteditable', 'true').attr('spellcheck', 'false');
      });

      // Setup Buttons & Action Links
      $('#main').find(buttonSelectors).each(function () {
        const $btn = $(this);
        $btn.addClass('eliza-editable-btn-wrap');

        // Make button inner text editable (prefer .btn-text-content or first valid span)
        let $innerSpan = $btn.find('.btn-text-content').first();
        if (!$innerSpan.length) {
          $innerSpan = $btn.find('span:not(.btn-arrow):not(.arrow-up):not(.eliza-btn-url-badge)').first();
        }

        if ($innerSpan.length) {
          $innerSpan.attr('contenteditable', 'true').attr('spellcheck', 'false');
        } else {
          $btn.attr('contenteditable', 'true').attr('spellcheck', 'false');
        }

        // Attach visible [🔗 Edit URL] badge if not already attached
        if (!$btn.find('.eliza-btn-url-badge').length) {
          const $badge = $('<span class="eliza-btn-url-badge" title="Click to edit destination URL and button settings" contenteditable="false">🔗 Edit URL</span>');
          $btn.append($badge);
        }
      });

      // Wrap content images for click-to-change (exclude emojis, smileys, and icons)
      $('#main img:not(.emoji):not(.wp-smiley):not(.custom-logo):not(.icon-img)').each(function () {
        if (!$(this).parent().hasClass('eliza-editable-img-wrap')) {
          $(this).wrap('<div class="eliza-editable-img-wrap"></div>');
        }
      });

      // Wrap YouTube video frames for click-to-edit URL badge
      $('#main .video-frame, #main iframe[src*="youtube"]').each(function () {
        const $frame = $(this).is('.video-frame') ? $(this) : $(this).parent();
        if (!$frame.parent().hasClass('eliza-editable-video-wrap')) {
          $frame.wrap('<div class="eliza-editable-video-wrap"></div>');
        }
        const $wrap = $frame.parent();
        if (!$wrap.find('.eliza-video-edit-badge').length) {
          $wrap.append('<button type="button" class="eliza-video-edit-badge" title="Click to change YouTube Video URL" contenteditable="false">🎥 Change Video URL</button>');
        }
      });

      // Keep policy subnav chips and in-page anchor pills non-editable and badge-free
      $('#main .terms-subnav, #main .terms-nav-chip, #main [data-no-edit]').find('*').removeAttr('contenteditable');
      $('#main .terms-nav-chip, #main [data-no-edit]').removeAttr('contenteditable').removeClass('eliza-editable-btn-wrap');
      $('#main .terms-subnav .eliza-btn-url-badge, #main .terms-nav-chip .eliza-btn-url-badge').remove();
    }

    function disableLiveEditing() {
      $('body').removeClass('eliza-edit-active');
      $('#main').find('[contenteditable="true"]').removeAttr('contenteditable');
      $('#main .eliza-btn-url-badge').remove();
      $('#main .eliza-editable-btn-wrap').removeClass('eliza-editable-btn-wrap');
      $('#main .eliza-editable-img-wrap').each(function () {
        const $img = $(this).find('img');
        $(this).replaceWith($img);
      });
      $('#main .eliza-video-edit-badge').remove();
      $('#main .eliza-editable-video-wrap').each(function () {
        const $children = $(this).children();
        $(this).replaceWith($children);
      });
      closeLinkModal();
      closeFormatDock();
      $('#eliza-all-links-modal').removeClass('show').attr('aria-hidden', 'true');
    }

    // Toggle Edit Mode Button (delegated document listener)
    $(document).on('click', '#eliza-toggle-edit-mode', function () {
      isEditMode = !isEditMode;
      if (isEditMode) {
        enableLiveEditing();
        $('#eliza-mode-label').text('Editing Active');
        $(this).removeClass('eliza-btn-preview');
        showToast('✏️ Edit Mode Active - Click text to edit, click [🔗 Edit URL] on buttons to change links');
      } else {
        disableLiveEditing();
        $('#eliza-mode-label').text('Preview Mode');
        $(this).addClass('eliza-btn-preview');
        showToast('👁️ Preview Mode Active');
      }
    });

    // Prevent default button/link actions in Edit Mode so user can edit text without navigating
    $(document).on('click', '#main a, #main button', function (e) {
      if (!isEditMode) return;

      const $target = $(e.target);

      // 1. If clicking directly on the URL badge, open Link Modal
      if ($target.hasClass('eliza-btn-url-badge') || $target.closest('.eliza-btn-url-badge').length) {
        e.preventDefault();
        e.stopPropagation();
        const $btn = $(this).hasClass('eliza-editable-btn-wrap') ? $(this) : $(this).closest('.eliza-editable-btn-wrap');
        openLinkModal($btn);
        return false;
      }

      // If clicking an order modal trigger, open the order modal so admin can test checkout
      const $orderBtn = $(this).hasClass('open-order-modal') ? $(this) : $(this).closest('.open-order-modal');
      if ($orderBtn.length || $(this).attr('href') === '#authorOrderModal') {
        e.preventDefault();
        e.stopPropagation();
        if (typeof window.openOrderModal === 'function') {
          window.openOrderModal($orderBtn[0] || this);
        }
        return false;
      }

      // Check for in-page jump anchor links (e.g. #merchant-info, #delivery, #cancellations)
      const href = $(this).attr('href');
      if (href && href.startsWith('#') && href.length > 1) {
        const targetId = href.substring(1);
        const $targetEl = $(document.getElementById(targetId) || href);
        if ($targetEl.length) {
          e.preventDefault();
          e.stopPropagation();

          const adminBarH = $('#wpadminbar').outerHeight() || 0;
          const siteHeaderH = $('header.site-header, header').outerHeight() || 80;
          const subnavH = $('.terms-subnav').outerHeight() || 0;
          const totalOffset = adminBarH + siteHeaderH + subnavH + 16;
          const targetTop = $targetEl.offset().top - totalOffset;

          $('html, body').stop().animate({
            scrollTop: Math.max(0, targetTop)
          }, 350);

          $('.terms-nav-chip').removeClass('active');
          $(this).filter('.terms-nav-chip').addClass('active');

          if (window.history && window.history.pushState) {
            window.history.pushState(null, null, href);
          }
          return false;
        }
      }

      // 2. Prevent page navigation and form actions
      e.preventDefault();

      // 3. If clicking inside contenteditable text, keep focus there for inline typing
      if ($target.is('[contenteditable="true"]') || $target.closest('[contenteditable="true"]').length) {
        return;
      }

      // 4. If clicking on button container padding/background, focus its editable text
      const $btn = $(this).hasClass('eliza-editable-btn-wrap') ? $(this) : $(this).closest('.eliza-editable-btn-wrap');
      const $editableSpan = $btn.find('[contenteditable="true"]').first();
      if ($editableSpan.length) {
        $editableSpan.focus();
      }
    });

    // Double-click any button or link in edit mode to directly open URL Editor
    $(document).on('dblclick', '#main .eliza-editable-btn-wrap', function (e) {
      if (!isEditMode) return;
      e.preventDefault();
      e.stopPropagation();
      openLinkModal($(this));
    });

    // =========================================================================
    // ALL PAGE LINKS DRAWER / MODAL
    // =========================================================================
    $(document).on('click', '#eliza-manage-links-btn', function () {
      openAllLinksModal();
    });

    function openAllLinksModal() {
      const $list = $('#eliza-links-list');
      $list.empty();

      const $buttons = $('#main').find(buttonSelectors);
      if (!$buttons.length) {
        $list.html('<p style="color: #888; font-size: 0.9rem;">No buttons or action links found on this page.</p>');
      } else {
        $buttons.each(function (idx) {
          const $b = $(this);
          const $clone = $b.clone();
          $clone.find('.eliza-btn-url-badge, .btn-arrow, .arrow-up').remove();
          const text = $clone.text().trim() || '(Untitled Button)';
          
          let url = '';
          if ($b.is('a')) {
            url = $b.attr('href') || '#';
          } else {
            url = $b.attr('data-href') || '(Pending / Coming Soon)';
          }

          const $row = $(`
            <div class="eliza-link-item-row">
              <div class="eliza-link-item-info">
                <strong class="eliza-link-item-title">${escapeHtml(text)}</strong>
                <span class="eliza-link-item-url">${escapeHtml(url)}</span>
              </div>
              <button type="button" class="eliza-btn eliza-btn-item-edit" data-btn-index="${idx}">✏️ Edit URL</button>
            </div>
          `);

          $row.find('.eliza-btn-item-edit').on('click', function () {
            $('#eliza-all-links-modal').removeClass('show').attr('aria-hidden', 'true');
            openLinkModal($b);
          });

          $list.append($row);
        });
      }

      $('#eliza-all-links-modal').addClass('show').attr('aria-hidden', 'false');
    }

    $('#eliza-all-links-modal-close, #eliza-all-links-modal-done').on('click', function () {
      $('#eliza-all-links-modal').removeClass('show').attr('aria-hidden', 'true');
    });

    $('#eliza-all-links-modal').on('click', function (e) {
      if (e.target === this) {
        $('#eliza-all-links-modal').removeClass('show').attr('aria-hidden', 'true');
      }
    });

    // =========================================================================
    // SINGLE LINK & BUTTON URL MODAL CONTROLS
    // =========================================================================
    function openLinkModal($btn) {
      if (!$btn || !$btn.length) return;
      $activeTargetBtn = $btn;

      // Extract current text
      const $span = $btn.find('span:not(.btn-arrow):not(.arrow-up):not(.eliza-btn-url-badge)').first();
      let text = '';
      if ($span.length) {
        text = $span.text().trim();
      } else {
        const $cloneBtn = $btn.clone();
        $cloneBtn.find('.btn-arrow, .arrow-up, .eliza-btn-url-badge').remove();
        text = $cloneBtn.text().trim();
      }

      // Extract current URL
      let url = '';
      if ($btn.is('a')) {
        url = $btn.attr('href') || '';
      } else {
        url = $btn.attr('data-href') || '';
      }

      const isBlank = $btn.attr('target') === '_blank';

      $('#eliza-link-text-input').val(text);
      $('#eliza-link-url-input').val(url);
      $('#eliza-link-target-input').prop('checked', isBlank || url.startsWith('http'));

      $('#eliza-link-modal').addClass('show').attr('aria-hidden', 'false');
      $('#eliza-link-url-input').focus();
    }

    function closeLinkModal() {
      $('#eliza-link-modal').removeClass('show').attr('aria-hidden', 'true');
      $activeTargetBtn = null;
    }

    $('#eliza-link-modal-close, #eliza-link-modal-cancel').on('click', function () {
      closeLinkModal();
    });

    // Close on backdrop click
    $('#eliza-link-modal').on('click', function (e) {
      if (e.target === this) {
        closeLinkModal();
      }
    });

    // Quick helper chips
    $(document).on('click', '.eliza-link-chip', function () {
      const url = $(this).attr('data-set-url');
      if (url) {
        $('#eliza-link-url-input').val(url);
      }
    });

    // Apply Button & Link changes to DOM
    $('#eliza-link-modal-apply').on('click', function () {
      if (!$activeTargetBtn || !$activeTargetBtn.length) {
        closeLinkModal();
        return;
      }

      const newText = $('#eliza-link-text-input').val().trim();
      let newUrl = $('#eliza-link-url-input').val().trim();
      const openInNewTab = $('#eliza-link-target-input').is(':checked');

      // 1. Update text
      if (newText) {
        const $span = $activeTargetBtn.find('span:not(.btn-arrow):not(.arrow-up):not(.eliza-btn-url-badge)').first();
        if ($span.length) {
          $span.text(newText);
        } else {
          // Preserve any arrow icons
          $activeTargetBtn.contents().filter(function () {
            return this.nodeType === 3;
          }).remove();
          $activeTargetBtn.prepend(document.createTextNode(newText + ' '));
        }
      }

      // 2. Update URL & Element Type
      const isActualUrl = newUrl && newUrl !== '#';

      if ($activeTargetBtn.is('button') && isActualUrl) {
        // Upgrade <button> to <a> tag so it becomes an active navigable link
        const classes = $activeTargetBtn.attr('class') || '';
        const cleanedClasses = classes.replace('btn-solid-pending', '').trim();
        
        const $newLink = $('<a></a>')
          .attr('href', newUrl)
          .attr('class', cleanedClasses)
          .html($activeTargetBtn.html());

        if (openInNewTab) {
          $newLink.attr('target', '_blank').attr('rel', 'noopener noreferrer');
        }

        // Remove any onclick alerts
        $newLink.removeAttr('onclick');

        // Ensure upward arrow icon is present for external/solid CTAs
        if ($newLink.hasClass('btn-solid-cta') && !$newLink.find('.arrow-up').length) {
          if ($newLink.find('.eliza-btn-url-badge').length) {
            $newLink.find('.eliza-btn-url-badge').before(' <span class="arrow-up">&#8599;</span>');
          } else {
            $newLink.append(' <span class="arrow-up">&#8599;</span>');
          }
        }

        $activeTargetBtn.replaceWith($newLink);
        $activeTargetBtn = $newLink;
      } else if ($activeTargetBtn.is('a')) {
        if (!newUrl || newUrl === '#') {
          $activeTargetBtn.attr('href', '#');
          $activeTargetBtn.removeAttr('target').removeAttr('rel');
        } else {
          $activeTargetBtn.attr('href', newUrl);
          if (openInNewTab) {
            $activeTargetBtn.attr('target', '_blank').attr('rel', 'noopener noreferrer');
          } else {
            $activeTargetBtn.removeAttr('target').removeAttr('rel');
          }
          if (isActualUrl) {
            $activeTargetBtn.removeClass('btn-solid-pending').removeAttr('data-notice');
            if ($activeTargetBtn.hasClass('btn-solid-cta') && !$activeTargetBtn.find('.arrow-up').length) {
              if ($activeTargetBtn.find('.eliza-btn-url-badge').length) {
                $activeTargetBtn.find('.eliza-btn-url-badge').before(' <span class="arrow-up">&#8599;</span>');
              } else {
                $activeTargetBtn.append(' <span class="arrow-up">&#8599;</span>');
              }
            }
          }
        }
      }

      // If updating a video companion link, sync the nearby YouTube iframe too
      const extractedYt = extractYouTubeVideoId(newUrl);
      if (extractedYt) {
        const $nearbyIframe = $activeTargetBtn.closest('.grid-balanced-2, .reveal, section, div').find('.video-frame iframe, iframe[src*="youtube"]');
        if ($nearbyIframe.length) {
          $nearbyIframe.attr('src', 'https://www.youtube-nocookie.com/embed/' + extractedYt + '?rel=0');
        }
      }

      // Re-enable contenteditable on text
      const $updatedSpan = $activeTargetBtn.find('span:not(.btn-arrow):not(.arrow-up):not(.eliza-btn-url-badge)').first();
      if ($updatedSpan.length) {
        $updatedSpan.attr('contenteditable', 'true').attr('spellcheck', 'false');
      } else {
        $activeTargetBtn.attr('contenteditable', 'true').attr('spellcheck', 'false');
      }

      // Ensure URL badge is present
      if (!$activeTargetBtn.find('.eliza-btn-url-badge').length) {
        $activeTargetBtn.append('<span class="eliza-btn-url-badge" title="Click to edit destination URL and button settings" contenteditable="false">🔗 Edit URL</span>');
      }

      closeLinkModal();
      showToast('✓ Button text & URL updated! Click "Save Changes" on the toolbar when done.');
    });

    /**
     * Extracts the 11-character YouTube video ID from any valid YouTube URL or string.
     * Supports standard watch, short youtu.be, embed, nocookie, and direct IDs.
     * @param {string} url Input URL or ID.
     * @returns {string|null} The 11-character video ID, or null if invalid.
     */
    function extractYouTubeVideoId(url) {
      if (!url) return null;
      const clean = url.trim();
      if (/^[a-zA-Z0-9_-]{11}$/.test(clean)) {
        return clean;
      }
      const match = clean.match(/(?:youtu\.be\/|youtube(?:-nocookie)?\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/);
      return (match && match[1]) ? match[1] : null;
    }

    // Video Click Handler to Swap YouTube Video URL
    $(document).on('click', '.eliza-video-edit-badge', function (e) {
      if (!isEditMode) return;
      e.preventDefault();
      e.stopPropagation();

      const $wrap = $(this).closest('.eliza-editable-video-wrap');
      const $iframe = $wrap.find('iframe');
      const currentSrc = $iframe.attr('src') || '';
      const currentId = extractYouTubeVideoId(currentSrc) || '';

      const input = prompt(
        'Enter new YouTube Video URL or Video ID:\n(e.g. https://www.youtube.com/watch?v=aOVbAlEVY5g or aOVbAlEVY5g)',
        currentId ? 'https://www.youtube.com/watch?v=' + currentId : ''
      );

      if (input !== null && input.trim() !== '') {
        const newId = extractYouTubeVideoId(input);
        if (!newId) {
          showToast('❌ Invalid YouTube URL. Please enter a valid YouTube video link or ID.');
          return;
        }

        // Update embedded iframe src
        const newEmbedUrl = 'https://www.youtube-nocookie.com/embed/' + newId + '?rel=0';
        $iframe.attr('src', newEmbedUrl);

        // Update companion YouTube watch link if present
        const $companionLink = $wrap.siblings('.video-footer-link').find('a').add($wrap.closest('.grid-balanced-2, section, div').find('.video-footer-link a'));
        if ($companionLink.length) {
          $companionLink.attr('href', 'https://www.youtube.com/watch?v=' + newId);
        }

        showToast('✓ Video updated to ' + newId + '! Click "Save Changes" on the toolbar.');
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

    // Save Changes via AJAX (delegated document listener)
    $(document).on('click', '#eliza-save-live-btn', function () {
      const $btn = $(this);
      $btn.prop('disabled', true).find('span:last').text('Saving...');

      // Clone #main to clean live-editor temporary wrappers
      const $clone = $('#main').clone();

      // Strictly remove scripts, footers, toolbar, dock, and WP admin markup from post content
      $clone.find('script, style#wp-admin-bar-css, footer, .site-footer, #eliza-live-toolbar, #eliza-text-format-dock, #eliza-dock-open-tab, .eliza-format-dock, .eliza-dock-open-tab, .eliza-link-modal-backdrop, #wpadminbar, .toast-notice, #eliza-live-toast').remove();

      // Remove URL badges and temporary edit classes
      $clone.find('.eliza-btn-url-badge').remove();
      $clone.find('.eliza-editable-btn-wrap').removeClass('eliza-editable-btn-wrap');
      $clone.find('[contenteditable]').removeAttr('contenteditable').removeAttr('spellcheck');
      
      // Convert any WP emoji images back into raw text strings
      $clone.find('img.emoji, img.wp-smiley').each(function () {
        const altText = $(this).attr('alt') || '🙂';
        $(this).replaceWith(altText);
      });

      // Unwrap all editable image wrappers
      $clone.find('.eliza-editable-img-wrap').each(function () {
        const $innerImg = $(this).find('img');
        $(this).replaceWith($innerImg);
      });

      // Remove video edit badges and unwrap video wrappers
      $clone.find('.eliza-video-edit-badge').remove();
      $clone.find('.eliza-editable-video-wrap').each(function () {
        const $innerVideo = $(this).children();
        $(this).replaceWith($innerVideo);
      });

      let cleanHtml = $clone.html().trim();
      // Remove any lingering script tags
      cleanHtml = cleanHtml.replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, '');

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

    
    /**
     * Updates the tag badge in the docked formatting inspector header
     * to give the user immediate visual feedback of which element level is active.
     * @param {HTMLElement} el The active editable HTML element.
     */
    function updateDockTag(el) {
      if (!el) return;
      let tag = (el.tagName || 'TEXT').toUpperCase();
      if ($(el).hasClass('hero-subtitle') || $(el).hasClass('lede')) {
        tag = 'LEAD';
      } else if ($(el).hasClass('btn') || $(el).hasClass('btn-primary')) {
        tag = 'BUTTON';
      }
      $('#eliza-dock-tag').text(tag);
    }

    /**
     * Reveals the right-hand docked formatting inspector and syncs controls.
     */
    function openFormatDock() {
      const $dock = $('#eliza-text-format-dock');
      const $tab = $('#eliza-dock-open-tab');
      const $btn = $('#eliza-format-text-btn');

      $dock.removeClass('dock-minimized').stop(true, true).fadeIn(180);
      $tab.addClass('dock-tab-hidden').hide();
      $btn.addClass('active');
      isDockOpen = true;

      let targetEl = lastActiveEditable;
      if (!targetEl || !$(targetEl).is(':visible')) {
        targetEl = $('#main h1, #main h2, #main p').first()[0];
      }
      if (targetEl) {
        lastActiveEditable = targetEl;
        updateDockTag(targetEl);
        syncFormatControlsState(targetEl);
      }
    }

    /**
     * Hides the formatting inspector completely and clears the active toolbar state.
     */
    function closeFormatDock() {
      const $dock = $('#eliza-text-format-dock');
      const $tab = $('#eliza-dock-open-tab');
      const $btn = $('#eliza-format-text-btn');

      $dock.fadeOut(150);
      $tab.addClass('dock-tab-hidden').hide();
      $btn.removeClass('active');
      isDockOpen = false;
    }

    /**
     * Minimizes the dock into a sleek handle pinned to the right screen edge.
     */
    function minimizeFormatDock() {
      const $dock = $('#eliza-text-format-dock');
      const $tab = $('#eliza-dock-open-tab');
      const $btn = $('#eliza-format-text-btn');

      $dock.addClass('dock-minimized');
      setTimeout(function () {
        if ($dock.hasClass('dock-minimized')) {
          $dock.hide();
          $tab.removeClass('dock-tab-hidden').stop(true, true).fadeIn(150);
        }
      }, 250);
      $btn.removeClass('active');
      isDockOpen = false;
    }

    // Track active editable element
    $(document).on('focusin click', '#main [contenteditable="true"]', function () {
      lastActiveEditable = this;
      updateDockTag(this);
      if (isDockOpen || $('#eliza-text-format-dock').is(':visible')) {
        syncFormatControlsState(this);
      }
    });

    /**
     * Applies an inline CSS property to either the currently highlighted text range
     * or the active editable block, preserving selection context.
     * @param {string} cssProp CSS property name.
     * @param {string} cssVal CSS property value.
     * @returns {boolean} True if successfully applied.
     */
    function applyStyleToSelection(cssProp, cssVal) {
      const sel = window.getSelection();
      let range = null;

      if (sel && sel.rangeCount > 0 && !sel.isCollapsed) {
        range = sel.getRangeAt(0);
      } else if (savedSelectionRange) {
        range = savedSelectionRange;
      }

      if (range) {
        const commonNode = range.commonAncestorContainer;
        const $ancestor = $(commonNode.nodeType === 3 ? commonNode.parentElement : commonNode);

        if ($ancestor.closest('#main').length && !$ancestor.closest('.terms-subnav, [data-no-edit]').length) {
          try {
            const span = document.createElement('span');
            span.style.setProperty(cssProp, cssVal);
            const content = range.extractContents();
            span.appendChild(content);
            range.insertNode(span);

            // Re-select newly styled span content so consecutive actions chain cleanly
            if (sel) {
              const newRange = document.createRange();
              newRange.selectNodeContents(span);
              sel.removeAllRanges();
              sel.addRange(newRange);
              savedSelectionRange = newRange.cloneRange();
            }
            return true;
          } catch (e) {
            console.warn('Could not wrap selection with span, applying to element:', e);
          }
        }
      }

      if (lastActiveEditable) {
        $(lastActiveEditable).css(cssProp, cssVal);
        return true;
      }
      return false;
    }

    /**
     * Steps font size up or down by delta pixels.
     * @param {number} delta Number of pixels to increment or decrement.
     */
    function stepFontSize(delta) {
      let targetEl = lastActiveEditable;
      const sel = window.getSelection();
      let range = (sel && sel.rangeCount > 0 && !sel.isCollapsed) ? sel.getRangeAt(0) : savedSelectionRange;

      if (range) {
        const node = range.anchorNode || range.commonAncestorContainer;
        targetEl = node.nodeType === 3 ? node.parentElement : node;
      }
      if (!targetEl) return;
      const currentSizePx = parseFloat(window.getComputedStyle(targetEl).fontSize) || 16;
      const newSize = Math.max(10, Math.min(80, Math.round(currentSizePx + delta))) + 'px';
      applyStyleToSelection('font-size', newSize);
      $('#eliza-fmt-size').val(newSize);
      showToast('✓ Font size: ' + newSize);
    }

    /**
     * Resets inline typography and styling overrides back to default theme definitions.
     */
    function clearFormatting() {
      const sel = window.getSelection();
      let range = (sel && sel.rangeCount > 0 && !sel.isCollapsed) ? sel.getRangeAt(0) : savedSelectionRange;

      if (range) {
        document.execCommand('removeFormat', false, null);
      }
      if (lastActiveEditable) {
        $(lastActiveEditable).css({
          'font-family': '',
          'font-size': '',
          'font-weight': '',
          'font-style': '',
          'color': ''
        });
      }
      $('#eliza-fmt-font').val('');
      $('#eliza-fmt-size').val('');
      $('.eliza-fmt-btn[data-cmd="bold"]').removeClass('active');
      $('.eliza-fmt-btn[data-cmd="italic"]').removeClass('active');
      showToast('✓ Restored theme default font and size');
    }

    /**
     * Synchronizes inspector controls (font family select, size select, bold/italic buttons)
     * with the computed styles of the active element or selection.
     * @param {HTMLElement} el The element whose styles should be mirrored.
     */
    function syncFormatControlsState(el) {
      const target = el || lastActiveEditable;
      if (!target) return;
      const style = window.getComputedStyle(target);

      const isBold = style.fontWeight === 'bold' || parseInt(style.fontWeight, 10) >= 600;
      $('.eliza-fmt-btn[data-cmd="bold"]').toggleClass('active', isBold);

      const isItalic = style.fontStyle === 'italic';
      $('.eliza-fmt-btn[data-cmd="italic"]').toggleClass('active', isItalic);

      const curFont = (style.fontFamily || '').toLowerCase();
      let matchedFont = false;
      $('#eliza-fmt-font option').each(function () {
        const val = $(this).val();
        if (val) {
          const cleanName = val.split(',')[0].replace(/['"]/g, '').trim().toLowerCase();
          if (curFont.includes(cleanName)) {
            $('#eliza-fmt-font').val(val);
            matchedFont = true;
            return false;
          }
        }
      });
      if (!matchedFont) {
        $('#eliza-fmt-font').val('');
      }

      const curSizePx = Math.round(parseFloat(style.fontSize)) + 'px';
      let foundSize = false;
      $('#eliza-fmt-size option').each(function () {
        if ($(this).val() === curSizePx) {
          $('#eliza-fmt-size').val(curSizePx);
          foundSize = true;
          return false;
        }
      });
      if (!foundSize) {
        $('#eliza-fmt-size').val('');
      }
    }

    /**
     * Caches highlighted selection range when user releases mouse or keys.
     */
    function saveCurrentSelection() {
      if (!isEditMode) return;
      const sel = window.getSelection();
      if (!sel || sel.rangeCount === 0 || sel.isCollapsed) return;

      const range = sel.getRangeAt(0);
      const commonNode = range.commonAncestorContainer;
      const $ancestor = $(commonNode.nodeType === 3 ? commonNode.parentElement : commonNode);

      if ($ancestor.closest('#main').length && !$ancestor.closest('.terms-subnav, [data-no-edit]').length) {
        savedSelectionRange = range.cloneRange();
        lastActiveEditable = $ancestor[0];
        updateDockTag($ancestor[0]);
        if (isDockOpen || $('#eliza-text-format-dock').is(':visible')) {
          syncFormatControlsState($ancestor[0]);
        }
      }
    }

    $(document).on('mouseup keyup', '#main', function () {
      setTimeout(saveCurrentSelection, 20);
    });

    // Format Text button on bottom toolbar toggles dock
    $(document).on('click', '#eliza-format-text-btn', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const $dock = $('#eliza-text-format-dock');
      if ($dock.is(':visible') && !$dock.hasClass('dock-minimized')) {
        closeFormatDock();
      } else {
        openFormatDock();
      }
    });

    // Minimize button inside Dock
    $(document).on('click', '#eliza-dock-minimize-btn', function (e) {
      e.preventDefault();
      e.stopPropagation();
      minimizeFormatDock();
      showToast('🔤 Inspector docked to edge tab');
    });

    // Close button inside Dock
    $(document).on('click', '#eliza-dock-close-btn', function (e) {
      e.preventDefault();
      e.stopPropagation();
      closeFormatDock();
    });

    // Edge handle click restores Dock
    $(document).on('click', '#eliza-dock-open-tab', function (e) {
      e.preventDefault();
      e.stopPropagation();
      openFormatDock();
    });

    // Prevent mousedown on buttons/chips from blurring text selection in the document
    $(document).on('mousedown', '#eliza-text-format-dock .eliza-fmt-btn, #eliza-text-format-dock .eliza-color-chip', function (e) {
      e.preventDefault();
    });

    // Format Button Commands: Bold, Italic, Step Size, Reset
    $(document).on('click', '.eliza-fmt-btn[data-cmd]', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const cmd = $(this).attr('data-cmd');

      if (cmd === 'bold') {
        const sel = window.getSelection();
        let range = (sel && sel.rangeCount > 0 && !sel.isCollapsed) ? sel.getRangeAt(0) : savedSelectionRange;
        if (range && (!sel || !sel.isCollapsed)) {
          document.execCommand('bold', false, null);
        } else if (lastActiveEditable) {
          const curWeight = $(lastActiveEditable).css('font-weight');
          const isBold = curWeight === 'bold' || parseInt(curWeight, 10) >= 600;
          $(lastActiveEditable).css('font-weight', isBold ? 'normal' : 'bold');
        }
        $(this).toggleClass('active');
        showToast('✓ Bold toggled');
      } else if (cmd === 'italic') {
        const sel = window.getSelection();
        let range = (sel && sel.rangeCount > 0 && !sel.isCollapsed) ? sel.getRangeAt(0) : savedSelectionRange;
        if (range && (!sel || !sel.isCollapsed)) {
          document.execCommand('italic', false, null);
        } else if (lastActiveEditable) {
          const curStyle = $(lastActiveEditable).css('font-style');
          $(lastActiveEditable).css('font-style', curStyle === 'italic' ? 'normal' : 'italic');
        }
        $(this).toggleClass('active');
        showToast('✓ Italic toggled');
      } else if (cmd === 'size-up') {
        stepFontSize(2);
      } else if (cmd === 'size-down') {
        stepFontSize(-2);
      } else if (cmd === 'clear') {
        clearFormatting();
      }
    });

    // Font Family Selection Handler
    $(document).on('change', '#eliza-fmt-font', function () {
      const font = $(this).val();
      if (!font) {
        if (lastActiveEditable) {
          $(lastActiveEditable).css('font-family', '');
        }
        showToast('✓ Reset to theme font');
        return;
      }
      applyStyleToSelection('font-family', font);
      const fontLabel = $(this).find('option:selected').text().split('(')[0].trim();
      showToast('✓ Font set: ' + fontLabel);
    });

    // Font Size Selection Handler
    $(document).on('change', '#eliza-fmt-size', function () {
      const size = $(this).val();
      if (!size) {
        if (lastActiveEditable) {
          $(lastActiveEditable).css('font-size', '');
        }
        showToast('✓ Reset to default size');
        return;
      }
      applyStyleToSelection('font-size', size);
      showToast('✓ Font size set: ' + size);
    });

    // Color Chip Selection Handler
    $(document).on('click', '.eliza-color-chip', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const color = $(this).attr('data-color');
      applyStyleToSelection('color', color);
      showToast('✓ Text color updated');
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
    console.log('Eliza Frontend Live Visual Editor initialized for all text, cards & buttons!');
  });
})(jQuery);
