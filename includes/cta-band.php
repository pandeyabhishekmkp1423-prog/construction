<?php
/**
 * Shared Call to Action Band - Pavaki Infra
 *
 * Restrained engineering consultation banner for EPC contractors,
 * public sector bodies, and infrastructure clients.
 */

declare(strict_types=1);

if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}
?>
<section class="cta-band" aria-labelledby="cta-heading">
    <div class="container">
        <div class="cta-band-grid">
            <div class="cta-band-content">
                <span class="eyebrow-dash">— PROCUREMENT &amp; TENDERS</span>
                <h2 id="cta-heading" class="cta-band-title">
                    PLANNING AN INFRASTRUCTURE PACKAGE OR <span class="text-amber">CIVIL TENDER?</span>
                </h2>
                <p class="cta-band-desc">
                    From expressway earthworks and marine piling to structural bridge erection and institutional complexes, our engineering team reviews technical drawings, soil reports, and bills of quantities.
                </p>
            </div>
            <div class="cta-band-actions">
                <a href="<?= e(url('contact')); ?>" class="btn btn-amber">
                    <span>REQUEST AN ENQUIRY</span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
                <a href="<?= e(url('services')); ?>" class="btn btn-outline-white">
                    <span>ALL DISCIPLINES</span>
                </a>
            </div>
        </div>
    </div>
</section>
