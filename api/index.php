<?php
/**
 * Vercel Serverless Function Entry Point - Pavaki Infra
 *
 * Bridges incoming Vercel HTTP requests to the Core PHP application,
 * normalises server environment variables, enforces clean URLs,
 * and executes the appropriate view with full filesystem context.
 */

declare(strict_types=1);

// Establish the true project root directory (parent of /api)
$projectRoot = dirname(__DIR__);

// Normalize document root and working directory
$_SERVER['DOCUMENT_ROOT'] = $projectRoot;
chdir($projectRoot);

// Ensure bootstrap token is defined
if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}

// Parse request URI
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$parsed = parse_url($requestUri);
$path = urldecode($parsed['path'] ?? '/');
$trimmed = trim($path, '/');

// 1. Canonical 301 Redirect: if client requests a URL ending in .php, redirect to clean URL
if (preg_match('#^/(.+)\.php$#i', $path, $matches)) {
    $cleanSlug = $matches[1];
    $cleanPath = ($cleanSlug === 'index') ? '/' : '/' . $cleanSlug;
    $query = !empty($parsed['query']) ? '?' . $parsed['query'] : '';
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $cleanPath . $query);
    exit;
}

// 2. Root Request -> index.php
if ($path === '/' || $path === '') {
    $_SERVER['SCRIPT_NAME']     = '/index.php';
    $_SERVER['PHP_SELF']        = '/index.php';
    $_SERVER['SCRIPT_FILENAME'] = $projectRoot . '/index.php';
    require $projectRoot . '/index.php';
    exit;
}

// 3. Extensionless routes (e.g. /about -> about.php, /services -> services.php, /contact -> contact.php)
$targetPhp = $projectRoot . '/' . $trimmed . '.php';
if (file_exists($targetPhp) && is_file($targetPhp)) {
    $_SERVER['SCRIPT_NAME']     = '/' . $trimmed . '.php';
    $_SERVER['PHP_SELF']        = '/' . $trimmed . '.php';
    $_SERVER['SCRIPT_FILENAME'] = $targetPhp;
    require $targetPhp;
    exit;
}

// 4. Subdirectory with index.php (e.g. /about/index.php)
$targetDirIndex = $projectRoot . '/' . $trimmed . '/index.php';
if (file_exists($targetDirIndex) && is_file($targetDirIndex)) {
    $_SERVER['SCRIPT_NAME']     = '/' . $trimmed . '/index.php';
    $_SERVER['PHP_SELF']        = '/' . $trimmed . '/index.php';
    $_SERVER['SCRIPT_FILENAME'] = $targetDirIndex;
    require $targetDirIndex;
    exit;
}

// 5. Route Not Found -> Custom 404 Page
http_response_code(404);
$_SERVER['SCRIPT_NAME']     = '/404.php';
$_SERVER['PHP_SELF']        = '/404.php';
$_SERVER['SCRIPT_FILENAME'] = $projectRoot . '/404.php';

if (file_exists($projectRoot . '/404.php')) {
    require $projectRoot . '/404.php';
} else {
    echo '<!DOCTYPE html><html><head><title>404 Not Found</title></head><body><h1>404 - Page Not Found</h1></body></html>';
}
exit;

