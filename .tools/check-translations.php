<?php

$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/..'));
$strings = [];

foreach ($dir as $file) {
    if ($file->isFile() && $file->getExtension() === 'php' && strpos($file->getPathname(), '/vendor/') === false) {
        $content = file_get_contents($file->getPathname());
        if (preg_match_all("/(?:t|e)\(\s*'([^']+)'\s*,\s*'kanext'\s*\)/u", $content, $matches)) {
            foreach ($matches[1] as $match) {
                $strings[$match] = true;
            }
        }
    }
}

$keys = array_keys($strings);
$locales = glob(__DIR__ . '/../Locale/*/translations.php');

$errors = 0;

foreach ($locales as $localeFile) {
    $lang = basename(dirname($localeFile));
    $translations = require $localeFile;
    
    foreach ($keys as $key) {
        if (!array_key_exists($key, $translations)) {
            echo "Missing translation for '{$key}' in {$lang}\n";
            $errors++;
        }
    }
}

if ($errors > 0) {
    echo "Found {$errors} missing translations.\n";
    exit(1);
}

echo "All translations are present.\n";
exit(0);
