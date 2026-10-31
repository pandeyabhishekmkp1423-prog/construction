<?php
/**
 * Contact & Tender Consultations - Pavaki Infra
 *
 * Implements hardened server-side validation, CSRF verification, anti-spam honeypot,
 * time-gates, IP rate limiting, POST-redirect-GET pattern, and verified office directories.
 */

declare(strict_types=1);

define('APP_INIT', true);
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/mailer.php';

// Safe session start for CSRF and flash messaging
start_session_safe();

// Handle Form Submission (POST)
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $errors = [];
    $sanitized = validate_contact_form($_POST, $errors);

    if ($sanitized !== null && empty($errors)) {
        $handled = handle_contact_submission($sanitized);
        if ($handled) {
            flash('contact_success', 'Thank you. Your project enquiry has been logged successfully. Our engineering and estimating team will review your specifications and contact you promptly.');
        } else {
            flash('contact_error', 'We were unable to deliver your enquiry due to a server transmission error. Please reach out directly to our office via telephone or email.');
        }
        header('Location: ' . url('contact'));
        exit;
    } else {
        flash('contact_errors', $errors);
        flash('contact_old', [
            'full_name' => sanitize_text((string)($_POST['full_name'] ?? '')),
            'email'     => sanitize_text((string)($_POST['email'] ?? '')),
            'phone'     => sanitize_text((string)($_POST['phone'] ?? '')),
            'service'   => sanitize_text((string)($_POST['service'] ?? '')),
            'location'  => sanitize_text((string)($_POST['location'] ?? '')),
            'budget'    => sanitize_text((string)($_POST['budget'] ?? '')),
            'details'   => sanitize_textarea((string)($_POST['details'] ?? '')),
        ]);
        header('Location: ' . url('contact'));
        exit;
    }
}

// GET Request: Prepare View Data
$pageTitle       = 'Contact Our Engineering & Estimating Team';
$pageDescription = 'Contact Pavaki Infra’s offices in Lucknow and Mumbai to discuss tender drawings, civil contracting scopes, bills of quantities, or joint ventures.';
$currentPage     = 'contact';

// Retrieve Flash Messages
$successMessage  = flash('contact_success');
$generalError    = flash('contact_error');
$formErrors      = flash('contact_errors') ?? [];
$oldInput        = flash('contact_old') ?? [];

// Pre-fill service from query string if valid
$preselectedService = htmlspecialchars((string)($_GET['service'] ?? ($oldInput['service'] ?? 'general-enquiry')), ENT_QUOTES, 'UTF-8');

$services        = site_config('services', []);
$companyName     = site_config('business.name', 'Pavaki Infra');
$legalName       = site_config('business.legal_name', 'Pavaki Infrasolutions LLP');
$phoneDisplay    = site_config('business.phone', '+91 72087 44092');
$phoneRaw        = site_config('business.phone_raw', '+917208744092');
$emailDisplay    = site_config('business.email', 'info@pavakiinfra.com');
$offices         = site_config('business.offices', []);
$hoursDisplay    = site_config('business.hours', 'Mon – Sat: 09:00 AM – 06:30 PM IST');

require __DIR__ . '/includes/header.php';
?>

<!-- 1. Contact Page Hero Banner (TitanInfra Corporate Style) -->
<section class="contact-page-hero" aria-labelledby="contact-heading">
    <div class="container">
        <span class="eyebrow-dash">— TENDER INQUIRIES &amp; CORPORATE OFFICES</span>
        <h1 id="contact-heading" class="contact-page-title">
            CONTACT OUR ENGINEERING &amp; <span class="text-amber">ESTIMATING TEAM</span>
        </h1>
        <p class="contact-page-lead">
            Connect directly with our engineering desk in Mumbai and Lucknow regarding tender drawings, bills of quantities (BOQ), civil subcontract packages, or joint venture execution.
        </p>
    </div>
</section>

<!-- 2. Contact Page Main Grid Section -->
<section class="contact-page-section" aria-label="Contact form and verified office locations">
    <div class="container">
        <div class="contact-page-grid">
            
            <!-- Left Column: Consultation Enquiry Form -->
            <div class="contact-form-column">
                
                <?php if ($successMessage): ?>
                <div class="alert alert-success" role="alert" tabindex="-1">
                    <div class="alert-title">Enquiry Received</div>
                    <p><?= e($successMessage); ?></p>
                </div>
                <?php endif; ?>

                <?php if ($generalError): ?>
                <div class="alert alert-error" role="alert" tabindex="-1">
                    <div class="alert-title">Submission Notice</div>
                    <p><?= e($generalError); ?></p>
                </div>
                <?php endif; ?>

                <?php if (!empty($formErrors['form'])): ?>
                <div class="alert alert-error" role="alert" tabindex="-1">
                    <div class="alert-title">Please Review</div>
                    <p><?= e($formErrors['form']); ?></p>
                </div>
                <?php endif; ?>

                <div class="contact-form-card">
                    <div class="contact-form-header">
                        <span class="eyebrow-dash">— TECHNICAL SUBMISSION</span>
                        <h2 class="contact-form-title">REQUEST A PROJECT CONSULTATION</h2>
                        <p class="contact-form-desc">
                            Mandatory fields are marked with an asterisk (<span class="req-indicator" aria-hidden="true">*</span>). Our estimators review inquiries within 24 hours.
                        </p>
                    </div>

                    <form action="<?= e(url('contact')); ?>" method="POST" class="contact-page-form" novalidate>
                        <!-- Cryptographic CSRF Token -->
                        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()); ?>">
                        
                        <!-- Anti-Spam Time Gate -->
                        <input type="hidden" name="form_time" value="<?= time(); ?>">

                        <!-- Honeypot Field (Off-screen) -->
                        <div class="hp-field" aria-hidden="true" style="position: absolute; left: -9999px;">
                            <label for="website_hp">Leave this field blank</label>
                            <input type="text" id="website_hp" name="website_hp" tabindex="-1" autocomplete="off">
                        </div>

                        <!-- Name & Email Row -->
                        <div class="contact-form-row">
                            <div class="contact-form-group no-margin">
                                <label for="full_name" class="contact-form-label">
                                    Full Name <span class="req-indicator" aria-label="required">*</span>
                                </label>
                                <input type="text" 
                                       id="full_name" 
                                       name="full_name" 
                                       class="contact-input<?= isset($formErrors['full_name']) ? ' has-error' : ''; ?>" 
                                       value="<?= e($oldInput['full_name'] ?? ''); ?>" 
                                       required 
                                       maxlength="100"
                                       autocomplete="name"
                                       placeholder="e.g. Er. Rajesh Sharma"
                                       <?= isset($formErrors['full_name']) ? 'aria-describedby="err-name" aria-invalid="true"' : ''; ?>>
                                <?php if (isset($formErrors['full_name'])): ?>
                                <span id="err-name" class="field-error-msg" role="alert"><?= e($formErrors['full_name']); ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="contact-form-group no-margin">
                                <label for="email" class="contact-form-label">
                                    Work Email <span class="req-indicator" aria-label="required">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="contact-input<?= isset($formErrors['email']) ? ' has-error' : ''; ?>" 
                                       value="<?= e($oldInput['email'] ?? ''); ?>" 
                                       required 
                                       maxlength="120"
                                       autocomplete="email"
                                       placeholder="name@company.com"
                                       <?= isset($formErrors['email']) ? 'aria-describedby="err-email" aria-invalid="true"' : ''; ?>>
                                <?php if (isset($formErrors['email'])): ?>
                                <span id="err-email" class="field-error-msg" role="alert"><?= e($formErrors['email']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Phone & Discipline Row -->
                        <div class="contact-form-row">
                            <div class="contact-form-group no-margin">
                                <label for="phone" class="contact-form-label">
                                    Telephone Number
                                </label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       class="contact-input<?= isset($formErrors['phone']) ? ' has-error' : ''; ?>" 
                                       value="<?= e($oldInput['phone'] ?? ''); ?>" 
                                       maxlength="30"
                                       autocomplete="tel"
                                       placeholder="+91 98765 43210"
                                       <?= isset($formErrors['phone']) ? 'aria-describedby="err-phone" aria-invalid="true"' : ''; ?>>
                                <?php if (isset($formErrors['phone'])): ?>
                                <span id="err-phone" class="field-error-msg" role="alert"><?= e($formErrors['phone']); ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="contact-form-group no-margin">
                                <label for="service" class="contact-form-label">
                                    Civil Discipline <span class="req-indicator" aria-label="required">*</span>
                                </label>
                                <select id="service" 
                                        name="service" 
                                        class="contact-select<?= isset($formErrors['service']) ? ' has-error' : ''; ?>"
                                        required
                                        <?= isset($formErrors['service']) ? 'aria-describedby="err-service" aria-invalid="true"' : ''; ?>>
                                    <option value="general-enquiry" <?= $preselectedService === 'general-enquiry' ? 'selected' : ''; ?>>
                                        General Infrastructure Inquiry
                                    </option>
                                    <?php foreach ($services as $key => $srv): ?>
                                    <option value="<?= e($key); ?>" <?= $preselectedService === $key ? 'selected' : ''; ?>>
                                        <?= e($srv['number']); ?> / <?= e($srv['title']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($formErrors['service'])): ?>
                                <span id="err-service" class="field-error-msg" role="alert"><?= e($formErrors['service']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Location & Budget Row -->
                        <div class="contact-form-row">
                            <div class="contact-form-group no-margin">
                                <label for="location" class="contact-form-label">
                                    Project Location / State <span class="req-indicator" aria-label="required">*</span>
                                </label>
                                <input type="text" 
                                       id="location" 
                                       name="location" 
                                       class="contact-input<?= isset($formErrors['location']) ? ' has-error' : ''; ?>" 
                                       value="<?= e($oldInput['location'] ?? ''); ?>" 
                                       required 
                                       maxlength="120"
                                       placeholder="e.g. Mumbai, Maharashtra or Chainage km 42"
                                       <?= isset($formErrors['location']) ? 'aria-describedby="err-loc" aria-invalid="true"' : ''; ?>>
                                <?php if (isset($formErrors['location'])): ?>
                                <span id="err-loc" class="field-error-msg" role="alert"><?= e($formErrors['location']); ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="contact-form-group no-margin">
                                <label for="budget" class="contact-form-label">
                                    Estimated Contract Value / Scope
                                </label>
                                <input type="text" 
                                       id="budget" 
                                       name="budget" 
                                       class="contact-input" 
                                       value="<?= e($oldInput['budget'] ?? ''); ?>" 
                                       maxlength="60"
                                       placeholder="e.g. EPC Subcontract / Item-Rate BOQ">
                            </div>
                        </div>

                        <!-- Scope & Details Textarea -->
                        <div class="contact-form-group">
                            <label for="details" class="contact-form-label">
                                Project Scope &amp; Tender Requirements <span class="req-indicator" aria-label="required">*</span>
                            </label>
                            <textarea id="details" 
                                      name="details" 
                                      class="contact-textarea<?= isset($formErrors['details']) ? ' has-error' : ''; ?>" 
                                      required 
                                      maxlength="3000"
                                      placeholder="Please outline the civil scope (e.g. bridge foundations, highway chainage, rotary piling diameter, bulk earthwork quantities, targeted mobilization timeline, or statutory requirements)."
                                      <?= isset($formErrors['details']) ? 'aria-describedby="err-details" aria-invalid="true"' : ''; ?>><?= e($oldInput['details'] ?? ''); ?></textarea>
                            <?php if (isset($formErrors['details'])): ?>
                            <span id="err-details" class="field-error-msg" role="alert"><?= e($formErrors['details']); ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- Consent Checkbox -->
                        <div class="contact-form-group">
                            <label class="contact-checkbox-label" for="privacy_consent">
                                <input type="checkbox" 
                                       id="privacy_consent" 
                                       name="privacy_consent" 
                                       value="1" 
                                       class="contact-checkbox"
                                       required
                                       <?= isset($formErrors['privacy_consent']) ? 'aria-describedby="err-consent" aria-invalid="true"' : ''; ?>>
                                <span>
                                    I consent to having this website store my submitted contact information to respond to this project enquiry in accordance with the <a href="<?= e(url('privacy')); ?>" target="_blank" style="text-decoration: underline; color: var(--color-charcoal); font-weight: 700;">Privacy Notice</a>. <span class="req-indicator" aria-label="required">*</span>
                                </span>
                            </label>
                            <?php if (isset($formErrors['privacy_consent'])): ?>
                            <span id="err-consent" class="field-error-msg" role="alert" style="margin-left: 28px;"><?= e($formErrors['privacy_consent']); ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- Submit Button -->
                        <div style="margin-top: var(--space-6);">
                            <button type="submit" class="btn btn-amber btn-lg" style="width: 100%; justify-content: center;">
                                <span>SUBMIT PROJECT ENQUIRY</span>
                                <span aria-hidden="true">&rarr;</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: Verified Office Directory & Direct Channels -->
            <aside class="contact-sidebar" aria-label="Verified corporate and registered office directory">
                
                <!-- Corporate Office (Mumbai) -->
                <?php if (isset($offices['corporate'])): ?>
                <div class="contact-office-box">
                    <span class="office-box-tag">CORPORATE HEADQUARTERS</span>
                    <h3 class="office-box-title">Mumbai Office</h3>
                    <p class="office-box-address"><?= e($offices['corporate']['address']); ?></p>
                    <a href="<?= e($offices['corporate']['map_url']); ?>" target="_blank" rel="noopener noreferrer" class="office-box-link">
                        <span>OPEN IN GOOGLE MAPS</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
                <?php endif; ?>

                <!-- Registered Office (Lucknow) -->
                <?php if (isset($offices['registered'])): ?>
                <div class="contact-office-box">
                    <span class="office-box-tag">REGISTERED OFFICE</span>
                    <h3 class="office-box-title">Lucknow Office</h3>
                    <p class="office-box-address"><?= e($offices['registered']['address']); ?></p>
                    <a href="<?= e($offices['registered']['map_url']); ?>" target="_blank" rel="noopener noreferrer" class="office-box-link">
                        <span>OPEN IN GOOGLE MAPS</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
                <?php endif; ?>

                <!-- Direct Communications Card -->
                <div class="contact-direct-card">
                    <h3 class="contact-direct-title">DIRECT COMMUNICATION</h3>
                    <p class="contact-direct-desc">
                        For urgent tender notices, engineering drawings, or joint-venture procurement desks:
                    </p>
                    
                    <div class="contact-direct-list">
                        <?php if (has_value($phoneDisplay)): ?>
                        <div class="contact-direct-item">
                            <div class="contact-direct-icon" aria-hidden="true">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </div>
                            <div class="contact-direct-info">
                                <span class="contact-direct-lbl">TELEPHONE / WHATSAPP</span>
                                <a href="tel:<?= e($phoneRaw); ?>" class="contact-direct-val"><?= e($phoneDisplay); ?></a>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (has_value($emailDisplay)): ?>
                        <div class="contact-direct-item">
                            <div class="contact-direct-icon" aria-hidden="true">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m4 4 16 0c1.1 0 2 .9 2 2l0 12c0 1.1-.9 2-2 2L4 20c-1.1 0-2-.9-2-2L2 6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            </div>
                            <div class="contact-direct-info">
                                <span class="contact-direct-lbl">OFFICIAL EMAIL</span>
                                <a href="mailto:<?= e($emailDisplay); ?>" class="contact-direct-val"><?= e($emailDisplay); ?></a>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (has_value($hoursDisplay)): ?>
                        <div class="contact-direct-item">
                            <div class="contact-direct-icon" aria-hidden="true">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                            <div class="contact-direct-info">
                                <span class="contact-direct-lbl">OPERATING HOURS</span>
                                <span class="contact-direct-val" style="font-size: 0.875rem; color: rgba(255,255,255,0.85);"><?= e($hoursDisplay); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

            </aside>

        </div>
    </div>
</section>

<?php 
require __DIR__ . '/includes/cta-band.php';
require __DIR__ . '/includes/footer.php'; 
?>
