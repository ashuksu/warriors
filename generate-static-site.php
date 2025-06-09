<?php
echo "--- Starting static site generation process ---\n";

// --- 1. Environment and Path Setup ---
$baseStaticDir = 'static';
$ghPagesSourceDir = $baseStaticDir . '/gh-pages'; // Path to static source files for GitHub Pages.
$publicOutputDir = $baseStaticDir . '/public';     // Output directory for the generated static site.

$appEntryPoint = __DIR__ . '/public/index.php'; // Main application entry point within the container.

if (!file_exists($appEntryPoint)) {
    die("Error: Application entry point not found at " . $appEntryPoint . ". Check your mount points.\n");
}

// 2. Set environment variables for production context during generation.
putenv('IS_DEV=false');
$_ENV['IS_DEV'] = 'false';
$_SERVER['IS_DEV'] = 'false';

// Load application configuration.
// Ensure all constants in config.php and its dependencies use if (!defined()) checks.
require_once __DIR__ . '/config/config.php';

// --- 3. Clean and Create Static Output Directories ---
if (is_dir($publicOutputDir)) {
    echo "Removing existing public static output directory: {$publicOutputDir}\n";
    exec("rm -rf " . escapeshellarg($publicOutputDir) . ' 2>&1', $output, $returnCode);
    if ($returnCode !== 0) {
        echo "Error removing directory. Output:\n" . implode("\n", $output) . "\n";
        die("Static site generation failed at directory cleanup step.\n");
    }
}
if (!mkdir($publicOutputDir, 0777, true)) {
    die("Error creating public static output directory: {$publicOutputDir}\n");
}
echo "Clean public static output directory created: {$publicOutputDir}\n";

// --- 4. Copy Contents from static/gh-pages/ ---
$sourceGhPages = __DIR__ . '/' . $ghPagesSourceDir;
$destPublic = __DIR__ . '/' . $publicOutputDir;

if (is_dir($sourceGhPages)) {
    echo "Copying contents from {$sourceGhPages} to {$destPublic}...\n";
    // Copy the *contents* of sourceGhPages into destPublic.
    $copyCommand = "cp -a " . escapeshellarg($sourceGhPages) . "/. " . escapeshellarg($destPublic) . "/";
    exec($copyCommand . ' 2>&1', $output, $returnCode);
    if ($returnCode !== 0) {
        echo "Error copying gh-pages content. Command: {$copyCommand}\nOutput:\n" . implode("\n", $output) . "\n";
        die("Static site generation failed at gh-pages copy step.\n");
    }
    echo "Contents from {$sourceGhPages} copied.\n";
} else {
    echo "Directory {$sourceGhPages} not found, skipping copy of gh-pages specific files.\n";
}

// --- 5. Copy Built Frontend Assets ---
$sourceDist = __DIR__ . '/public/dist';
$destDist = $publicOutputDir . '/dist';

echo "Copying frontend assets from {$sourceDist} to {$destDist}...\n";

// Debugging for Vite build output visibility.
if (!is_dir($sourceDist)) {
    echo "CRITICAL ERROR: {$sourceDist} does NOT exist in gh-pages container.\n";
    echo "This indicates Vite build output is missing or not visible.\n";
    die("Fatal: Vite output path missing.\n");
} else {
    echo "INFO: {$sourceDist} exists.\n";
    $viteContents = shell_exec("ls -la " . escapeshellarg($sourceDist) . " 2>&1");
    echo "Contents of {$sourceDist}:\n" . $viteContents . "\n";
    $isDirEmpty = (new FilesystemIterator($sourceDist))->valid() ? false : true;
    if ($isDirEmpty) {
        echo "WARNING: {$sourceDist} is EMPTY.\n";
    } else {
        echo "INFO: {$sourceDist} contains files.\n";
    }
}

if (!is_dir($destDist)) {
    if (!mkdir($destDist, 0777, true)) {
        die("Error creating destination directory for frontend assets: {$destDist}\n");
    }
    echo "Created destination directory for frontend assets: {$destDist}\n";
}

// Copy the *contents* of sourceDist into destDist.
$copyFrontendCommand = "cp -R " . escapeshellarg($sourceDist) . "/. " . escapeshellarg($destDist) . "/";
exec($copyFrontendCommand . ' 2>&1', $output, $returnCode);

if ($returnCode !== 0) {
    echo "Error copying frontend assets. Command: {$copyFrontendCommand}\nOutput:\n" . implode("\n", $output) . "\n";
    die("Static site generation failed at frontend asset copy step.\n");
}
echo "Frontend assets copied.\n";

// --- 6. Generate HTML Pages ---
if (!defined('PAGES') || !is_array(PAGES)) {
    die("Error: 'PAGES' constant is not defined or invalid. Cannot generate routes.\n");
}

$routesToGenerate = [];
foreach (PAGES as $key => $pageData) {
    if ($key === 'home') {
        $routesToGenerate['/'] = 'index.html';
    } else {
        $routesToGenerate['/' . $pageData['name']] = $pageData['name'] . '.html';
    }
}
if (isset(PAGES['error'])) {
    $routesToGenerate['/404'] = '404.html';
}

echo "Generating HTML pages...\n";

foreach ($routesToGenerate as $requestPath => $outputFileName) {
    echo "  Generating: " . $requestPath . " -> " . $outputFileName . "\n";

    $_SERVER['REQUEST_URI'] = $requestPath;
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    $_SERVER['PHP_SELF'] = $_SERVER['SCRIPT_NAME'];
    $_SERVER['QUERY_STRING'] = '';
    $_SERVER['HTTP_HOST'] = DOMAIN; // Ensure DOMAIN is defined in config.php.

    ob_start();
    $phpIncludeSuccess = true;
    try {
        require $appEntryPoint;
    } catch (Throwable $e) {
        $phpIncludeSuccess = false;
        echo "ERROR: PHP Fatal Error during page generation for {$requestPath}:\n";
        echo "Message: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . " on line " . $e->getLine() . "\n";
        echo "Trace: " . $e->getTraceAsString() . "\n";
        ob_clean(); // Clear buffer in case of error.
    }

    $content = ob_get_clean();

    if (!$phpIncludeSuccess) {
        echo "Skipping file_put_contents for {$outputFileName} due to previous PHP error.\n";
        continue; // Skip saving if there was an error.
    }

    if (empty(trim($content))) {
        echo "WARNING: Generated content for {$outputFileName} is EMPTY.\n";
    }

    $filePath = rtrim($publicOutputDir, '/') . '/' . $outputFileName;
    if (!file_put_contents($filePath, $content)) {
        echo "CRITICAL ERROR: Failed to write content to {$filePath}.\n";
        die("Fatal: File write failed.\n");
    }
}

echo "--- Static site generation complete! ---\n";
echo "Static files are now located in: " . $publicOutputDir . "\n";
?>