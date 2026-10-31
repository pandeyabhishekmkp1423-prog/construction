<?php
/**
 * Privacy Notice - Pavaki Infra
 *
 * Factual disclosure of data collection, server-side JSONL logging,
 * email delivery, rate-limiting tracking, and data security.
 */

declare(strict_types=1);

define('APP_INIT', true);
require_once __DIR__ . '/includes/helpers.php';

$pageTitle       = 'Privacy & Data Processing Notice';
$pageDescription = 'Understand how Pavaki Infra collects, stores, and handles contact and tender enquiry details submitted through this website.';
$currentPage     = 'privacy';

$companyName     = site_config('business.name', 'Pavaki Infra');
$legalName       = site_config('business.legal_name', 'Pavaki Infrasolutions LLP');
$emailDisplay    = site_config('business.email', 'info@pavakiinfra.com');
$offices         = site_config('business.offices', []);

require __DIR__ . '/includes/header.php';
?>

<!-- Privacy Header -->
<section class="section section-warm" aria-labelledby="privacy-heading">
    <div class="container">
        <span class="section-tag">// Data Governance &amp; Security</span>
        <h1 id="privacy-heading" style="margin-bottom: var(--space-4);">
            Privacy &amp; Data Processing Notice
        </h1>
        <p class="lead-p" style="max-width: 80ch;">
            This notice outlines how <?= e($legalName); ?> (<?= e($companyName); ?>) handles data submitted through this website’s technical enquiry form.
        </p>
    </div>
</section>

<!-- Content Terms Section -->
<section class="section" aria-label="Privacy terms and conditions">
    <div class="container" style="max-width: 860px;">
        
        <article style="display: flex; flex-direction: column; gap: var(--space-8);">
            <div>
                <h2>1. Information Collected on Submission</h2>
                <p>
                    When submitting a tender or project enquiry through our contact form, we collect the specific details entered by the user:
                </p>
                <ul style="list-style: disc; padding-left: 1.5rem; display: flex; flex-direction: column; gap: 0.5rem; font-size: var(--text-base);">
                    <li><strong>Full Name:</strong> To identify the correspondent or company representative.</li>
                    <li><strong>Email Address:</strong> To deliver responses, technical queries, or quotation packages.</li>
                    <li><strong>Telephone Number (if provided):</strong> To facilitate direct coordination regarding site visits or tender clarifications.</li>
                    <li><strong>Civil Discipline &amp; Project Location:</strong> To determine operational feasibility and route the enquiry to our Lucknow or Mumbai engineering desk.</li>
                    <li><strong>Project Scope &amp; Estimated Value:</strong> To evaluate technical requirements and assess plant, equipment, and material requirements.</li>
                    <li><strong>Security Metadata:</strong> Client IP address, submission timestamp, and browser user-agent string for anti-spam verification and rate limiting.</li>
                </ul>
            </div>

            <div>
                <h2>2. Purpose of Data Processing</h2>
                <p>
                    Information submitted is used exclusively for legitimate business communication:
                </p>
                <ul style="list-style: disc; padding-left: 1.5rem; display: flex; flex-direction: column; gap: 0.5rem; font-size: var(--text-base);">
                    <li>Evaluating civil construction tender scopes and technical feasibility.</li>
                    <li>Preparing itemised bills of quantities (BOQ) and formal tender quotations.</li>
                    <li>Establishing direct communications for joint ventures or sub-contract agreements.</li>
                </ul>
                <p style="margin-top: var(--space-3);">
                    We do not sell, rent, commercialize, or share enquiry information with third-party advertising or marketing brokers.
                </p>
            </div>

            <div>
                <h2>3. Server-Side Storage &amp; Protection</h2>
                <p>
                    Enquiries are captured with genuine server-side security measures:
                </p>
                <ul style="list-style: disc; padding-left: 1.5rem; display: flex; flex-direction: column; gap: 0.5rem; font-size: var(--text-base);">
                    <li><strong>Protected Storage Log:</strong> Valid submissions are recorded to an access-restricted server log file (<kbd>storage/submissions.jsonl</kbd>) protected by directory permissions (<kbd>.htaccess</kbd>) to prevent data loss in the event of mail transport interruptions.</li>
                    <li><strong>Email Delivery:</strong> A notification email is dispatched directly to our designated office enquiry address (<a href="mailto:<?= e($emailDisplay); ?>" style="text-decoration: underline;"><?= e($emailDisplay); ?></a>).</li>
                    <li><strong>Rate-Limiting Log:</strong> IP addresses and timestamps are recorded in <kbd>storage/rate_limits.json</kbd> solely to prevent automated brute-force spam submissions (limited to 5 submissions per hour per network).</li>
                </ul>
            </div>

            <div>
                <h2>4. Session Cookies &amp; Tracking</h2>
                <p>
                    This website does not load advertising trackers, behavioral analytics pixels, or profiling scripts. A standard temporary PHP session cookie is utilized strictly to provide Cross-Site Request Forgery (CSRF) protection and manage form flash notifications.
                </p>
            </div>

            <div>
                <h2>5. Data Retention &amp; Rights</h2>
                <p>
                    Enquiry logs are retained only as long as necessary for ongoing tender correspondence or active contracting documentation. You may request verification of the details on file or request deletion of your correspondence record by contacting our office:
                </p>
                <div style="background-color: var(--color-bg-warm); border: 1px solid var(--color-hairline); padding: var(--space-6); margin-top: var(--space-4);">
                    <p style="font-weight: 700; margin-bottom: var(--space-2); color: var(--color-charcoal);"><?= e($legalName); ?> (<?= e($companyName); ?>)</p>
                    <p style="margin-bottom: var(--space-1); font-size: var(--text-sm);">Email: <a href="mailto:<?= e($emailDisplay); ?>" style="text-decoration: underline;"><?= e($emailDisplay); ?></a></p>
                    <p style="margin-bottom: 0; font-size: var(--text-sm);">Registered Office: 3/466, Vishvas Khand, Gomti Nagar, Lucknow – 226010, INDIA</p>
                </div>
            </div>
        </article>

    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
