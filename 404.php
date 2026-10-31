<?php
/**
 * Custom 404 Error Page - Pavaki Infra
 *
 * Friendly, branded 404 handler with HTTP 404 status code and navigation links.
 */

declare(strict_types=1);

if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}
require_once __DIR__ . '/includes/helpers.php';

http_response_code(404);

$pageTitle       = 'Page Not Located (404)';
$pageDescription = 'The requested infrastructure document or page could not be located. Browse Pavaki Infra’s civil services or contact our estimating team.';
$currentPage     = '404';

require __DIR__ . '/includes/header.php';
?>

<section class="section section-warm" style="padding-top: var(--space-20); padding-bottom: var(--space-20);" aria-labelledby="error-heading">
    <div class="container text-center" style="max-width: 640px; margin: 0 auto; text-align: center;">
        <span class="section-tag" style="justify-content: center;">// HTTP Status 404</span>
        <h1 id="error-heading" style="font-size: var(--text-4xl); margin-top: var(--space-2); margin-bottom: var(--space-4);">
            Document Not Located
        </h1>
        <p class="lead-p" style="color: var(--color-steel); margin-bottom: var(--space-8); max-width: none;">
            The page or project record you requested does not exist on this server or may have been relocated during our site updates.
        </p>

        <div style="background-color: var(--color-bg-white); border: 1px solid var(--color-hairline); padding: var(--space-6); margin-bottom: var(--space-8); text-align: left;">
            <h2 style="font-size: var(--text-base); margin-bottom: var(--space-3); text-transform: uppercase; font-family: var(--font-mono); color: var(--color-charcoal);">
                Suggested Navigation:
            </h2>
            <ul style="display: flex; flex-direction: column; gap: var(--space-2); font-size: var(--text-sm);">
                <li>
                    <a href="<?= e(url('')); ?>" class="link-editorial">Home Page</a> &mdash; Overview of civil capabilities and landmark projects.
                </li>
                <li>
                    <a href="<?= e(url('services')); ?>" class="link-editorial">Civil Disciplines</a> &mdash; Roadways, bridges, railways, tunnels, marine works, and piling.
                </li>
                <li>
                    <a href="<?= e(url('projects')); ?>" class="link-editorial">Landmark Projects</a> &mdash; Verified civil case records.
                </li>
                <li>
                    <a href="<?= e(url('contact')); ?>" class="link-editorial">Contact &amp; Tenders</a> &mdash; Inquire directly with our engineering desk.
                </li>
            </ul>
        </div>

        <div>
            <a href="<?= e(url('')); ?>" class="btn btn-primary">
                Return to Homepage
            </a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
