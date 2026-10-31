<?php
/**
 * Projects Portfolio Page - Pavaki Infra
 *
 * Visual, image-led presentation of verified landmark civil engineering
 * and infrastructure projects delivered across India.
 */

declare(strict_types=1);

if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}
require_once __DIR__ . '/includes/helpers.php';

$pageTitle       = 'Landmark Infrastructure Projects Portfolio';
$pageDescription = 'Review Pavaki Infra’s verified civil projects: Versova-Bandra Sea Link (Mumbai), Samruddhi Mahamarg protection works, and major institutional buildings.';
$currentPage     = 'projects';

$projects = site_config('projects', []);

require __DIR__ . '/includes/header.php';
?>

<!-- 1. Projects Page Hero Banner (TitanInfra Corporate Style) -->
<section class="projects-hero-banner" aria-labelledby="projects-title">
    <div class="container">
        <span class="eyebrow-dash">— LANDMARK CIVIL PORTFOLIO</span>
        <h1 id="projects-title" class="projects-hero-title">
            DELIVERING NATIONAL <span class="text-amber">INFRASTRUCTURE</span>
        </h1>
        <p class="projects-hero-lead">
            A verified record of major civil, structural, marine, and institutional works delivered in collaboration with state corporations, public sector undertakings, and national infrastructure agencies across India.
        </p>
    </div>
</section>

<!-- 2. Portfolio Filter Bar & Responsive Projects Grid -->
<section class="projects-page-section" aria-label="Projects directory and category filtering">
    <div class="container">
        
        <!-- Category Filter Bar (Vanilla JS with graceful fallback) -->
        <div class="projects-filter-bar" role="toolbar" aria-label="Filter projects by discipline">
            <button type="button" class="projects-filter-btn is-active" data-filter="all" aria-pressed="true">All Disciplines</button>
            <button type="button" class="projects-filter-btn" data-filter="marine-coastal" aria-pressed="false">Marine &amp; Bridges</button>
            <button type="button" class="projects-filter-btn" data-filter="highways" aria-pressed="false">Highways &amp; Civils</button>
            <button type="button" class="projects-filter-btn" data-filter="institutional" aria-pressed="false">Institutional Buildings</button>
            <button type="button" class="projects-filter-btn" data-filter="energy-utilities" aria-pressed="false">Energy &amp; Utilities</button>
        </div>

        <!-- Project Grid (Responsive 3-Column System) -->
        <div class="projects-portfolio-grid" id="projects-grid">
            <?php foreach ($projects as $proj): ?>
            <article class="project-portfolio-card" data-category="<?= e($proj['category']); ?>" id="<?= e($proj['id']); ?>">
                <div class="project-card-media">
                    <img src="<?= e(asset($proj['image'])); ?>" 
                         alt="<?= e($proj['title']); ?> - Pavaki Infra execution" 
                         class="project-card-img" 
                         width="800" 
                         height="500" 
                         loading="lazy">
                    <span class="project-card-badge"><?= e($proj['category_name']); ?></span>
                </div>

                <div class="project-card-body">
                    <div class="project-card-loc">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                        <span><?= e($proj['location']); ?></span>
                    </div>

                    <h2 class="project-card-title">
                        <?= e($proj['title']); ?>
                    </h2>

                    <?php if (!empty($proj['association'])): ?>
                    <div class="project-card-assoc">
                        <?= e($proj['association']); ?>
                    </div>
                    <?php endif; ?>

                    <p class="project-card-summary">
                        <?= e($proj['summary']); ?>
                    </p>

                    <!-- Scope Box -->
                    <div class="project-card-scope-box">
                        <span class="project-scope-lbl">EXECUTED CIVIL SCOPE:</span>
                        <p class="project-scope-txt">
                            <?= e($proj['scope']); ?>
                        </p>
                    </div>

                    <!-- Enquire Link -->
                    <a href="<?= e(url('contact')); ?>?service=<?= urlencode($proj['category']); ?>" class="project-card-link">
                        <span>ENQUIRE ABOUT SIMILAR SCOPE</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<?php 
require __DIR__ . '/includes/cta-band.php';
require __DIR__ . '/includes/footer.php';
?>
