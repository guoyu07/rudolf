<?php

define('VER', 0.13);
define('VER_NAME', '0.13.0');
define('NAME', 'rudolf');

define('APP_ROOT', dirname(__DIR__));
define('MODULES_ROOT', APP_ROOT.'/src/module');
define('LOCALES_ROOT', APP_ROOT.'/src/locale');

define('CONFIG_ROOT', APP_ROOT.'/config');
define('TEMP_ROOT', APP_ROOT.'/temp');
define('LOG_ROOT', APP_ROOT.'/log');

define('CONTENT_ROOT', WEB_ROOT.'/content');
define('PLUGINS_ROOT', CONTENT_ROOT.'/plugins');
define('THEMES_ROOT', CONTENT_ROOT.'/themes');
define('UPLOADS_ROOT', CONTENT_ROOT.'/uploads');

if (dirname($_SERVER['SCRIPT_NAME']) === '/') {
    define('DIR', '');
} else {
    define('DIR', dirname($_SERVER['SCRIPT_NAME']));
}

define('CONTENT', DIR.'/content');
define('PLUGINS', CONTENT.'/plugins');
define('THEMES', CONTENT.'/themes');
define('UPLOADS', CONTENT.'/uploads');
