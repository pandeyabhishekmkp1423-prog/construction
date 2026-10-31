<?php
/**
 * Main Navigation Bar Component - Pavaki Infra
 *
 * Rebuilt to match the TitanInfra reference layout & aesthetic:
 * - Dark charcoal bar (#1B1E23)
 * - Brand logo left
 * - Uppercase navigation links (HOME, SERVICES, PROJECTS, ABOUT US, SAFETY, CAREERS, CONTACT)
 * - Amber underline for active item (#F5B301)
 * - Far-right solid amber block with phone icon, number (+91 72087 44092), and subtext (Call for enquiries)
 * - Accessible mobile drawer and tap-to-call button
 */

declare(strict_types=1);

if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}

$currentPage  = $currentPage ?? 'home';
$companyName  = site_config('business.name', 'Pavaki Infra');
$phoneDisplay = site_config('business.phone', '+91 72087 44092');
$phoneRaw     = site_config('business.phone_raw', '+917208744092');
?>
<div class="nav-bar nav-bar-dark">
    <div class="nav-container">
        <!-- Brand Logo Lockup -->
        <a href="<?= e(url('')); ?>" class="brand-link" aria-label="<?= e($companyName); ?> - Heavy Civil &amp; Infrastructure Contractors">
            <img src="<?= e(asset('assets/img/Pavaki-TM-Logo.webp')); ?>" 
                 alt="<?= e($companyName); ?> - Civil &amp; Infrastructure" 
                 width="230" 
                 height="52" 
                 class="brand-logo-img">
        </a>

        <!-- Desktop Navigation Menu -->
        <nav id="primary-nav-menu" class="nav-menu" aria-label="Primary site navigation">
            <ul class="nav-list" role="list">
                <li class="nav-item">
                    <a href="<?= e(url('')); ?>" 
                       class="nav-link<?= $currentPage === 'home' ? ' active' : ''; ?>"
                       <?= $currentPage === 'home' ? ' aria-current="page"' : ''; ?>>
                        HOME
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?= e(url('services')); ?>" 
                       class="nav-link<?= $currentPage === 'services' ? ' active' : ''; ?>"
                       <?= $currentPage === 'services' ? ' aria-current="page"' : ''; ?>>
                        SERVICES
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= e(url('projects')); ?>" 
                       class="nav-link<?= $currentPage === 'projects' ? ' active' : ''; ?>"
                       <?= $currentPage === 'projects' ? ' aria-current="page"' : ''; ?>>
                        PROJECTS
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= e(url('about')); ?>" 
                       class="nav-link<?= $currentPage === 'about' ? ' active' : ''; ?>"
                       <?= $currentPage === 'about' ? ' aria-current="page"' : ''; ?>>
                        ABOUT US
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= e(url('about')); ?>#safety" class="nav-link">
                        SAFETY
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= e(url('about')); ?>#careers" class="nav-link">
                        CAREERS
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= e(url('contact')); ?>" 
                       class="nav-link<?= $currentPage === 'contact' ? ' active' : ''; ?>"
                       <?= $currentPage === 'contact' ? ' aria-current="page"' : ''; ?>>
                        CONTACT
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Right Solid Amber Phone Block (TitanInfra Style) -->
        <a href="tel:<?= e($phoneRaw); ?>" class="nav-phone-badge" aria-label="Call for enquiries: <?= e($phoneDisplay); ?>">
            <span class="phone-badge-icon" aria-hidden="true">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
            </span>
            <span class="phone-badge-content">
                <span class="phone-badge-number"><?= e($phoneDisplay); ?></span>
                <span class="phone-badge-sub">CALL FOR ENQUIRIES</span>
            </span>
        </a>

        <!-- Mobile Navigation Drawer Toggle -->
        <button type="button" 
                class="nav-toggle" 
                id="mobile-nav-toggle"
                aria-controls="mobile-nav-drawer" 
                aria-expanded="false" 
                aria-label="Toggle navigation menu">
            <span class="nav-toggle-icon" aria-hidden="true"><span></span></span>
            <span class="nav-toggle-text">Menu</span>
        </button>
    </div>
</div>

<!-- Mobile Navigation Drawer (Full-Screen Slide-in) -->
<div id="mobile-nav-drawer" class="mobile-drawer" aria-hidden="true">
    <div class="mobile-drawer-inner">
        <div class="mobile-drawer-header">
            <img src="<?= e(asset('assets/img/Pavaki-TM-Logo.webp')); ?>" 
                 alt="<?= e($companyName); ?>" 
                 width="180" 
                 height="42" 
                 class="brand-logo-img">
            <button type="button" class="drawer-close-btn" id="mobile-drawer-close" aria-label="Close navigation menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        <nav class="mobile-nav-links" aria-label="Mobile Navigation">
            <a href="<?= e(url('')); ?>" class="mobile-link<?= $currentPage === 'home' ? ' active' : ''; ?>">
                HOME
            </a>
            <a href="<?= e(url('services')); ?>" class="mobile-link<?= $currentPage === 'services' ? ' active' : ''; ?>">
                SERVICES
            </a>
            <a href="<?= e(url('projects')); ?>" class="mobile-link<?= $currentPage === 'projects' ? ' active' : ''; ?>">
                PROJECTS
            </a>
            <a href="<?= e(url('about')); ?>" class="mobile-link<?= $currentPage === 'about' ? ' active' : ''; ?>">
                ABOUT US
            </a>
            <a href="<?= e(url('about')); ?>#safety" class="mobile-link">
                SAFETY
            </a>
            <a href="<?= e(url('about')); ?>#careers" class="mobile-link">
                CAREERS
            </a>
            <a href="<?= e(url('contact')); ?>" class="mobile-link<?= $currentPage === 'contact' ? ' active' : ''; ?>">
                CONTACT
            </a>
        </nav>

        <div class="mobile-drawer-footer">
            <a href="tel:<?= e($phoneRaw); ?>" class="btn btn-amber btn-block" style="margin-bottom: var(--space-4);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
                <span><?= e($phoneDisplay); ?></span>
            </a>
            <a href="<?= e(url('contact')); ?>" class="btn btn-outline-white btn-block" style="margin-bottom: var(--space-4);">
                <span>REQUEST AN ENQUIRY &rarr;</span>
            </a>
            <div class="mobile-contact-meta">
                <p><strong>Mumbai Corporate:</strong> Singh Sadan, Raghvendra Mandir Rd, 400102</p>
                <p><strong>Lucknow Registered:</strong> 3/466, Gomti Nagar, 226010</p>
            </div>
            <div style="margin-top: var(--space-4); padding-top: var(--space-4); border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="#employee-login-modal" class="employee-mobile-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <span>Staff Portal Access</span>
                </a>
            </div>
        </div>
    </div>
</div>
