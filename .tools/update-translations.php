<?php

$languages = [
    'ar_SY' => 'ar', 'bg_BG' => 'bg', 'bs_BA' => 'bs', 'ca_ES' => 'ca', 'cs_CZ' => 'cs', 'da_DK' => 'da',
    'de_DE' => 'de', 'de_DE_du' => 'de', 'el_GR' => 'el', 'es_ES' => 'es', 'es_VE' => 'es', 'fa_IR' => 'fa',
    'fi_FI' => 'fi', 'fr_FR' => 'fr', 'hr_HR' => 'hr', 'hu_HU' => 'hu', 'id_ID' => 'id', 'it_IT' => 'it',
    'ja_JP' => 'ja', 'ko_KR' => 'ko', 'mk_MK' => 'mk', 'my_MY' => 'ms', 'nb_NO' => 'no', 'nl_NL' => 'nl',
    'pl_PL' => 'pl', 'pt_BR' => 'pt', 'pt_PT' => 'pt', 'ro_RO' => 'ro', 'ru_RU' => 'ru', 'sk_SK' => 'sk',
    'sr_Latn_RS' => 'sr', 'sv_SE' => 'sv', 'th_TH' => 'th', 'tr_TR' => 'tr', 'uk_UA' => 'uk', 'vi_VN' => 'vi',
    'zh_CN' => 'zh-cn', 'zh_TW' => 'zh-tw'
];

function translate(array $text_list, $target_lang) {
    if (empty($text_list)) return [];
    
    $batched_text = implode("\n\n", $text_list);
    $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=" . $target_lang . "&dt=t&q=" . urlencode($batched_text);
    
    $options = [
        'http' => [
            'header' => "User-Agent: Mozilla/5.0\r\n",
            'method' => 'GET'
        ]
    ];
    $context = stream_context_create($options);
    
    try {
        $response = @file_get_contents($url, false, $context);
        if ($response === false) {
            throw new Exception("HTTP request failed.");
        }
        $data = json_decode($response, true);
        
        $translated_str = '';
        if (isset($data[0]) && is_array($data[0])) {
            foreach ($data[0] as $item) {
                if (isset($item[0])) {
                    $translated_str .= $item[0];
                }
            }
        }
        
        $translated_list = explode("\n\n", $translated_str);
        $translated_list = array_map('trim', $translated_list);
        
        return $translated_list;
    } catch (Exception $e) {
        echo "Error translating to {$target_lang}: " . $e->getMessage() . "\n";
        return $text_list;
    }
}

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

$updated = 0;
$cache_file = __DIR__ . '/../.data/translations_cache.json';
$cache = file_exists($cache_file) ? json_decode(file_get_contents($cache_file), true) ?: [] : [];

foreach ($locales as $localeFile) {
    $lang = basename(dirname($localeFile));
    $translations = require $localeFile;
    
    $missing_keys = [];
    foreach ($keys as $key) {
        // Also re-translate keys that were previously just defaulted to English
        if (!array_key_exists($key, $translations) || $translations[$key] === $key) {
            $missing_keys[] = $key;
        }
    }
    
    if (empty($missing_keys)) {
        continue;
    }
    
    $google_lang = $languages[$lang] ?? null;
    if (!$google_lang) {
        echo "No Google Translate mapping for {$lang}, skipping automatic translation.\n";
        foreach ($missing_keys as $key) {
            $translations[$key] = $key;
            $updated++;
        }
    } else {
        $to_translate = [];
        $translated_strings = [];
        
        foreach ($missing_keys as $key) {
            if (isset($cache[$google_lang][$key])) {
                $translated_strings[] = $cache[$google_lang][$key];
            } else {
                $to_translate[] = $key;
                $translated_strings[] = null; // placeholder
            }
        }
        
        if (!empty($to_translate)) {
            echo "Translating " . count($to_translate) . " new strings for {$lang}...\n";
            $new_translations = translate($to_translate, $google_lang);
            
            if (count($new_translations) === count($to_translate)) {
                foreach ($to_translate as $index => $key) {
                    $cache[$google_lang][$key] = $new_translations[$index];
                }
                file_put_contents($cache_file, json_encode($cache, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            } else {
                echo "Mismatch in batch translate for {$lang}. Got " . count($new_translations) . " items instead of " . count($to_translate) . ". Falling back to English for new strings.\n";
                foreach ($to_translate as $index => $key) {
                    $new_translations[$index] = $key;
                }
            }
            
            $new_idx = 0;
            foreach ($translated_strings as &$val) {
                if ($val === null) {
                    $val = $new_translations[$new_idx++];
                }
            }
            unset($val);
            
            sleep(1);
        } else {
            // No new strings to translate, all were in cache
            // Do not sleep to speed up execution
        }
        
        foreach ($missing_keys as $i => $key) {
            $translations[$key] = $translated_strings[$i] ?: $key; // Fallback to key if empty
            $updated++;
        }
    }
    
    $export = var_export($translations, true);
    $export = preg_replace('/array \(/', '[', $export);
    $export = preg_replace('/\)$/', ']', $export);
    $content = "<?php\n\nreturn " . $export . ";\n";
    file_put_contents($localeFile, $content);
}

echo "Updated {$updated} translations across all locales.\n";
