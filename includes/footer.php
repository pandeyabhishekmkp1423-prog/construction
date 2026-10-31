<?php
/**
 * Shared Footer Component - Pavaki Infra
 *
 * 5-Column dark charcoal footer matching the TitanInfra reference layout & aesthetic:
 * - Brand lockup & social media links
 * - Company navigation
 * - Civil disciplines / Services
 * - Resources & Governance
 * - Contact direct information
 * - Copyright strip with Privacy Policy, Terms, and Employee Intranet modal link
 */

declare(strict_types=1);

if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}

$companyName  = site_config('business.name', 'Pavaki Infra');
$legalName    = site_config('business.legal_name', 'Pavaki Infrasolutions LLP');
$phoneDisplay = site_config('business.phone', '+91 72087 44092');
$phoneRaw     = site_config('business.phone_raw', '+917208744092');
$emailDisplay = site_config('business.email', 'info@pavakiinfra.com');
$offices      = site_config('business.offices', []);
$services     = site_config('services', []);
$social       = site_config('business.social', []);
?>
    </main><!-- /.site-main -->

    <footer class="site-footer" role="contentinfo">
        <div class="container footer-container">
            <div class="footer-grid-5">
                
                <!-- Column 1: Brand & Blurb -->
                <div class="footer-col footer-col-brand">
                    <a href="<?= e(url('')); ?>" class="footer-logo-link" aria-label="<?= e($companyName); ?> Home">
                        <img src="<?= e(asset('assets/img/Pavaki-TM-Logo.webp')); ?>" 
                             alt="<?= e($companyName); ?>" 
                             width="220" 
                             height="52" 
                             class="footer-logo-img">
                    </a>
                    <p class="footer-blurb">
                        Building reliable infrastructure that powers progress and improves lives across India with engineering rigour and safety excellence.
                    </p>
                    
                    <!-- Social Links -->
                    <div class="footer-social-row" aria-label="Social media profiles">
                        <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="Pavaki Infra on LinkedIn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
                        </a>
                        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="Pavaki Infra on Facebook">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                        </a>
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="Pavaki Infra on Instagram">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                        </a>
                        <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="Pavaki Infra on YouTube">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><polygon points="10 15 15 12 10 9 10 15"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Column 2: Company -->
                <div class="footer-col">
                    <h4 class="footer-col-title">COMPANY</h4>
                    <ul class="footer-link-list" role="list">
                        <li><a href="<?= e(url('about')); ?>" class="footer-nav-link">About Us</a></li>
                        <li><a href="<?= e(url('about')); ?>#leadership" class="footer-nav-link">Leadership</a></li>
                        <li><a href="<?= e(url('about')); ?>#careers" class="footer-nav-link">Careers</a></li>
                        <li><a href="<?= e(url('projects')); ?>" class="footer-nav-link">News &amp; Updates</a></li>
                        <li><a href="<?= e(url('about')); ?>#safety" class="footer-nav-link">Quality Policy</a></li>
                    </ul>
                </div>

                <!-- Column 3: Services -->
                <div class="footer-col">
                    <h4 class="footer-col-title">SERVICES</h4>
                    <ul class="footer-link-list" role="list">
                        <li><a href="<?= e(url('services')); ?>#bridges-flyovers" class="footer-nav-link">Bridge &amp; Structures</a></li>
                        <li><a href="<?= e(url('services')); ?>#roads-highways" class="footer-nav-link">Roads &amp; Highways</a></li>
                        <li><a href="<?= e(url('services')); ?>#civic-institutional" class="footer-nav-link">Urban Infrastructure</a></li>
                        <li><a href="<?= e(url('services')); ?>#piling-foundations" class="footer-nav-link">Construction Management</a></li>
                        <li><a href="<?= e(url('services')); ?>" class="footer-nav-link">Survey &amp; Design</a></li>
                        <li><a href="<?= e(url('services')); ?>#dams-irrigation" class="footer-nav-link">Environment &amp; Sustainability</a></li>
                    </ul>
                </div>

                <!-- Column 4: Resources -->
                <div class="footer-col">
                    <h4 class="footer-col-title">RESOURCES</h4>
                    <ul class="footer-link-list" role="list">
                        <li><a href="<?= e(url('projects')); ?>" class="footer-nav-link">Projects</a></li>
                        <li><a href="<?= e(url('about')); ?>#safety" class="footer-nav-link">Safety</a></li>
                        <li><a href="<?= e(url('about')); ?>" class="footer-nav-link">Quality</a></li>
                        <li><a href="<?= e(url('contact')); ?>" class="footer-nav-link">Downloads</a></li>
                        <li><a href="<?= e(url('privacy')); ?>" class="footer-nav-link">Policies</a></li>
                    </ul>
                </div>

                <!-- Column 5: Contact Us -->
                <div class="footer-col footer-col-contact">
                    <h4 class="footer-col-title">CONTACT US</h4>
                    <div class="footer-contact-items">
                        <div class="footer-contact-item">
                            <svg class="footer-contact-icon text-amber" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            <a href="tel:<?= e($phoneRaw); ?>" class="footer-contact-text"><?= e($phoneDisplay); ?></a>
                        </div>
                        <div class="footer-contact-item">
                            <svg class="footer-contact-icon text-amber" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            <a href="mailto:<?= e($emailDisplay); ?>" class="footer-contact-text"><?= e($emailDisplay); ?></a>
                        </div>
                        <div class="footer-contact-item">
                            <svg class="footer-contact-icon text-amber" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span class="footer-contact-text">
                                Singh Sadan, Raghvendra Mandir Rd, Mumbai, Maharashtra 400102
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer Bottom Strip -->
            <div class="footer-bottom-strip">
                <div class="footer-copy">
                    &copy; 2026 <?= e($legalName); ?>. All Rights Reserved.
                </div>
                <div class="footer-bottom-actions">
                    <a href="<?= e(url('privacy')); ?>" class="footer-sub-link">Privacy Policy</a>
                    <span class="sub-sep" aria-hidden="true">|</span>
                    <a href="<?= e(url('privacy')); ?>#terms" class="footer-sub-link">Terms of Use</a>
                    <span class="sub-sep" aria-hidden="true">|</span>
                    <a href="#employee-login-modal" class="footer-sub-link footer-staff-link">
                        <span>Employee Login</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Employee Portal Accessible Modal -->
    <div id="employee-login-modal" class="modal-overlay" aria-hidden="true" role="dialog" aria-labelledby="modal-staff-title">
        <div class="modal-card">
            <button type="button" class="modal-close-btn" id="modal-staff-close" aria-label="Close staff login dialog">&times;</button>
            <span class="eyebrow-dash">— INTERNAL PORTAL</span>
            <h3 id="modal-staff-title" style="margin-bottom: 0.5rem; color: #FFFFFF;">Staff &amp; Field Intranet</h3>
            <p style="font-size: 0.875rem; color: #9AA4B2; margin-bottom: 1.25rem;">
                Restricted access portal for authorized Pavaki Infrasolutions site engineers, project managers, and procurement staff.
            </p>
            <form onsubmit="event.preventDefault(); alert('Staff authentication requires secure corporate VPN or site terminal access. Please contact IT Administration at info@pavakiinfra.com.');">
                <div class="form-field">
                    <label class="form-field-label">Staff Employee ID</label>
                    <input type="text" class="form-input" placeholder="e.g. PI-ENG-840" required autocomplete="off">
                </div>
                <div class="form-field">
                    <label class="form-field-label">Intranet Passcode / OTP</label>
                    <input type="password" class="form-input" placeholder="••••••••" required autocomplete="off">
                </div>
                <button type="submit" class="btn btn-amber btn-block" style="margin-top: 1rem;">
                    <span>AUTHENTICATE SESSION &rarr;</span>
                </button>
            </form>
            <div style="margin-top: 1rem; padding-top: 0.75rem; border-top: 1px solid rgba(255,255,255,0.1); font-size: 0.75rem; color: #6B7684;">
                Encrypted with TLS 1.3. For access requests or lost tokens, contact IT Desk.
            </div>
        </div>
    </div>

    <!-- Vanilla JavaScript -->
    <script src="<?= e(asset('assets/js/main.js')); ?>"></script>
</body>
</html>
