/**
 * Pavaki Infra - Main Architectural Vanilla JavaScript
 *
 * Interactive behaviors matching TitanInfra UX:
 * 1. Sticky Navigation Header Scroll State
 * 2. Mobile Full-Screen Slide-in Drawer with Accessible Focus & Escape
 * 3. Hero Pure Image Slider (Auto-advance, Ken Burns slow zoom, arrows, swipe, keyboard, indicators)
 * 4. Interactive India Map Pins & Projects List Linkage
 * 5. Accessible Staff & Field Intranet Modal
 * 6. Form UX & Double-Submission Guard
 */

'use strict';

document.addEventListener('DOMContentLoaded', () => {
    initHeaderScroll();
    initMobileDrawer();
    initHeroSlider();
    initMapPinInteraction();
    initTestimonialSlider();
    initStatsCountUp();
    initScrollAnimations();
    initEmployeeModal();
    initFormUX();
    initServicesNav();
    initProjectsFilter();
});

/**
 * 1. Sticky Navigation Header Scroll State
 */
function initHeaderScroll() {
    const header = document.getElementById('site-header');
    if (!header) return;

    function checkScroll() {
        if (window.scrollY > 30) {
            header.classList.add('is-scrolled');
        } else {
            header.classList.remove('is-scrolled');
        }
    }

    window.addEventListener('scroll', checkScroll, { passive: true });
    checkScroll();
}

/**
 * 2. Mobile Full-Screen Slide-in Drawer
 */
function initMobileDrawer() {
    const toggleBtn = document.getElementById('mobile-nav-toggle');
    const drawer = document.getElementById('mobile-nav-drawer');
    const closeBtn = document.getElementById('mobile-drawer-close');

    if (!toggleBtn || !drawer) return;

    function openDrawer() {
        drawer.classList.add('is-open');
        drawer.setAttribute('aria-hidden', 'false');
        toggleBtn.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
        if (closeBtn) closeBtn.focus();
    }

    function closeDrawer() {
        drawer.classList.remove('is-open');
        drawer.setAttribute('aria-hidden', 'true');
        toggleBtn.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
        toggleBtn.focus();
    }

    toggleBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = drawer.classList.contains('is-open');
        if (isOpen) {
            closeDrawer();
        } else {
            openDrawer();
        }
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', closeDrawer);
    }

    drawer.addEventListener('click', (e) => {
        if (e.target === drawer) {
            closeDrawer();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
            closeDrawer();
        }
    });
}

/**
 * 3. Hero Pure Image Slider
 * Full-width image slider with auto-advance, smooth cross-fade,
 * slow Ken Burns zoom, swipe, arrows, keyboard navigation, and progress bars.
 */
function initHeroSlider() {
    const slider = document.getElementById('hero-slider');
    if (!slider) return;

    const slides = slider.querySelectorAll('.hero-slide');
    const prevBtn = document.getElementById('hero-prev-btn');
    const nextBtn = document.getElementById('hero-next-btn');
    const indicators = slider.querySelectorAll('.hero-indicator-bar');

    if (!slides.length) return;

    let currentIndex = 0;
    const totalSlides = slides.length;
    const intervalTime = 5500;
    let autoplayTimer = null;
    let isPaused = false;

    // Check for prefers-reduced-motion
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function resetIndicatorAnimation(el) {
        if (!el) return;
        const fill = el.querySelector('.indicator-fill');
        if (!fill) return;
        fill.style.animation = 'none';
        // Force reflow
        void fill.offsetWidth;
        if (!prefersReducedMotion) {
            fill.style.animation = `indicatorFillAnim ${intervalTime}ms linear forwards`;
        }
    }

    function goToSlide(targetIndex) {
        if (targetIndex === currentIndex && slides[currentIndex].classList.contains('is-active')) {
            return;
        }

        slides[currentIndex].classList.remove('is-active');
        slides[currentIndex].setAttribute('aria-hidden', 'true');
        if (indicators[currentIndex]) {
            indicators[currentIndex].classList.remove('is-active');
            indicators[currentIndex].setAttribute('aria-selected', 'false');
            const oldFill = indicators[currentIndex].querySelector('.indicator-fill');
            if (oldFill) oldFill.style.animation = 'none';
        }

        currentIndex = (targetIndex + totalSlides) % totalSlides;

        slides[currentIndex].classList.add('is-active');
        slides[currentIndex].setAttribute('aria-hidden', 'false');
        if (indicators[currentIndex]) {
            indicators[currentIndex].classList.add('is-active');
            indicators[currentIndex].setAttribute('aria-selected', 'true');
            resetIndicatorAnimation(indicators[currentIndex]);
        }
    }

    function nextSlide() {
        goToSlide(currentIndex + 1);
    }

    function prevSlide() {
        goToSlide(currentIndex - 1);
    }

    function startAutoplay() {
        if (prefersReducedMotion) return;
        stopAutoplay();
        if (indicators[currentIndex]) {
            resetIndicatorAnimation(indicators[currentIndex]);
        }
        autoplayTimer = setInterval(() => {
            if (!isPaused) {
                nextSlide();
            }
        }, intervalTime);
    }

    function stopAutoplay() {
        if (autoplayTimer) {
            clearInterval(autoplayTimer);
            autoplayTimer = null;
        }
    }

    // Desktop Navigation Arrows
    if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            prevSlide();
            startAutoplay();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            nextSlide();
            startAutoplay();
        });
    }

    // Indicator Bars Click
    indicators.forEach((indicator, idx) => {
        indicator.addEventListener('click', (e) => {
            e.preventDefault();
            goToSlide(idx);
            startAutoplay();
        });
    });

    // Pause on hover
    slider.addEventListener('mouseenter', () => {
        isPaused = true;
        slider.classList.add('is-paused');
    });

    slider.addEventListener('mouseleave', () => {
        isPaused = false;
        slider.classList.remove('is-paused');
    });

    // Mobile Swipe Gestures
    let touchStartX = 0;
    let touchStartY = 0;
    let touchEndX = 0;
    let touchEndY = 0;

    slider.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        touchStartY = e.changedTouches[0].screenY;
    }, { passive: true });

    slider.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        touchEndY = e.changedTouches[0].screenY;
        handleSwipe();
    }, { passive: true });

    function handleSwipe() {
        const deltaX = touchEndX - touchStartX;
        const deltaY = touchEndY - touchStartY;
        if (Math.abs(deltaX) > 40 && Math.abs(deltaX) > Math.abs(deltaY)) {
            if (deltaX < 0) {
                nextSlide();
            } else {
                prevSlide();
            }
            startAutoplay();
        }
    }

    // Keyboard Navigation
    slider.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            prevSlide();
            startAutoplay();
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            nextSlide();
            startAutoplay();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (['INPUT', 'SELECT', 'TEXTAREA'].includes(document.activeElement?.tagName)) {
            return;
        }
        if (window.scrollY < (window.innerHeight * 0.8)) {
            if (e.key === 'ArrowLeft') {
                prevSlide();
                startAutoplay();
            } else if (e.key === 'ArrowRight') {
                nextSlide();
                startAutoplay();
            }
        }
    });

    // Initialize Autoplay
    startAutoplay();
}

/**
 * 4. Interactive India Map Pins & Projects List Linkage
 */
function initMapPinInteraction() {
    const mapPins = document.querySelectorAll('.map-pin');
    const projectItems = document.querySelectorAll('.project-item-titan, .proj-thumb-card');

    if (!mapPins.length || !projectItems.length) return;

    function activateProject(projKey) {
        mapPins.forEach((pin) => {
            if (pin.getAttribute('data-project') === projKey) {
                pin.classList.add('is-active');
            } else {
                pin.classList.remove('is-active');
            }
        });

        projectItems.forEach((item) => {
            if (item.getAttribute('data-project') === projKey) {
                item.classList.add('is-active');
            } else {
                item.classList.remove('is-active');
            }
        });
    }

    function resetProjectHighlight() {
        mapPins.forEach((pin) => pin.classList.remove('is-active'));
        projectItems.forEach((item) => item.classList.remove('is-active'));
    }

    projectItems.forEach((item) => {
        const key = item.getAttribute('data-project');
        if (!key) return;

        item.addEventListener('mouseenter', () => activateProject(key));
        item.addEventListener('focus', () => activateProject(key));
        item.addEventListener('mouseleave', resetProjectHighlight);
        item.addEventListener('blur', resetProjectHighlight);
    });

    mapPins.forEach((pin) => {
        const key = pin.getAttribute('data-project');
        if (!key) return;

        pin.addEventListener('mouseenter', () => activateProject(key));
        pin.addEventListener('mouseleave', resetProjectHighlight);
        pin.addEventListener('click', () => activateProject(key));
    });
}

/**
 * 5. Accessible Staff & Field Intranet Modal
 */
function initEmployeeModal() {
    const modal = document.getElementById('employee-login-modal');
    const closeBtn = document.getElementById('modal-staff-close');
    const triggers = document.querySelectorAll('a[href="#employee-login-modal"]');

    if (!modal) return;

    function openModal(e) {
        if (e) e.preventDefault();
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        const firstInput = modal.querySelector('input');
        if (firstInput) firstInput.focus();
    }

    function closeModal() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    triggers.forEach((trigger) => {
        trigger.addEventListener('click', openModal);
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) {
            closeModal();
        }
    });
}

/**
 * 6. Form UX & Double-Submission Guard
 */
function initFormUX() {
    const forms = document.querySelectorAll('form');
    forms.forEach((form) => {
        const submitBtn = form.querySelector('button[type="submit"]');
        form.addEventListener('submit', () => {
            if (form.checkValidity && !form.checkValidity()) {
                return;
            }
            if (submitBtn) {
                submitBtn.disabled = true;
                const originalHtml = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span>PROCESSING SUBMISSION...</span>';
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;
                }, 8000);
            }
        });
    });
}

/**
 * 7. Verified Client Testimonials Slider
 * 7-second auto-advance, smooth fade transition, pause on hover, arrows and dots.
 */
function initTestimonialSlider() {
    const sliderBox = document.getElementById('testimonials-slider');
    if (!sliderBox) return;

    const slides = sliderBox.querySelectorAll('.testimonial-slide-item');
    const dots = sliderBox.querySelectorAll('.testimonial-dot');
    const prevBtn = document.getElementById('testimonial-prev-btn');
    const nextBtn = document.getElementById('testimonial-next-btn');

    if (!slides.length) return;

    let currentIndex = 0;
    const total = slides.length;
    let timer = null;
    let isPaused = false;
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function goTo(idx) {
        slides[currentIndex].classList.remove('is-active');
        slides[currentIndex].setAttribute('aria-hidden', 'true');
        if (dots[currentIndex]) {
            dots[currentIndex].classList.remove('is-active');
            dots[currentIndex].setAttribute('aria-selected', 'false');
        }

        currentIndex = (idx + total) % total;

        slides[currentIndex].classList.add('is-active');
        slides[currentIndex].setAttribute('aria-hidden', 'false');
        if (dots[currentIndex]) {
            dots[currentIndex].classList.add('is-active');
            dots[currentIndex].setAttribute('aria-selected', 'true');
        }
    }

    function next() {
        goTo(currentIndex + 1);
    }

    function prev() {
        goTo(currentIndex - 1);
    }

    function startTimer() {
        if (prefersReducedMotion) return;
        stopTimer();
        timer = setInterval(() => {
            if (!isPaused) {
                next();
            }
        }, 7000);
    }

    function stopTimer() {
        if (timer) {
            clearInterval(timer);
            timer = null;
        }
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            prev();
            startTimer();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            next();
            startTimer();
        });
    }

    dots.forEach((dot, idx) => {
        dot.addEventListener('click', (e) => {
            e.preventDefault();
            goTo(idx);
            startTimer();
        });
    });

    sliderBox.addEventListener('mouseenter', () => {
        isPaused = true;
    });

    sliderBox.addEventListener('mouseleave', () => {
        isPaused = false;
    });

    startTimer();
}

/**
 * 8. Performance Stats Count-up Animation
 * Animates numbers on scroll when the blueprint band enters the viewport.
 */
function initStatsCountUp() {
    const statsSection = document.querySelector('.section-stats-blueprint');
    if (!statsSection) return;

    const counterEls = statsSection.querySelectorAll('[data-counter]');
    if (!counterEls.length) return;

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    let hasRun = false;

    function animateCounters() {
        if (hasRun) return;
        hasRun = true;

        counterEls.forEach((el) => {
            const target = parseInt(el.getAttribute('data-counter'), 10) || 0;
            const prefix = el.getAttribute('data-prefix') || '';
            const suffix = el.getAttribute('data-suffix') || '';

            if (prefersReducedMotion) {
                el.textContent = `${prefix}${target}${suffix}`;
                return;
            }

            const duration = 1200; // 1.2s
            const startTime = performance.now();

            function updateCounter(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                // Ease out cubic
                const easeOut = 1 - Math.pow(1 - progress, 3);
                const currentVal = Math.floor(easeOut * target);

                el.textContent = `${prefix}${currentVal}${suffix}`;

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    el.textContent = `${prefix}${target}${suffix}`;
                }
            }

            requestAnimationFrame(updateCounter);
        });
    }

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animateCounters();
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.25 });

        observer.observe(statsSection);
    } else {
        animateCounters();
    }
}

/**
 * 9. Subtle Scroll Fade-up Observer
 * Adds .is-visible to elements with .fade-in-up class when 15% visible in viewport.
 */
function initScrollAnimations() {
    const fadeEls = document.querySelectorAll('.fade-in-up');
    if (!fadeEls.length) return;

    if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        fadeEls.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    // Enable js-reveal for progressive enhancement
    document.body.classList.add('js-reveal');

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.10 });

    fadeEls.forEach((el) => {
        // If element is already within the initial viewport, mark visible immediately
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0) {
            el.classList.add('is-visible');
        } else {
            observer.observe(el);
        }
    });
}

/**
 * 10. Services Page Sticky Horizontal Chip Navigation
 */
function initServicesNav() {
    const navChips = document.querySelectorAll('.services-nav-chip');
    if (!navChips.length) return;

    navChips.forEach((chip) => {
        chip.addEventListener('click', (e) => {
            const targetId = chip.getAttribute('href');
            if (!targetId || !targetId.startsWith('#')) return;
            const targetEl = document.querySelector(targetId);
            if (!targetEl) return;

            e.preventDefault();
            const headerOffset = window.innerWidth <= 900 ? 115 : 140;
            const elementPosition = targetEl.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });

            navChips.forEach((c) => c.classList.remove('is-active'));
            chip.classList.add('is-active');

            if ('scrollIntoView' in chip) {
                chip.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        });
    });

    const sections = document.querySelectorAll('.service-discipline-section');
    if ('IntersectionObserver' in window && sections.length) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    navChips.forEach((chip) => {
                        const href = chip.getAttribute('href');
                        if (href === `#${id}`) {
                            chip.classList.add('is-active');
                            if ('scrollIntoView' in chip) {
                                chip.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                            }
                        } else {
                            chip.classList.remove('is-active');
                        }
                    });
                }
            });
        }, {
            rootMargin: '-120px 0px -70% 0px',
            threshold: 0
        });

        sections.forEach((sec) => observer.observe(sec));
    }
}

/**
 * 11. Projects Page Category Filter
 */
function initProjectsFilter() {
    const filterBtns = document.querySelectorAll('.projects-filter-btn');
    const projectCards = document.querySelectorAll('.project-portfolio-card');
    if (!filterBtns.length || !projectCards.length) return;

    filterBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            const filter = btn.getAttribute('data-filter') || 'all';

            filterBtns.forEach((b) => {
                b.classList.remove('is-active');
                b.setAttribute('aria-pressed', 'false');
            });
            btn.classList.add('is-active');
            btn.setAttribute('aria-pressed', 'true');

            projectCards.forEach((card) => {
                const category = card.getAttribute('data-category');
                if (filter === 'all' || category === filter) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
}

