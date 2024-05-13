<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 */

// Load Composer dependencies.
require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/src/StarterSite.php';

// Load scripts as modules.
add_filter('script_loader_tag', function (string $tag, string $handle, string $src) {
    if (in_array($handle, ['vite', 'main-js'])) {
     return '<script type="module" src="' . esc_url($src) . '" defer></script>';
    }
   
    return $tag;
}, 10, 3);


Timber\Timber::init();

// Sets the directories (inside your theme) to find .twig files.
Timber::$dirname = [ 'templates', 'views' ];

new StarterSite();
