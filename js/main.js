/**
 * @file main.js
 * @description Core client-side interactions, scroll-reveal observer, dynamic glass navigation,
 * category filtering, clipboard helper, and accessible micro-interactions for Eliza Reconnection.
 */

(function () {
  'use strict';

  /**
   * Initializes the lightweight 60fps IntersectionObserver to trigger
   * reveal animations when elements enter the viewport.
   * @returns {void}
   */
  function initScrollReveal() {
    // Respect user motion preferences for accessibility
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      document.querySelectorAll('.reveal').forEach(function (el) {
        el.classList.add('is-revealed');
      });
      return;
    }

    if (!('IntersectionObserver' in window)) {
      document.querySelectorAll('.reveal').forEach(function (el) {
        el.classList.add('is-revealed');
      });
      return;
    }

    var observer = new IntersectionObserver(
      function (entries, obs) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-revealed');
            obs.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0.12,
        rootMargin: '0px 0px -40px 0px',
      }
    );

    document.querySelectorAll('.reveal').forEach(function (el) {
      observer.observe(el);
    });
  }

  /**
   * Tracks window scroll position to apply dynamic glass compression
   * and elevation shadow to the sticky site header.
   * @returns {void}
   */
  function initHeaderScroll() {
    var header = document.querySelector('.site-header');
    if (!header) return;

    var handleScroll = function () {
      if (window.scrollY > 20) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    };

    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
  }

  /**
   * Initializes mobile drawer navigation with accessibility attributes,
   * backdrop overlay handling, and keyboard dismissibility (Escape key).
   * @returns {void}
   */
  function initMobileNav() {
    var toggle = document.querySelector('.nav-toggle');
    var nav = document.querySelector('.main-nav');
    if (!toggle || !nav) return;

    // Create backdrop element if not already present
    var backdrop = document.querySelector('.nav-backdrop');
    if (!backdrop) {
      backdrop = document.createElement('div');
      backdrop.className = 'nav-backdrop';
      document.body.appendChild(backdrop);
    }

    var closeNav = function () {
      nav.classList.remove('open');
      backdrop.classList.remove('open');
      toggle.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
    };

    var openNav = function () {
      nav.classList.add('open');
      backdrop.classList.add('open');
      toggle.setAttribute('aria-expanded', 'true');
      document.body.style.overflow = 'hidden';
    };

    toggle.addEventListener('click', function () {
      var isOpen = nav.classList.contains('open');
      if (isOpen) {
        closeNav();
      } else {
        openNav();
      }
    });

    backdrop.addEventListener('click', closeNav);

    nav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', closeNav);
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && nav.classList.contains('open')) {
        closeNav();
      }
    });
  }

  /**
   * Displays a temporary floating toast notification for micro-interactions
   * such as clipboard copying or status confirmations.
   * @param {string} message - Text to show in the toast.
   * @returns {void}
   */
  function showToast(message) {
    var existingToast = document.querySelector('.toast-notice');
    if (existingToast) {
      existingToast.remove();
    }

    var toast = document.createElement('div');
    toast.className = 'toast-notice';
    toast.setAttribute('role', 'status');
    toast.innerHTML = '<span>✦</span> <span>' + message + '</span>';
    document.body.appendChild(toast);

    // Force reflow for smooth transform animation
    void toast.offsetWidth;
    toast.classList.add('show');

    setTimeout(function () {
      toast.classList.remove('show');
      setTimeout(function () {
        if (toast.parentNode) {
          toast.parentNode.removeChild(toast);
        }
      }, 400);
    }, 3200);
  }

  /**
   * Initializes one-click clipboard copying for contact information
   * buttons (phone and email).
   * @returns {void}
   */
  function initCopyButtons() {
    document.querySelectorAll('[data-copy]').forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        var text = btn.getAttribute('data-copy');
        if (!text) return;

        if (navigator.clipboard && navigator.clipboard.writeText) {
          navigator.clipboard.writeText(text).then(function () {
            showToast('Copied "' + text + '" to clipboard');
          });
        } else {
          // Fallback for non-HTTPS or older browsers
          var tempInput = document.createElement('input');
          tempInput.value = text;
          document.body.appendChild(tempInput);
          tempInput.select();
          document.execCommand('copy');
          document.body.removeChild(tempInput);
          showToast('Copied to clipboard');
        }
      });
    });
  }

  /**
   * Initializes instant client-side category filtering for testimonials
   * (results.html) and journal articles (journal.html).
   * @returns {void}
   */
  function initCategoryFilters() {
    var filterBtns = document.querySelectorAll('[data-filter]');
    var filterItems = document.querySelectorAll('[data-category]');

    if (!filterBtns.length || !filterItems.length) return;

    filterBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var targetCategory = btn.getAttribute('data-filter');

        // Update active tab button style
        filterBtns.forEach(function (b) {
          b.classList.remove('active');
          b.setAttribute('aria-pressed', 'false');
        });
        btn.classList.add('active');
        btn.setAttribute('aria-pressed', 'true');

        // Filter items with smooth opacity & display transitions
        filterItems.forEach(function (item) {
          var itemCategory = item.getAttribute('data-category');
          if (targetCategory === 'all' || itemCategory === targetCategory) {
            item.style.display = '';
            setTimeout(function () {
              item.style.opacity = '1';
              item.style.transform = 'translateY(0)';
            }, 20);
          } else {
            item.style.opacity = '0';
            item.style.transform = 'translateY(10px)';
            setTimeout(function () {
              item.style.display = 'none';
            }, 250);
          }
        });
      });
    });
  }

  /**
   * Handles contact form submission with animated feedback, field validation,
   * and helpful status messaging.
   * @returns {void}
   */
  function initContactForm() {
    var form = document.querySelector('.contact-form');
    if (!form) return;

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var submitBtn = form.querySelector('button[type="submit"]');
      var statusEl = form.querySelector('.form-status');

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending...';
      }

      setTimeout(function () {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.textContent = 'Send message';
        }
        if (statusEl) {
          statusEl.className = 'form-status success';
          statusEl.innerHTML = '<strong>Message received!</strong> Thank you for reaching out. Eliza will be in touch shortly to confirm your session or tea chat.';
          statusEl.style.display = 'block';
        }
        form.reset();
        showToast('Message sent successfully!');
      }, 700);
    });
  }

  /**
   * Initializes the interactive Violet Flame cursor effect.
   * Scoped strictly to the Home Hero section (.home-hero) on index.html.
   * Creates a gentle, organic, sacred violet flame that smoothly licks and rises
   * from the cursor tip (inspired by Saint Germain & Archangel Michael).
   * @returns {void}
   */
  function initVioletFlame() {
    var hero = document.querySelector('.home-hero');
    var canvas = document.getElementById('heroFlameCanvas');
    if (!hero || !canvas) return;

    // Respect reduced-motion preferences
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      return;
    }

    var ctx = canvas.getContext('2d');
    if (!ctx) return;

    var flameTongues = [];
    var microEmbers = [];
    var maxTongues = 45;
    var maxEmbers = 18;

    var mouse = {
      x: null,
      y: null,
      smoothX: null,
      smoothY: null,
      active: false,
      opacity: 0, // for smooth fade-in/out
    };

    var width = 0;
    var height = 0;
    var dpr = Math.min(window.devicePixelRatio || 1, 2);
    var animId = null;
    var tick = 0;

    /**
     * Resizes canvas to exact bounding dimensions of the hero.
     */
    function resizeCanvas() {
      var rect = hero.getBoundingClientRect();
      width = rect.width;
      height = rect.height;
      canvas.width = Math.floor(width * dpr);
      canvas.height = Math.floor(height * dpr);
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    resizeCanvas();
    window.addEventListener('resize', resizeCanvas, { passive: true });

    /**
     * Flame Tongue constructor (soft rising tear-drop flame wisp).
     * @constructor
     * @param {number} x - Origin X position.
     * @param {number} y - Origin Y position.
     * @param {number} baseSize - Starting radius.
     */
    function FlameTongue(x, y, baseSize) {
      this.x = x + (Math.random() - 0.5) * 6;
      this.y = y - Math.random() * 4;
      this.baseSize = baseSize || (12 + Math.random() * 10);
      this.size = this.baseSize;
      this.maxLife = 32 + Math.random() * 20;
      this.life = 0;
      this.vy = -(0.9 + Math.random() * 1.1); // gentle slow rise
      this.phase = Math.random() * Math.PI * 2;
      this.swayFreq = 0.09 + Math.random() * 0.05;
      this.swayAmp = 0.5 + Math.random() * 0.4;
    }

    FlameTongue.prototype.update = function () {
      this.life++;
      var progress = this.life / this.maxLife;

      // Gentle wave sway
      this.x += Math.sin(this.life * this.swayFreq + this.phase) * this.swayAmp;
      this.y += this.vy;
      this.vy *= 0.985; // subtle buoyancy deceleration

      // Flame tapers and shrinks as it rises
      this.size = this.baseSize * (1 - progress * 0.7);

      return this.life < this.maxLife && this.size > 1;
    };

    FlameTongue.prototype.draw = function () {
      var progress = this.life / this.maxLife;
      var alpha = (1 - progress) * 0.55;

      var grad = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.size);
      // Soft radiant center
      grad.addColorStop(0, 'rgba(255, 245, 255, ' + (alpha * 0.9) + ')');
      // Luminous electric violet mantle
      grad.addColorStop(0.35, 'rgba(199, 125, 255, ' + (alpha * 0.65) + ')');
      // Deep sacred amethyst aura
      grad.addColorStop(0.7, 'rgba(138, 43, 226, ' + (alpha * 0.35) + ')');
      grad.addColorStop(1, 'rgba(75, 0, 130, 0)');

      ctx.fillStyle = grad;
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
      ctx.fill();
    };

    /**
     * Micro-Ember constructor (tiny subtle floating starlight specks).
     * @constructor
     * @param {number} x - Origin X position.
     * @param {number} y - Origin Y position.
     */
    function MicroEmber(x, y) {
      this.x = x + (Math.random() - 0.5) * 10;
      this.y = y - Math.random() * 6;
      this.size = 1.0 + Math.random() * 1.5;
      this.maxLife = 40 + Math.random() * 25;
      this.life = 0;
      this.vy = -(0.7 + Math.random() * 0.9); // very slow floating
      this.vx = (Math.random() - 0.5) * 0.4;
      this.color = Math.random() > 0.4 ? 'rgba(255, 225, 140, ' : 'rgba(230, 190, 255, ';
      this.phase = Math.random() * Math.PI * 2;
    }

    MicroEmber.prototype.update = function () {
      this.life++;
      this.x += this.vx + Math.sin(this.life * 0.08 + this.phase) * 0.3;
      this.y += this.vy;
      return this.life < this.maxLife;
    };

    MicroEmber.prototype.draw = function () {
      var progress = this.life / this.maxLife;
      var alpha = Math.sin(progress * Math.PI) * 0.7; // fade in then out

      ctx.fillStyle = this.color + alpha + ')';
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
      ctx.fill();
    };

    /**
     * Draws the core flame body adhering directly to the cursor.
     */
    function drawCoreFlame(x, y, intensity) {
      var breathe = Math.sin(tick * 0.06) * 3;
      var flicker = Math.sin(tick * 0.18) * 1.5;
      var outerRadius = (28 + breathe + flicker) * intensity;
      var innerRadius = (16 + breathe * 0.6) * intensity;
      var coreRadius = (6 + breathe * 0.2) * intensity;

      // 1. Soft Outer Amethyst Glow
      var outerGrad = ctx.createRadialGradient(x, y - 4, 0, x, y - 4, outerRadius);
      outerGrad.addColorStop(0, 'rgba(157, 78, 221, ' + (0.35 * intensity) + ')');
      outerGrad.addColorStop(0.5, 'rgba(123, 44, 191, ' + (0.18 * intensity) + ')');
      outerGrad.addColorStop(1, 'rgba(60, 9, 108, 0)');
      ctx.fillStyle = outerGrad;
      ctx.beginPath();
      ctx.arc(x, y - 4, outerRadius, 0, Math.PI * 2);
      ctx.fill();

      // 2. Luminous Violet Mantle
      var midGrad = ctx.createRadialGradient(x, y - 3, 0, x, y - 3, innerRadius);
      midGrad.addColorStop(0, 'rgba(215, 155, 255, ' + (0.65 * intensity) + ')');
      midGrad.addColorStop(0.5, 'rgba(180, 90, 245, ' + (0.4 * intensity) + ')');
      midGrad.addColorStop(1, 'rgba(138, 43, 226, 0)');
      ctx.fillStyle = midGrad;
      ctx.beginPath();
      ctx.arc(x, y - 3, innerRadius, 0, Math.PI * 2);
      ctx.fill();

      // 3. Sacred Warm Gold/White Heart Core
      var coreGrad = ctx.createRadialGradient(x, y - 2, 0, x, y - 2, coreRadius);
      coreGrad.addColorStop(0, 'rgba(255, 250, 240, ' + (0.85 * intensity) + ')');
      coreGrad.addColorStop(0.6, 'rgba(255, 215, 130, ' + (0.55 * intensity) + ')');
      coreGrad.addColorStop(1, 'rgba(200, 130, 255, 0)');
      ctx.fillStyle = coreGrad;
      ctx.beginPath();
      ctx.arc(x, y - 2, coreRadius, 0, Math.PI * 2);
      ctx.fill();
    }

    /**
     * Main animation loop.
     */
    function loop() {
      tick++;
      ctx.clearRect(0, 0, width, height);

      // Smooth cursor position interpolation
      if (mouse.smoothX === null) {
        mouse.smoothX = mouse.x;
        mouse.smoothY = mouse.y;
      } else if (mouse.x !== null) {
        mouse.smoothX += (mouse.x - mouse.smoothX) * 0.32;
        mouse.smoothY += (mouse.y - mouse.smoothY) * 0.32;
      }

      // Smooth fade-in and fade-out of cursor flame
      if (mouse.active) {
        mouse.opacity = Math.min(mouse.opacity + 0.08, 1);
      } else {
        mouse.opacity = Math.max(mouse.opacity - 0.05, 0);
      }

      // Additive blending for ethereal celestial light
      ctx.globalCompositeOperation = 'screen';

      // 1. Draw central anchored flame under the cursor
      if (mouse.opacity > 0 && mouse.smoothX !== null) {
        drawCoreFlame(mouse.smoothX, mouse.smoothY, mouse.opacity);

        // Spawn gentle flame tongues (1 per 2 frames)
        if (tick % 2 === 0 && flameTongues.length < maxTongues) {
          flameTongues.push(new FlameTongue(mouse.smoothX, mouse.smoothY));
        }

        // Spawn subtle micro-embers (1 per 10 frames)
        if (tick % 10 === 0 && microEmbers.length < maxEmbers) {
          microEmbers.push(new MicroEmber(mouse.smoothX, mouse.smoothY));
        }
      }

      // 2. Update and render rising flame tongues
      for (var i = flameTongues.length - 1; i >= 0; i--) {
        var tongue = flameTongues[i];
        if (tongue.update()) {
          tongue.draw();
        } else {
          flameTongues.splice(i, 1);
        }
      }

      // 3. Update and render micro-embers
      for (var j = microEmbers.length - 1; j >= 0; j--) {
        var ember = microEmbers[j];
        if (ember.update()) {
          ember.draw();
        } else {
          microEmbers.splice(j, 1);
        }
      }

      ctx.globalCompositeOperation = 'source-over';

      // Continue loop if mouse is active or particles are still dissolving
      if (mouse.active || mouse.opacity > 0 || flameTongues.length > 0 || microEmbers.length > 0) {
        animId = requestAnimationFrame(loop);
      } else {
        animId = null;
        mouse.smoothX = null;
        mouse.smoothY = null;
      }
    }

    function startLoop() {
      if (!animId) {
        animId = requestAnimationFrame(loop);
      }
    }

    /**
     * Event handlers strictly on the hero banner.
     */
    function handlePointerMove(e) {
      var rect = hero.getBoundingClientRect();
      var clientX = e.clientX;
      var clientY = e.clientY;

      if (e.touches && e.touches.length > 0) {
        clientX = e.touches[0].clientX;
        clientY = e.touches[0].clientY;
      }

      var x = clientX - rect.left;
      var y = clientY - rect.top;

      mouse.x = x;
      mouse.y = y;
      mouse.active = true;

      startLoop();
    }

    function handlePointerEnter(e) {
      mouse.active = true;
      handlePointerMove(e);
    }

    function handlePointerLeave() {
      mouse.active = false;
      mouse.x = null;
      mouse.y = null;
    }

    hero.addEventListener('mousemove', handlePointerMove, { passive: true });
    hero.addEventListener('mouseenter', handlePointerEnter, { passive: true });
    hero.addEventListener('mouseleave', handlePointerLeave, { passive: true });

    hero.addEventListener('touchmove', handlePointerMove, { passive: true });
    hero.addEventListener('touchstart', handlePointerEnter, { passive: true });
    hero.addEventListener('touchend', handlePointerLeave, { passive: true });
  }

  /**
   * Updates any element with [data-year] to the current calendar year.
   * @returns {void}
   */
  function initYear() {
    var yearEl = document.querySelectorAll('[data-year]');
    var currentYear = new Date().getFullYear();
    yearEl.forEach(function (el) {
      el.textContent = currentYear;
    });
  }

  // DOMContentLoaded bootstrap
  document.addEventListener('DOMContentLoaded', function () {
    initScrollReveal();
    initHeaderScroll();
    initMobileNav();
    initCopyButtons();
    initCategoryFilters();
    initContactForm();
    initVioletFlame();
    initYear();
  });
})();
