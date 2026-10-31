<?php
/**
 * Home Page - Pavaki Infra (Pavaki Infrasolutions LLP)
 *
 * Rebuilt to match the TitanInfra reference layout, visual system, and aesthetic:
 * 1. Dark Header with logo, uppercase nav, and right solid amber phone block.
 * 2. Hero (~85vh) with dusk bridge photo, 3-line headline, and dual CTAs.
 * 3. What We Do: "— WHAT WE DO / ENGINEERING EXCELLENCE. DELIVERED." with 10 cards in 5x2 grid.
 * 4. Major Projects (Dark charcoal): 3 columns (Left: details + 3 thumbnails, Center: SVG India map with glowing amber pins, Right: project list + link).
 * 5. Safety First: Worker photo left, "SAFETY ISN'T JUST A POLICY. IT'S OUR PROMISE.", and 4 divider columns.
 * 6. Trust, Stats & Testimonials: Slim stats row + Testimonials slider + Authority strip.
 * 7. Contact (Have a Project in Mind? Let's Talk): Split layout with bridge photo & diagonal amber accent left, white form right.
 * 8. Dark Charcoal 5-column Footer with legal links & staff intranet trigger.
 */

declare(strict_types=1);

if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/mailer.php';

start_session_safe();

$pageTitle       = 'Civil Infrastructure & Heavy Engineering Contractors | Pavaki Infra';
$pageDescription = 'Pavaki Infra executes critical civil infrastructure: expressways, marine sea links, bridges, tunnels, and civic complexes across India.';
$currentPage     = 'home';

$services        = site_config('services', []);
$homepageKeys    = site_config('homepage_services', ['roadways-works', 'bridge-works', 'coastal-works', 'building-works']);
$heroSlides      = site_config('hero_slides', []);
$sliderSettings  = site_config('hero_slider_settings', ['showCaption' => false, 'interval' => 5500, 'fadeSpeed' => 900]);
$showCaption     = (bool)($sliderSettings['showCaption'] ?? false);

$allProjects     = site_config('projects', []);
$stats           = site_config('stats', []);
$clientsStrip    = site_config('clients_strip', []);
$testimonials    = site_config('testimonials', []);
$inaugurations   = site_config('inaugurations', []);
$phoneDisplay    = site_config('business.phone', '+91 72087 44092');
$phoneRaw        = site_config('business.phone_raw', '+917208744092');
$emailDisplay    = site_config('business.email', 'info@pavakiinfra.com');

// Form flash messages for embedded CTA enquiry form
$successMessage  = flash('contact_success');
$formErrors      = flash('contact_errors') ?? [];
$oldInput        = flash('contact_old') ?? [];

require __DIR__ . '/includes/header.php';
?>

<!-- 1. Hero Image Slider (Pure Full-Width Visual Slider, No Text) -->
<section class="hero-slider-section" id="hero-slider" aria-label="Pavaki Infra Landmark Civil Infrastructure" tabindex="0">
    <div class="hero-slides-wrapper">
        <?php foreach ($heroSlides as $idx => $slide): ?>
        <div class="hero-slide<?= $idx === 0 ? ' is-active' : ''; ?>" data-slide-index="<?= $idx; ?>" aria-hidden="<?= $idx === 0 ? 'false' : 'true'; ?>">
            <div class="hero-slide-media">
                <img src="<?= e(asset($slide['image'])); ?>" 
                     alt="<?= e($slide['alt']); ?>" 
                     class="hero-slide-img" 
                     width="1920" 
                     height="1080" 
                     <?= $idx === 0 ? 'fetchpriority="high"' : 'loading="lazy"'; ?>>
                <div class="hero-slide-overlay" aria-hidden="true"></div>
            </div>
            <?php if ($showCaption): ?>
            <div class="hero-slide-caption">
                <span class="caption-dash">—</span>
                <span class="caption-title"><?= e($slide['title']); ?></span>
                <span class="caption-loc"><?= e($slide['location']); ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Small amber diagonal cut at bottom-left of slider frame -->
    <div class="hero-diagonal-accent" aria-hidden="true"></div>

    <!-- Desktop Navigation Arrow Buttons (48px circles, white 15% blur, amber hover) -->
    <button type="button" class="hero-nav-arrow hero-prev" id="hero-prev-btn" aria-label="Previous slide">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
    </button>
    <button type="button" class="hero-nav-arrow hero-next" id="hero-next-btn" aria-label="Next slide">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
    </button>

    <!-- Progress Indicator Bars at Bottom Centre -->
    <div class="hero-indicators" role="tablist" aria-label="Slide indicators">
        <?php foreach ($heroSlides as $idx => $slide): ?>
        <button type="button" 
                class="hero-indicator-bar<?= $idx === 0 ? ' is-active' : ''; ?>" 
                data-target-slide="<?= $idx; ?>" 
                role="tab" 
                aria-selected="<?= $idx === 0 ? 'true' : 'false'; ?>" 
                aria-label="Slide <?= $idx + 1; ?>: <?= e($slide['title']); ?>">
            <span class="indicator-fill"></span>
        </button>
        <?php endforeach; ?>
    </div>
</section>

<!-- 2. What We Do (4 Flagship Disciplines, 16:10 Image Cards, Equal Height, View All Link) -->
<section class="section section-what-we-do" id="services-section" aria-labelledby="what-we-do-heading">
    <div class="container">
        <div class="what-we-do-header fade-in-up">
            <span class="eyebrow-dash">— WHAT WE DO</span>
            <h2 id="what-we-do-heading">
                ENGINEERING EXCELLENCE. <span class="text-amber">DELIVERED.</span>
            </h2>
        </div>

        <div class="services-grid-4">
            
            <!-- Card 1: Roadways Works -->
            <?php if (isset($services['roadways-works'])): $s = $services['roadways-works']; ?>
            <a href="<?= e(url('services')); ?>#roadways-works" class="service-image-card fade-in-up">
                <div class="service-card-media">
                    <img src="<?= e(asset($s['image'])); ?>" 
                         alt="<?= e($s['title']); ?> - Pavaki Infra" 
                         class="service-card-img" 
                         loading="lazy" 
                         width="600" 
                         height="375">
                </div>
                <div class="service-card-body">
                    <h3 class="service-card-title"><?= e($s['title']); ?></h3>
                    <p class="service-card-desc"><?= e($s['short_desc']); ?></p>
                    <div class="service-card-action">
                        <span>Scope details &rarr;</span>
                    </div>
                </div>
                <div class="service-card-bar" aria-hidden="true"></div>
            </a>
            <?php endif; ?>

            <!-- Card 2: Bridge Works -->
            <?php if (isset($services['bridge-works'])): $s = $services['bridge-works']; ?>
            <a href="<?= e(url('services')); ?>#bridge-works" class="service-image-card fade-in-up">
                <div class="service-card-media">
                    <img src="<?= e(asset($s['image'])); ?>" 
                         alt="<?= e($s['title']); ?> - Pavaki Infra" 
                         class="service-card-img" 
                         loading="lazy" 
                         width="600" 
                         height="375">
                </div>
                <div class="service-card-body">
                    <h3 class="service-card-title"><?= e($s['title']); ?></h3>
                    <p class="service-card-desc"><?= e($s['short_desc']); ?></p>
                    <div class="service-card-action">
                        <span>Scope details &rarr;</span>
                    </div>
                </div>
                <div class="service-card-bar" aria-hidden="true"></div>
            </a>
            <?php endif; ?>

            <!-- Card 3: Coastal Works -->
            <?php if (isset($services['coastal-works'])): $s = $services['coastal-works']; ?>
            <a href="<?= e(url('services')); ?>#coastal-works" class="service-image-card fade-in-up">
                <div class="service-card-media">
                    <img src="<?= e(asset($s['image'])); ?>" 
                         alt="<?= e($s['title']); ?> - Pavaki Infra" 
                         class="service-card-img" 
                         loading="lazy" 
                         width="600" 
                         height="375">
                </div>
                <div class="service-card-body">
                    <h3 class="service-card-title"><?= e($s['title']); ?></h3>
                    <p class="service-card-desc"><?= e($s['short_desc']); ?></p>
                    <div class="service-card-action">
                        <span>Scope details &rarr;</span>
                    </div>
                </div>
                <div class="service-card-bar" aria-hidden="true"></div>
            </a>
            <?php endif; ?>

            <!-- Card 4: Building Works -->
            <?php if (isset($services['building-works'])): $s = $services['building-works']; ?>
            <a href="<?= e(url('services')); ?>#building-works" class="service-image-card fade-in-up">
                <div class="service-card-media">
                    <img src="<?= e(asset($s['image'])); ?>" 
                         alt="<?= e($s['title']); ?> - Pavaki Infra" 
                         class="service-card-img" 
                         loading="lazy" 
                         width="600" 
                         height="375">
                </div>
                <div class="service-card-body">
                    <h3 class="service-card-title"><?= e($s['title']); ?></h3>
                    <p class="service-card-desc"><?= e($s['short_desc']); ?></p>
                    <div class="service-card-action">
                        <span>Scope details &rarr;</span>
                    </div>
                </div>
                <div class="service-card-bar" aria-hidden="true"></div>
            </a>
            <?php endif; ?>

        </div>

        <!-- Centered Action Link to full 10-discipline services catalog -->
        <div class="services-action-center fade-in-up">
            <a href="<?= e(url('services')); ?>" class="btn btn-amber">
                <span>VIEW ALL 10 DISCIPLINES &rarr;</span>
            </a>
        </div>
    </div>
</section>

<!-- 3. Company Intro Section (Light Grey #F3F4F6, Split Layout, Site Photo + Real Copy) -->
<section class="section section-company-intro" id="about-intro-section" aria-labelledby="about-intro-heading">
    <div class="container">
        <div class="company-intro-grid">
            
            <!-- Left Column: Primary Site Photo (4:5) + Overlapping Heavy Plant Corner Photo -->
            <div class="company-intro-media fade-in-up">
                <div class="company-intro-primary-wrap">
                    <img src="<?= e(asset('assets/img/service-bridges.jpg')); ?>" 
                         alt="Pavaki Infra bridge viaduct structural framework and heavy civil piers under construction" 
                         class="company-intro-primary-img" 
                         loading="lazy" 
                         width="900" 
                         height="600">
                </div>
                <div class="company-intro-badge-overlap">
                    <img src="<?= e(asset('assets/img/service-piling.jpg')); ?>" 
                         alt="Hydraulic rotary piling rig executing deep foundation borehole on active site" 
                         class="company-intro-secondary-img" 
                         loading="lazy" 
                         width="500" 
                         height="312">
                </div>
            </div>

            <!-- Right Column: Eyebrow, H2, 2 Real Copy Paragraphs, Action Link -->
            <div class="company-intro-content fade-in-up">
                <span class="eyebrow-dash">— ABOUT PAVAKI</span>
                <h2 id="about-intro-heading">
                    LEADING CIVIL CONSTRUCTION, <span class="text-amber">BUILT SINCE 2017.</span>
                </h2>
                <p class="company-intro-p">
                    Pavaki Infrasolutions LLP is a high-impact civil engineering contractor executing specialized national infrastructure across India. We deliver critical highway alignments, deep foundation piling, coastal revetments, mountain tunnels, and public institutional complexes for state authorities and Tier-1 EPC concessionaires.
                </p>
                <p class="company-intro-p">
                    Operating primarily across Maharashtra and Uttar Pradesh, our field operations are driven by modern heavy plant readiness, strict MoRTH and IRC specification compliance, and unyielding site safety standards. From open-sea marine piling to high-tolerance concrete pavements, we engineer enduring foundations for national progress.
                </p>
                <div class="company-intro-link-wrap">
                    <a href="<?= e(url('about')); ?>" class="intro-more-link">
                        <span>Read more about our capabilities &rarr;</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 3. Major Projects (Dark Charcoal, 3 Columns: Info+Thumbs, SVG Map, Interactive List) -->
<section class="section section-major-projects" id="projects-section" aria-labelledby="major-projects-heading">
    <div class="container">
        <div class="projects-titan-layout">
            
            <!-- Left Column: Heading, Subtitle, Amber CTA, 3 Project Thumbnails -->
            <div class="projects-col-left">
                <span class="eyebrow-dash">— OUR WORK</span>
                <h2 id="major-projects-heading">
                    MAJOR <span class="text-amber">PROJECTS</span>
                </h2>
                <p class="projects-intro-text">
                    Delivering impactful civil engineering packages across expressways, sea links, and institutional landmarks nationwide.
                </p>

                <div>
                    <a href="<?= e(url('projects')); ?>" class="btn btn-amber">
                        <span>EXPLORE ALL PROJECTS &rarr;</span>
                    </a>
                </div>

                <!-- 3 Project Thumbnail Cards -->
                <div class="projects-thumbs-row">
                    <!-- Thumb 1: Versova Sea Link -->
                    <a href="<?= e(url('projects')); ?>#versova" class="proj-thumb-card" data-project="versova-sea-link">
                        <img src="<?= e(asset('assets/img/project-versova.jpg')); ?>" 
                             alt="Versova-Bandra Sea Link Marine Foundations" 
                             class="proj-thumb-img" 
                             loading="lazy" 
                             width="320" 
                             height="240">
                        <div class="proj-thumb-overlay">
                            <span class="proj-thumb-title">VERSOVA SEA LINK</span>
                            <span class="proj-thumb-loc">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                                <span>Mumbai, MH</span>
                            </span>
                        </div>
                    </a>

                    <!-- Thumb 2: Samruddhi Mahamarg -->
                    <a href="<?= e(url('projects')); ?>#samruddhi" class="proj-thumb-card" data-project="samruddhi-mahamarg">
                        <img src="<?= e(asset('assets/img/project-samruddhi.jpg')); ?>" 
                             alt="Samruddhi Mahamarg Super Expressway" 
                             class="proj-thumb-img" 
                             loading="lazy" 
                             width="320" 
                             height="240">
                        <div class="proj-thumb-overlay">
                            <span class="proj-thumb-title">SAMRUDDHI EXPWY</span>
                            <span class="proj-thumb-loc">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                                <span>Maharashtra</span>
                            </span>
                        </div>
                    </a>

                    <!-- Thumb 3: Atal Sanskritik Sankul -->
                    <a href="<?= e(url('projects')); ?>#atal-sankul" class="proj-thumb-card" data-project="atal-sankul">
                        <img src="<?= e(asset('assets/img/project-agra-sanskritik.jpg')); ?>" 
                             alt="Atal Bihari Sanskritik Sankul Agra" 
                             class="proj-thumb-img" 
                             loading="lazy" 
                             width="320" 
                             height="240">
                        <div class="proj-thumb-overlay">
                            <span class="proj-thumb-title">ATAL SANKUL</span>
                            <span class="proj-thumb-loc">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                                <span>Agra, UP</span>
                            </span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Center Column: India Silhouette Map with Glowing Amber Pins -->
            <div class="projects-col-center">
                <div class="india-map-container" aria-label="Interactive Map of Pavaki Infra Projects Across India">
                    <svg viewBox="0 0 520 600" class="india-map-svg" role="img">
                        <!-- High-contrast dark stylized architectural silhouette of India -->
                        <path class="map-land-path" d="
                            M 195,58 
                            C 205,38 220,24 235,22 
                            C 250,20 262,35 272,48 
                            C 280,60 286,75 284,92 
                            C 282,108 274,118 286,132 
                            C 298,144 322,148 338,142 
                            C 354,136 362,148 375,152 
                            C 390,156 408,148 424,152 
                            C 440,156 452,170 460,185 
                            C 468,202 462,216 448,222 
                            C 432,228 415,220 400,230 
                            C 388,238 382,252 368,258 
                            C 354,264 345,255 334,265 
                            C 328,272 332,284 326,295 
                            C 318,310 305,325 298,342 
                            C 290,362 295,385 285,405 
                            C 275,425 260,450 248,475 
                            C 238,498 228,525 218,548 
                            C 214,558 206,560 202,548 
                            C 192,520 180,488 168,458 
                            C 155,425 142,392 135,360 
                            C 128,335 125,320 115,302 
                            C 105,285 85,290 74,275 
                            C 65,262 76,248 90,245 
                            C 104,242 115,232 102,222 
                            C 86,212 62,216 52,200 
                            C 44,185 58,172 75,168 
                            C 95,164 118,158 132,142 
                            C 148,124 155,102 168,80 
                            C 178,64 186,60 195,58 Z" />
                        
                        <!-- Map Grid Lines / Lat-Long Accents -->
                        <path d="M 60,205 Q 260,225 450,205" fill="none" stroke="rgba(255,255,255,0.06)" stroke-dasharray="4,4" />
                        <path d="M 100,325 Q 240,345 315,325" fill="none" stroke="rgba(255,255,255,0.06)" stroke-dasharray="4,4" />
                        <path d="M 140,430 Q 220,445 280,430" fill="none" stroke="rgba(255,255,255,0.06)" stroke-dasharray="4,4" />
                        <path d="M 235,30 Q 235,280 215,545" fill="none" stroke="rgba(255,255,255,0.04)" stroke-dasharray="4,4" />
                        
                        <!-- Pin 1: Mumbai (Versova-Bandra Sea Link) -->
                        <g class="map-pin" data-project="versova-sea-link" transform="translate(138, 355)">
                            <circle class="map-pin-pulse" cx="0" cy="0" r="10" fill="var(--color-amber)" />
                            <circle class="map-pin-core" cx="0" cy="0" r="5" fill="var(--color-amber)" stroke="#1B1E23" stroke-width="1.5" />
                        </g>

                        <!-- Pin 2: Maharashtra Corridor (Samruddhi Mahamarg) -->
                        <g class="map-pin" data-project="samruddhi-mahamarg" transform="translate(195, 336)">
                            <circle class="map-pin-pulse" cx="0" cy="0" r="10" fill="var(--color-amber)" />
                            <circle class="map-pin-core" cx="0" cy="0" r="5" fill="var(--color-amber)" stroke="#1B1E23" stroke-width="1.5" />
                        </g>

                        <!-- Pin 3: Agra (Atal Sanskritik Sankul) -->
                        <g class="map-pin" data-project="atal-sankul" transform="translate(225, 215)">
                            <circle class="map-pin-pulse" cx="0" cy="0" r="10" fill="var(--color-amber)" />
                            <circle class="map-pin-core" cx="0" cy="0" r="5" fill="var(--color-amber)" stroke="#1B1E23" stroke-width="1.5" />
                        </g>

                        <!-- Pin 4: Ayodhya (Ayodhya Shodh Sansthan) -->
                        <g class="map-pin" data-project="ayodhya-shodh" transform="translate(288, 222)">
                            <circle class="map-pin-pulse" cx="0" cy="0" r="10" fill="var(--color-amber)" />
                            <circle class="map-pin-core" cx="0" cy="0" r="5" fill="var(--color-amber)" stroke="#1B1E23" stroke-width="1.5" />
                        </g>

                        <!-- Pin 5: Varanasi (Solar Park Infra) -->
                        <g class="map-pin" data-project="varanasi-solar" transform="translate(302, 244)">
                            <circle class="map-pin-pulse" cx="0" cy="0" r="10" fill="var(--color-amber)" />
                            <circle class="map-pin-core" cx="0" cy="0" r="5" fill="var(--color-amber)" stroke="#1B1E23" stroke-width="1.5" />
                        </g>

                        <!-- Pin 6: Lucknow (Corporate Registered Office) -->
                        <g class="map-pin" data-project="lucknow-hq" transform="translate(265, 218)">
                            <circle class="map-pin-pulse" cx="0" cy="0" r="10" fill="var(--color-amber)" />
                            <circle class="map-pin-core" cx="0" cy="0" r="5" fill="var(--color-amber)" stroke="#1B1E23" stroke-width="1.5" />
                        </g>
                    </svg>
                </div>
            </div>

            <!-- Right Column: Vertical Project List with Circular Icons -->
            <div class="projects-col-right">
                <ul class="project-list-titan" role="list">
                    
                    <!-- Item 1: Versova Sea Link -->
                    <li class="project-item-titan" data-project="versova-sea-link" tabindex="0">
                        <div class="project-item-icon" aria-hidden="true">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19V7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12"/><path d="M2 19h20"/><path d="M12 5v14"/><path d="M4 11h16"/></svg>
                        </div>
                        <div class="project-item-text">
                            <span class="project-item-title">VERSOVA-BANDRA SEA LINK</span>
                            <span class="project-item-loc">Mumbai, Maharashtra</span>
                        </div>
                    </li>

                    <!-- Item 2: Samruddhi Mahamarg -->
                    <li class="project-item-titan" data-project="samruddhi-mahamarg" tabindex="0">
                        <div class="project-item-icon" aria-hidden="true">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19 8 5"/><path d="m16 5 4 14"/><path d="M12 5v14"/></svg>
                        </div>
                        <div class="project-item-text">
                            <span class="project-item-title">SAMRUDDHI MAHAMARG EXPRESSWAY</span>
                            <span class="project-item-loc">Maharashtra Corridor</span>
                        </div>
                    </li>

                    <!-- Item 3: Atal Sanskritik Sankul -->
                    <li class="project-item-titan" data-project="atal-sankul" tabindex="0">
                        <div class="project-item-icon" aria-hidden="true">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="18" x="3" y="3" rx="1"/><rect width="8" height="12" x="13" y="9" rx="1"/></svg>
                        </div>
                        <div class="project-item-text">
                            <span class="project-item-title">ATAL BIHARI VAJPAYEE SANKUL</span>
                            <span class="project-item-loc">Agra, Uttar Pradesh</span>
                        </div>
                    </li>

                    <!-- Item 4: Ayodhya Shodh Sansthan -->
                    <li class="project-item-titan" data-project="ayodhya-shodh" tabindex="0">
                        <div class="project-item-icon" aria-hidden="true">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V12a7 7 0 0 1 14 0v9"/></svg>
                        </div>
                        <div class="project-item-text">
                            <span class="project-item-title">AYODHYA SHODH SANSTHAN COMPLEX</span>
                            <span class="project-item-loc">Ayodhya, Uttar Pradesh</span>
                        </div>
                    </li>

                    <!-- Item 5: Varanasi Solar Park -->
                    <li class="project-item-titan" data-project="varanasi-solar" tabindex="0">
                        <div class="project-item-icon" aria-hidden="true">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><path d="M12 1v2"/><path d="M12 21v2"/><path d="M4.22 4.22l1.42 1.42"/><path d="M18.36 18.36l1.42 1.42"/></svg>
                        </div>
                        <div class="project-item-text">
                            <span class="project-item-title">VARANASI SOLAR PARK INFRA</span>
                            <span class="project-item-loc">Varanasi, Uttar Pradesh</span>
                        </div>
                    </li>

                </ul>

                <a href="<?= e(url('projects')); ?>" class="and-many-more-link">
                    <span>And many more...</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>

        </div>
    </div>
</section>

<!-- 5. Performance Stats Band (Full-Width Dark Blueprint Grid #16191D) -->
<section class="section section-stats-blueprint" aria-label="Pavaki Infra Track Record Metrics">
    <div class="stats-blueprint-grid" aria-hidden="true"></div>
    <div class="stats-bg-photo" aria-hidden="true"></div>
    <div class="container">
        <div class="stats-band-grid">
            
            <!-- Metric 1: Years Building The Nation -->
            <div class="stats-band-item fade-in-up">
                <span class="stats-band-num" data-counter="8" data-prefix="" data-suffix="+">8+</span>
                <span class="stats-band-label">Years Building The Nation</span>
                <span class="stats-band-sub">Established in 2017</span>
            </div>

            <!-- Metric 2: Prominent Clients & Authorities -->
            <div class="stats-band-item fade-in-up">
                <span class="stats-band-num" data-counter="25" data-prefix="" data-suffix="+">25+</span>
                <span class="stats-band-label">Prominent Authorities</span>
                <span class="stats-band-sub">PSUs &amp; primary concessionaires</span>
            </div>

            <!-- Metric 3: Large Projects Completed On Time -->
            <div class="stats-band-item fade-in-up">
                <span class="stats-band-num" data-counter="45" data-prefix="" data-suffix="+">45+</span>
                <span class="stats-band-label">Completed On Time</span>
                <span class="stats-band-sub">Highways, marine &amp; civic packages</span>
            </div>

            <!-- Metric 4: Crores Worth Executed -->
            <div class="stats-band-item fade-in-up">
                <span class="stats-band-num" data-counter="500" data-prefix="₹" data-suffix="+ Cr">₹500+ Cr</span>
                <span class="stats-band-label">Worth Of Projects Executed</span>
                <span class="stats-band-sub">Cumulative civil contract value</span>
            </div>

        </div>
    </div>
</section>

<!-- 6. Safety First (Worker Left, Promise Heading, 4 Feature Pillars) -->
<section class="section section-safety-first" id="safety-section" aria-labelledby="safety-heading">
    <div class="container">
        <div class="safety-first-grid">
            
            <!-- Left Column: Safety Worker in Hi-Vis and Helmet -->
            <div class="safety-img-wrapper fade-in-up">
                <img src="<?= e(asset('assets/img/safety-worker.jpg')); ?>" 
                     alt="Pavaki Infra site safety engineer conducting quality inspection on active civil worksite" 
                     class="safety-worker-img" 
                     loading="lazy" 
                     width="600" 
                     height="720">
            </div>

            <!-- Right Column: Promise Heading & 4 Feature Pillars -->
            <div class="safety-content-col fade-in-up">
                <span class="eyebrow-dash">— SAFETY FIRST</span>
                <h2 id="safety-heading">
                    SAFETY ISN'T JUST A POLICY. IT'S <span class="text-amber">OUR PROMISE.</span>
                </h2>
                <p class="safety-lead-p">
                    We follow global safety standards, rigorous hazard mitigation protocols, and zero-harm operational disciplines to protect our workforce, engineering partners, and the communities surrounding our infrastructure projects.
                </p>

                <!-- 4 Feature Columns with Clean Vertical Dividers -->
                <div class="safety-pillars-row">
                    
                    <!-- Pillar 1: Zero Harm -->
                    <div class="safety-pillar-col">
                        <div class="safety-pillar-icon" aria-hidden="true">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 12a10 10 0 0 1 20 0v2a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-2z"/>
                                <path d="M12 2v4"/>
                                <path d="M12 18v4"/>
                            </svg>
                        </div>
                        <h4 class="safety-pillar-title">ZERO HARM</h4>
                        <p class="safety-pillar-desc">Our institutional target is zero lost-time incidents across every active project site.</p>
                    </div>

                    <!-- Pillar 2: Compliance -->
                    <div class="safety-pillar-col">
                        <div class="safety-pillar-icon" aria-hidden="true">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                        </div>
                        <h4 class="safety-pillar-title">COMPLIANCE</h4>
                        <p class="safety-pillar-desc">Strict adherence to Indian Standards (IS), MoRTH, and IRC occupational health codes.</p>
                    </div>

                    <!-- Pillar 3: Trained Teams -->
                    <div class="safety-pillar-col">
                        <div class="safety-pillar-icon" aria-hidden="true">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="14" height="18" x="5" y="3" rx="2"/>
                                <path d="M9 7h6"/>
                                <path d="m9 11 2 2 4-4"/>
                                <path d="M9 15h6"/>
                            </svg>
                        </div>
                        <h4 class="safety-pillar-title">TRAINED TEAMS</h4>
                        <p class="safety-pillar-desc">Daily toolbox talks, height-safety certifications, and periodic field emergency drills.</p>
                    </div>

                    <!-- Pillar 4: Quality Assured -->
                    <div class="safety-pillar-col">
                        <div class="safety-pillar-icon" aria-hidden="true">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="6"/>
                                <path d="m15.4 12.5 2.1 7.5-5.5-3-5.5 3 2.1-7.5"/>
                            </svg>
                        </div>
                        <h4 class="safety-pillar-title">QUALITY ASSURED</h4>
                        <p class="safety-pillar-desc">Third-party concrete core testing and structural durability that delivers lasting value.</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- 7. Testimonials & National Leadership Recognition (Light Grey #F3F4F6) -->
<section class="section section-testimonials-inauguration" id="testimonials-section" aria-label="Client Testimonials and Inaugural Recognitions">
    <div class="container">
        
        <!-- Part A: Verified Client Testimonials Slider (Left Dark Badge + Right Quote) -->
        <div class="testimonial-feature-card fade-in-up" id="testimonials-slider">
            <div class="testimonial-feature-badge-col">
                <span class="testimonial-quote-glyph" aria-hidden="true">&ldquo;</span>
                <span class="testimonial-badge-label">VERIFIED REVIEWS</span>
            </div>

            <div class="testimonial-feature-content-col">
                <div class="testimonial-slides-box">
                    <?php foreach ($testimonials as $tIdx => $t): ?>
                    <div class="testimonial-slide-item<?= $tIdx === 0 ? ' is-active' : ''; ?>" data-testimonial-index="<?= $tIdx; ?>" aria-hidden="<?= $tIdx === 0 ? 'false' : 'true'; ?>">
                        <p class="testimonial-quote-p">
                            &ldquo;<?= e($t['quote']); ?>&rdquo;
                        </p>
                        <div class="testimonial-meta-row">
                            <div class="testimonial-author-block">
                                <div class="author-name"><?= e($t['name']); ?></div>
                                <div class="author-role"><?= e($t['designation']); ?> &bull; <?= e($t['org']); ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="testimonial-meta-row" style="border-top: none; padding-top: 0;">
                    <div></div>
                    <div class="testimonial-slider-controls">
                        <button type="button" class="testimonial-arrow-btn" id="testimonial-prev-btn" aria-label="Previous testimonial">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                        </button>
                        <div class="testimonial-dots-wrap" role="tablist" aria-label="Testimonial slides">
                            <?php foreach ($testimonials as $tIdx => $t): ?>
                            <button type="button" 
                                    class="testimonial-dot<?= $tIdx === 0 ? ' is-active' : ''; ?>" 
                                    data-target-testimonial="<?= $tIdx; ?>" 
                                    role="tab" 
                                    aria-selected="<?= $tIdx === 0 ? 'true' : 'false'; ?>" 
                                    aria-label="Testimonial <?= $tIdx + 1; ?>">
                            </button>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="testimonial-arrow-btn" id="testimonial-next-btn" aria-label="Next testimonial">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Part B: Projects Inaugurated by National Leadership (3 Photo Tiles) -->
        <div class="inauguration-strip-wrap">
            <div class="inauguration-header fade-in-up">
                <span class="eyebrow-dash">— NATIONAL RECOGNITION</span>
                <h3>PROJECTS INAUGURATED BY NATIONAL LEADERSHIP</h3>
            </div>

            <div class="inauguration-grid-3">
                <?php foreach ($inaugurations as $inaug): ?>
                <a href="<?= e(url($inaug['link'])); ?>" class="inauguration-tile fade-in-up">
                    <div class="inauguration-media">
                        <img src="<?= e(asset($inaug['image'])); ?>" 
                             alt="<?= e($inaug['project']); ?> - Pavaki Infra" 
                             class="inauguration-img" 
                             loading="lazy" 
                             width="600" 
                             height="375">
                        <div class="inauguration-overlay" aria-hidden="true"></div>
                        <span class="inauguration-badge-tag"><?= e($inaug['badge']); ?></span>
                    </div>
                    <div class="inauguration-caption-body">
                        <h4 class="inauguration-project-name"><?= e($inaug['project']); ?></h4>
                        <div class="inauguration-dignitary-text"><?= e($inaug['dignitary']); ?></div>
                        <div class="inauguration-loc-text"><?= e($inaug['location']); ?></div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</section>

<!-- 8. Contact Section (Split Layout, Full-Height Visual Left, Clean Form Right) -->
<section class="section section-contact-titan" id="contact-section" aria-labelledby="contact-heading">
    <div class="container">
        <div class="contact-split-grid">
            
            <!-- Left Column (45%): 4:5 Photo Filling Full Height, Amber Corner Accent, Overlaid White Card -->
            <div class="contact-visual-col fade-in-up">
                <div class="contact-img-accent-wrapper">
                    <img src="<?= e(asset('assets/img/contact-bridge.jpg')); ?>" 
                         alt="Concrete highway bridge and elevated piers under construction by Pavaki Infra" 
                         class="contact-bridge-img" 
                         loading="lazy" 
                         width="600" 
                         height="750">
                    
                    <!-- Diagonal Amber Accent Corner -->
                    <div class="contact-diagonal-badge" aria-hidden="true"></div>

                    <!-- Overlaid White Contact Details Card -->
                    <div class="contact-overlay-card">
                        <h3 class="contact-overlay-title">HEADQUARTERS &amp; OPERATIONS</h3>
                        <div class="contact-meta-info">
                            <div class="contact-meta-item">
                                <svg class="contact-meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <div class="contact-meta-text">
                                    <strong>Phone:</strong> <a href="tel:<?= e($phoneRaw); ?>"><?= e($phoneDisplay); ?></a>
                                </div>
                            </div>
                            <div class="contact-meta-item">
                                <svg class="contact-meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                <div class="contact-meta-text">
                                    <strong>Email:</strong> <a href="mailto:<?= e($emailDisplay); ?>"><?= e($emailDisplay); ?></a>
                                </div>
                            </div>
                            <div class="contact-meta-item">
                                <svg class="contact-meta-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                <div class="contact-meta-text">
                                    <strong>Corporate Office:</strong> Singh Housing Soc, Singh Sadan, Raghvendra Mandir Road, Mumbai 400102
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column (55%): Form Card Sized to Content with 4-row Textarea and Equal Height -->
            <div class="contact-form-pane fade-in-up">
                <div class="contact-form-card">
                    <div class="contact-form-header">
                        <span class="eyebrow-dash">— LET'S BUILD TOGETHER</span>
                        <h2 id="contact-heading">
                            HAVE A PROJECT IN MIND?<br>
                            <span class="text-amber">LET'S TALK.</span>
                        </h2>
                        <p>
                            Share your project scope, tender package or chainage specifications and our senior civil engineering team will respond within 24 hours.
                        </p>
                    </div>

                    <?php if ($successMessage): ?>
                    <div class="alert alert-success" role="alert">
                        <strong>Request Received:</strong> <?= e($successMessage); ?>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($formErrors['form'])): ?>
                    <div class="alert alert-error" role="alert">
                        <?= e($formErrors['form']); ?>
                    </div>
                    <?php endif; ?>

                    <form action="<?= e(url('contact')); ?>" method="POST" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>">
                        <input type="hidden" name="form_time" value="<?= time(); ?>">
                        
                        <!-- Anti-spam Honeypot -->
                        <div class="hp-field" aria-hidden="true">
                            <input type="text" name="website_hp" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="form-grid-2">
                            <div class="form-field">
                                <label for="contact_name" class="form-field-label">Full Name *</label>
                                <input type="text" id="contact_name" name="full_name" required maxlength="100" class="form-input" placeholder="e.g. Rajesh Kumar" value="<?= e($oldInput['full_name'] ?? ''); ?>">
                            </div>
                            <div class="form-field">
                                <label for="contact_email" class="form-field-label">Email Address *</label>
                                <input type="email" id="contact_email" name="email" required maxlength="120" class="form-input" placeholder="e.g. rajesh@company.com" value="<?= e($oldInput['email'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="form-grid-2">
                            <div class="form-field">
                                <label for="contact_phone" class="form-field-label">Phone Number *</label>
                                <input type="tel" id="contact_phone" name="phone" required maxlength="30" class="form-input" placeholder="+91 00000 00000" value="<?= e($oldInput['phone'] ?? ''); ?>">
                            </div>
                            <div class="form-field">
                                <label for="contact_company" class="form-field-label">Company Name</label>
                                <input type="text" id="contact_company" name="company" maxlength="120" class="form-input" placeholder="e.g. Infrastructure EPC Ltd" value="<?= e($oldInput['company'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="form-grid-2">
                            <div class="form-field">
                                <label for="contact_service" class="form-field-label">Project Type *</label>
                                <select id="contact_service" name="service" required class="form-select">
                                    <option value="general-enquiry">Select Project Type</option>
                                    <?php foreach ($services as $sKey => $sVal): ?>
                                    <option value="<?= e($sKey); ?>"><?= e($sVal['title']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="contact_location" class="form-field-label">Project Location</label>
                                <input type="text" id="contact_location" name="location" maxlength="120" class="form-input" placeholder="e.g. Maharashtra, Uttar Pradesh" value="<?= e($oldInput['location'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="form-field">
                            <label for="contact_details" class="form-field-label">Tell us about your project *</label>
                            <textarea id="contact_details" name="details" required rows="4" class="form-textarea" placeholder="Provide preliminary scope, tender package or chainage specifications..."><?= e($oldInput['details'] ?? ''); ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-amber btn-block" style="margin-top: 0.5rem;">
                            <span>SUBMIT REQUEST &rarr;</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
