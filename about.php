<?php
/**
 * About Us Page - Pavaki Infra
 *
 * Details our civil contracting focus, engineering governance,
 * quality management frameworks, verified operational presence,
 * dedicated Safety First section (#safety), and Careers (#careers).
 */

declare(strict_types=1);

define('APP_INIT', true);
require_once __DIR__ . '/includes/helpers.php';

$pageTitle       = 'About Our Civil Engineering Standards & Operations';
$pageDescription = 'Learn about Pavaki Infra: heavy civil contracting ethos, MoRTH and IRC compliance, quality assurance, safety culture (#safety), and careers (#careers).';
$currentPage     = 'about';

$companyName  = site_config('business.name', 'Pavaki Infra');
$legalName    = site_config('business.legal_name', 'Pavaki Infrasolutions LLP');
$offices      = site_config('business.offices', []);
$principles   = site_config('working_principles', []);

require __DIR__ . '/includes/header.php';
?>

<!-- 1. Page Header Banner (TitanInfra Corporate Style) -->
<section class="about-hero-banner" aria-labelledby="about-title">
    <div class="container">
        <span class="eyebrow-dash">— CORPORATE PROFILE &amp; STANDARDS</span>
        <h1 id="about-title" class="about-hero-title">
            ENGINEERING SCALE WITH <span class="text-amber">ON-SITE RIGOUR</span>
        </h1>
        <p class="about-hero-lead">
            <?= e($legalName); ?> operates as a specialist infrastructure contractor delivering critical civil, structural, marine, and transport works across India to MoRTH, IRC, and Indian Standards codes.
        </p>
    </div>
</section>

<!-- 2. Core Corporate Overview -->
<section class="section section-white" aria-labelledby="overview-heading">
    <div class="container">
        <div class="about-overview-grid">
            
            <div class="about-overview-left">
                <span class="eyebrow-dash">— CONTRACTING ETHOS</span>
                <h2 id="overview-heading" style="font-family: var(--font-display); font-size: clamp(1.75rem, 3vw, 2.5rem); font-weight: 800; text-transform: uppercase; margin-top: var(--space-2); margin-bottom: var(--space-4);">
                    CIVIL CONTRACTING GROUNDED IN <span class="text-amber">EXECUTION</span>
                </h2>
                <p style="font-size: 1.0625rem; font-weight: 600; color: var(--color-text-dark); line-height: 1.5; margin-bottom: var(--space-3);">
                    Large-scale civil infrastructure projects demand technical discipline, modern plant capability, and absolute adherence to engineering specifications.
                </p>
                <p style="color: var(--color-text-body); line-height: 1.65; margin-bottom: var(--space-4);">
                    From registered offices in Lucknow, Uttar Pradesh, and corporate headquarters in Mumbai, Maharashtra, Pavaki Infra mobilises experienced civil engineers, surveying crews, and specialized equipment fleets directly to the workface.
                </p>
                <p style="color: var(--color-text-body); line-height: 1.65; margin-bottom: 0;">
                    Our operational ethos prioritizes site-level competence. Rather than managing from a distance, our project leadership remains embedded on-site, overseeing concrete batching, rebar fabrication, slope stabilisation, and geotechnical testing in direct coordination with client engineers and statutory consultants.
                </p>

                <!-- Key Operating Focus Box -->
                <div class="about-focus-box">
                    <h3 class="about-focus-title">Key Operating Focus:</h3>
                    <ul class="about-focus-list" role="list">
                        <li>Government departments and state development authorities</li>
                        <li>Public Sector Undertakings (PSUs) &amp; Defense civil infrastructure</li>
                        <li>Primary EPC joint ventures and specialist civil sub-contracts</li>
                        <li>Heavy expressway corridors, viaducts, marine piling, and dams</li>
                    </ul>
                </div>
            </div>

            <div class="about-overview-right">
                <div style="border-radius: 4px; overflow: hidden; border: 1px solid var(--color-border-hairline); box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); background-color: var(--color-charcoal); position: relative; aspect-ratio: 16/11;">
                    <img src="<?= e(asset('assets/img/about-corporate.jpg')); ?>" 
                         alt="Pavaki Infra site engineers reviewing engineering drawings" 
                         style="width: 100%; height: 100%; object-fit: cover; display: block;" 
                         loading="lazy" 
                         width="800" 
                         height="550">
                    <div style="position: absolute; bottom: 1rem; left: 1rem; right: 1rem; background-color: rgba(27, 30, 35, 0.88); backdrop-filter: blur(4px); padding: 0.75rem 1rem; border-left: 3px solid var(--color-amber); border-radius: 0 2px 2px 0;">
                        <span style="display: block; font-family: var(--font-display); font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: #FFFFFF;">
                            LUCKNOW &amp; MUMBAI BASES
                        </span>
                        <span style="font-size: 0.75rem; color: rgba(255,255,255,0.7);">
                            Unified engineering mobilization across northern and western corridors.
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 3. Dedicated Safety First Section (#safety) -->
<section id="safety" class="about-safety-section" aria-labelledby="safety-heading">
    <div class="container">
        
        <div class="safety-header-wrap">
            <span class="eyebrow-dash">— SAFETY FIRST</span>
            <h2 id="safety-heading" class="safety-title">
                SAFETY ISN'T JUST A POLICY. IT'S <span class="text-amber">OUR PROMISE.</span>
            </h2>
            <p class="safety-lead">
                We follow global safety standards and rigorous site protocols to ensure the well-being of our workforce, engineering partners, and surrounding communities on every civil project.
            </p>
        </div>

        <div class="about-safety-grid">
            
            <!-- Left: Workforce Photo on Reinforcement Deck -->
            <div class="safety-photo-card">
                <img src="<?= e(asset('assets/img/safety-worker.jpg')); ?>" 
                     alt="Civil engineering workforce on structural reinforcement deck" 
                     class="safety-photo-img" 
                     loading="lazy" 
                     width="800" 
                     height="600">
                <div class="safety-photo-badge">
                    <span>ZERO HARM COMMITMENT</span>
                    <small>MoRTH &amp; OSHA EHS PROTOCOLS</small>
                </div>
            </div>

            <!-- Right: 4 Core Safety Pillars (2x2 Grid) -->
            <div class="safety-cards-2x2">
                
                <!-- Pillar 1: Zero Harm -->
                <div class="safety-pill-card">
                    <div class="safety-card-icon" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <h3 class="safety-card-title">ZERO HARM</h3>
                    <p class="safety-card-desc">
                        Our overarching operational goal is zero lost-time injuries (LTI) through proactive hazard identification and continuous safety monitoring.
                    </p>
                </div>

                <!-- Pillar 2: Compliance -->
                <div class="safety-pill-card">
                    <div class="safety-card-icon" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <h3 class="safety-card-title">COMPLIANCE</h3>
                    <p class="safety-card-desc">
                        100% adherence to national and international statutory codes, MoRTH guidelines, IRC regulations, and client-specific EHS mandates.
                    </p>
                </div>

                <!-- Pillar 3: Trained Teams -->
                <div class="safety-pill-card">
                    <div class="safety-card-icon" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h3 class="safety-card-title">TRAINED TEAMS</h3>
                    <p class="safety-card-desc">
                        Mandatory daily toolbox briefings, certified safety harness protocols, PPE enforcement, and regular emergency response simulation drills.
                    </p>
                </div>

                <!-- Pillar 4: Quality Assured -->
                <div class="safety-pill-card">
                    <div class="safety-card-icon" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                    </div>
                    <h3 class="safety-card-title">QUALITY ASSURED</h3>
                    <p class="safety-card-desc">
                        Rigorous on-site testing for slump, concrete cube compression, rebar yield strength, and structural load testing prior to handover.
                    </p>
                </div>

            </div>

        </div>

    </div>
</section>

<!-- 4. Dedicated Careers Section (#careers) -->
<section id="careers" class="about-careers-section" aria-labelledby="careers-heading">
    <div class="container">
        
        <div class="careers-header-wrap">
            <span class="eyebrow-dash">— CAREERS &amp; FIELD TALENT</span>
            <h2 id="careers-heading" class="careers-title">
                BUILD YOUR CAREER IN <span class="text-amber">CIVIL INFRASTRUCTURE</span>
            </h2>
            <p class="careers-lead">
                Pavaki Infra is expanding execution teams across major expressway, bridge, and marine packages. We recruit competent, field-tested professionals dedicated to engineering precision.
            </p>
        </div>

        <!-- 3 Open Roles Grid -->
        <div class="careers-roles-grid">
            
            <!-- Role 1: Project Manager -->
            <div class="career-role-card">
                <span class="career-role-badge">PROJECT LEADERSHIP</span>
                <h3 class="career-role-title">Senior Civil Project Manager</h3>
                <div class="career-role-meta">
                    <span>Expressways &amp; Highways</span> &bull; <span>Min 10+ Yrs</span>
                </div>
                <p class="career-role-desc">
                    Lead execution of major highway packages, coordinating earthmoving equipment fleets, PQC concrete paving, subcontractor management, and client billing under MoRTH specifications.
                </p>
                <a href="<?= e(url('contact')); ?>?service=roadways-works" class="career-role-apply-btn">
                    <span>APPLY VIA HR DESK</span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

            <!-- Role 2: Bridge Site Engineer -->
            <div class="career-role-card">
                <span class="career-role-badge">STRUCTURAL WORKS</span>
                <h3 class="career-role-title">Bridge / Structural Site Engineer</h3>
                <div class="career-role-meta">
                    <span>PSC Viaducts &amp; Flyovers</span> &bull; <span>Min 5+ Yrs</span>
                </div>
                <p class="career-role-desc">
                    Oversee pier casting, formwork staging, pre-stressed concrete (PSC) I-girder erection, elastomeric bearings, and bridge deck concreting in compliance with IRC standards.
                </p>
                <a href="<?= e(url('contact')); ?>?service=bridge-works" class="career-role-apply-btn">
                    <span>APPLY VIA HR DESK</span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

            <!-- Role 3: Piling Specialist -->
            <div class="career-role-card">
                <span class="career-role-badge">DEEP FOUNDATIONS</span>
                <h3 class="career-role-title">Piling &amp; Geotechnical Engineer</h3>
                <div class="career-role-meta">
                    <span>Rotary Hydraulic Rigs</span> &bull; <span>Min 4+ Yrs</span>
                </div>
                <p class="career-role-desc">
                    Manage large-diameter bored cast-in-situ piling operations, bentonite slurry circulation, casing advancement, tremie concreting, and Cross-hole Sonic Logging (CSL) testing.
                </p>
                <a href="<?= e(url('contact')); ?>?service=piling-works" class="career-role-apply-btn">
                    <span>APPLY VIA HR DESK</span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

        </div>

        <!-- Application CTA Box -->
        <div class="careers-apply-box">
            <div class="careers-apply-content">
                <h3>READY TO BUILD WITH PAVAKI INFRA?</h3>
                <p>
                    Send your updated resume, major project credentials, and current availability to our talent desk at <a href="mailto:info@pavakiinfra.com" style="color: var(--color-amber); text-decoration: underline; font-weight: 700;">info@pavakiinfra.com</a>.
                </p>
            </div>
            <div>
                <a href="<?= e(url('contact')); ?>" class="btn btn-amber" style="white-space: nowrap;">
                    <span>SUBMIT CREDENTIALS &rarr;</span>
                </a>
            </div>
        </div>

    </div>
</section>

<!-- 5. Working Principles Section -->
<section class="section section-white" aria-labelledby="principles-heading">
    <div class="container">
        <span class="eyebrow-dash">— CORE PRINCIPLES</span>
        <h2 id="principles-heading" style="font-family: var(--font-display); font-size: clamp(1.75rem, 3vw, 2.5rem); font-weight: 800; text-transform: uppercase; margin-top: var(--space-2); margin-bottom: var(--space-8);">
            OUR WORKING <span class="text-amber">STANDARDS</span>
        </h2>

        <div class="grid-12">
            <?php foreach ($principles as $p): ?>
            <div class="col-6" style="background-color: var(--color-bg-light); border: 1px solid var(--color-border-hairline); border-left: 3px solid var(--color-amber); padding: var(--space-6); border-radius: 0 4px 4px 0;">
                <h3 style="font-family: var(--font-display); font-size: 1.25rem; font-weight: 800; text-transform: uppercase; color: var(--color-text-dark); margin-bottom: var(--space-2);">
                    <?= e($p['title']); ?>
                </h3>
                <p style="font-size: 0.875rem; color: var(--color-text-body); line-height: 1.6; margin-bottom: 0;">
                    <?= e($p['description']); ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php 
require __DIR__ . '/includes/cta-band.php';
require __DIR__ . '/includes/footer.php';
?>
