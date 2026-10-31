<?php
/**
 * Shared Header Component - Pavaki Infra
 *
 * Renders document head, SEO metadata, Open Graph, Twitter cards,
 * Google Fonts, SVG favicon links, LocalBusiness JSON-LD schema, and skiplink.
 */

declare(strict_types=1);

if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}

require_once __DIR__ . '/helpers.php';

$companyName     = site_config('business.name', 'Pavaki Infra');
$legalName       = site_config('business.legal_name', 'Pavaki Infrasolutions LLP');
$pageTitle       = $pageTitle ?? 'Civil Infrastructure & Engineering Contractors';
$pageDescription = $pageDescription ?? 'Pavaki Infra delivers major civil engineering infrastructure: roadways, bridges, railways, tunnels, marine coastal works, and institutional buildings across India.';
$currentPage     = $currentPage ?? 'home';
$pageImage       = $pageImage ?? asset('assets/img/hero-bridge.jpg');
$isSiteLive      = (bool)site_config('site_live', false);

$canonicalUrl    = site_config('base_url') !== 'auto' 
    ? rtrim((string)site_config('base_url'), '/') . url($currentPage === 'home' ? '' : $currentPage)
    : '';

$phoneDisplay    = site_config('business.phone', '');
$phoneRaw        = site_config('business.phone_raw', '');
$emailDisplay    = site_config('business.email', '');
$offices         = site_config('business.offices', []);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle); ?> | <?= e($companyName); ?></title>
    <meta name="description" content="<?= e($pageDescription); ?>">
    
    <?php if (!$isSiteLive): ?>
    <!-- Pre-launch staging safeguard: blocks search engine indexing until launch is confirmed -->
    <meta name="robots" content="noindex, nofollow">
    <?php else: ?>
    <meta name="robots" content="index, follow">
    <?php endif; ?>

    <?php if (!empty($canonicalUrl)): ?>
    <link rel="canonical" href="<?= e($canonicalUrl); ?>">
    <?php endif; ?>

    <!-- Preconnect & Google Fonts: Barlow Condensed (Display Headings) & Inter (Body Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Preload Critical Above-The-Fold Assets -->
    <link rel="preload" as="image" href="<?= e(asset('assets/img/Pavaki-TM-Logo.webp')); ?>" type="image/webp">
    <link rel="preload" as="image" href="<?= e(asset('assets/img/project-versova.jpg')); ?>">

    <!-- Favicon & Icons -->
    <link rel="icon" type="image/svg+xml" href="<?= e(asset('assets/img/favicon.svg')); ?>">

    <!-- Open Graph Metadata -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= e($companyName); ?>">
    <meta property="og:title" content="<?= e($pageTitle); ?>">
    <meta property="og:description" content="<?= e($pageDescription); ?>">
    <?php if (!empty($canonicalUrl)): ?>
    <meta property="og:url" content="<?= e($canonicalUrl); ?>">
    <?php endif; ?>
    <meta property="og:image" content="<?= e($pageImage); ?>">

    <!-- Twitter Card Metadata -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($pageTitle); ?>">
    <meta name="twitter:description" content="<?= e($pageDescription); ?>">
    <meta name="twitter:image" content="<?= e($pageImage); ?>">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="<?= e(asset('assets/css/style.css')); ?>">

    <?php
    // Structured Data: Organization & GeneralContractor (Verified Facts Only)
    $schema = [
        '@context' => 'https://schema.org',
        '@type'    => 'GeneralContractor',
        'name'     => $companyName,
        'legalName'=> $legalName,
        'url'      => !empty($canonicalUrl) ? $canonicalUrl : 'https://pavakiinfra.com',
        'email'    => $emailDisplay,
        'telephone'=> $phoneDisplay,
        'areaServed'=> 'India',
        'address'  => [
            [
                '@type' => 'PostalAddress',
                'name' => 'Corporate Office (Mumbai)',
                'streetAddress' => 'Singh Housing Soc, Singh Sadan, Raghvendra Mandir Road',
                'addressLocality' => 'Mumbai',
                'addressRegion' => 'Maharashtra',
                'postalCode' => '400102',
                'addressCountry' => 'IN'
            ],
            [
                '@type' => 'PostalAddress',
                'name' => 'Registered Office (Lucknow)',
                'streetAddress' => '3/466, Vishvas Khand, Gomti Nagar',
                'addressLocality' => 'Lucknow',
                'addressRegion' => 'Uttar Pradesh',
                'postalCode' => '226010',
                'addressCountry' => 'IN'
            ]
        ]
    ];
    ?>
    <script type="application/ld+json">
    <?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); ?>
    </script>
</head>
<body class="<?= e($currentPage); ?>-page">
    <!-- Skip to main content landmark for keyboard users -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- Main Navigation Header Landmark (White, Sticky 72px) -->
    <header class="site-header" id="site-header" role="banner">
        <?php require __DIR__ . '/nav.php'; ?>
    </header>

    <!-- Main Content Landmark -->
    <main id="main-content" class="site-main" role="main">
