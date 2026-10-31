<?php
/**
 * Services Directory - Pavaki Infra
 *
 * Comprehensive technical specifications across our 10 verified civil engineering
 * and infrastructure disciplines to MoRTH, IRC, and Indian Standards codes.
 */

declare(strict_types=1);

define('APP_INIT', true);
require_once __DIR__ . '/includes/helpers.php';

$pageTitle       = 'Civil Infrastructure & Construction Services';
$pageDescription = 'Explore Pavaki Infra’s 10 core civil engineering capabilities: roadways, bridges, railways, tunnels, coastal marine works, dams, piling, and heavy earthworks.';
$currentPage     = 'services';

$services = site_config('services', []);

require __DIR__ . '/includes/header.php';
?>

<!-- 1. Services Hero Banner (TitanInfra Corporate Style) -->
<section class="services-hero-banner" aria-labelledby="services-hero-title">
    <div class="container">
        <span class="eyebrow-dash">— CIVIL ENGINEERING CAPABILITIES</span>
        <h1 id="services-hero-title" class="services-hero-title">
            SPECIALIZED INFRASTRUCTURE <span class="text-amber">SERVICES</span>
        </h1>
        <p class="services-hero-lead">
            We execute specialized civil contracts across major transport corridors, water resource networks, coastal defenses, and institutional complexes in strict conformance with MoRTH, IRC, and Indian Standards codes.
        </p>

        <!-- Discipline Key Metrics Strip -->
        <div class="services-metrics-strip" role="list">
            <div class="services-metric-item" role="listitem">
                <span class="services-metric-val">10</span>
                <span class="services-metric-lbl">Core Disciplines</span>
            </div>
            <div class="services-metric-item" role="listitem">
                <span class="services-metric-val">MoRTH &amp; IRC</span>
                <span class="services-metric-lbl">Engineering Codes</span>
            </div>
            <div class="services-metric-item" role="listitem">
                <span class="services-metric-val">PSU &amp; EPC</span>
                <span class="services-metric-lbl">Partner Capability</span>
            </div>
            <div class="services-metric-item" role="listitem">
                <span class="services-metric-val">Pan-India</span>
                <span class="services-metric-lbl">Field Mobilization</span>
            </div>
        </div>
    </div>
</section>

<!-- 2. Sticky Horizontal Discipline Filter / Jump Navigation Bar -->
<nav class="services-nav-bar" aria-label="Jump to civil discipline">
    <div class="container">
        <div class="services-nav-container">
            <?php foreach ($services as $key => $srv): ?>
            <a href="#<?= e($srv['id']); ?>" class="services-nav-chip">
                <?= e($srv['title']); ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</nav>

<!-- 3. Comprehensive Discipline Catalog -->
<main class="services-catalog-wrap" id="main-content">
    <?php 
    $index = 0;
    foreach ($services as $key => $srv): 
        $index++;
    ?>
    <section id="<?= e($srv['id']); ?>" class="service-discipline-section" aria-labelledby="heading-<?= e($srv['id']); ?>">
        <div class="container">
            <div class="service-discipline-grid">
                
                <!-- Textual Scope Column -->
                <div class="service-detail-content">
                    <div class="service-detail-header-meta">
                        <span class="service-discipline-chip">DISCIPLINE <?= e($srv['number']); ?></span>
                        <span class="service-discipline-tag">CIVIL SPECIALIZATION</span>
                    </div>

                    <h2 id="heading-<?= e($srv['id']); ?>" class="service-discipline-title">
                        <?= e($srv['title']); ?>
                    </h2>

                    <p class="service-discipline-short">
                        <?= e($srv['short_desc']); ?>
                    </p>

                    <p class="service-discipline-full">
                        <?= e($srv['full_desc']); ?>
                    </p>

                    <!-- Scope Deliverables Box -->
                    <div class="service-scope-box">
                        <h3 class="service-scope-title">Key Technical Scope &amp; Deliverables</h3>
                        <ul class="service-scope-list" role="list">
                            <?php foreach ($srv['typical_scope'] as $item): ?>
                            <li class="service-scope-item">
                                <span class="service-scope-icon" aria-hidden="true">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                </span>
                                <span><?= e($item); ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Ideal Procurement Profile -->
                    <div class="service-procurement-card">
                        <span class="procurement-label">IDEAL PROCUREMENT PROFILE</span>
                        <p class="procurement-desc">
                            <?= e($srv['ideal_for']); ?>
                        </p>
                    </div>

                    <!-- Action Button -->
                    <div class="service-action-wrap">
                        <a href="<?= e(url('contact')); ?>?service=<?= urlencode($srv['id']); ?>" class="btn btn-amber service-action-btn">
                            <span>ENQUIRE ABOUT <?= strtoupper(e($srv['title'])); ?></span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- Media Visual Column -->
                <div class="service-detail-media">
                    <div class="service-media-frame">
                        <img src="<?= e(asset($srv['image'])); ?>" 
                             alt="<?= e($srv['title']); ?> - Pavaki Infra heavy civil execution" 
                             class="service-media-img"
                             width="800" 
                             height="500" 
                             loading="lazy">
                        <div class="service-media-badge">
                            <span class="media-badge-code">DISCIPLINE <?= e($srv['number']); ?></span>
                            <span class="media-badge-tag">MORTH / IRC SPEC</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <?php endforeach; ?>
</main>

<?php 
require __DIR__ . '/includes/cta-band.php';
require __DIR__ . '/includes/footer.php';
?>
