<?php
namespace Rudolf\Component\Images;

class Resizer
{
    /**
     * It resise images
     * 
     * @param int $width
     * @param int $height
     * @param string $url
     * 
     * @return 
     */
    public function init($width, $height, $url)
    {
        $url = ltrim($url, '/');

        $cacheDir = TEMP . '/imageresizer/';
        //$filename = $width . 'x' . $height . '_' . md5($url);

        if (!file_exists($cacheDir)) {
            mkdir($cacheDir, 0775);
        }

        $_GET['src'] = $url;
        $_GET['w'] = $width;
        $_GET['h'] = $height;

        define('FILE_CACHE_DIRECTORY', $cacheDir);
        define('ALLOW_EXTERNAL', true);
        define('ALLOW_ALL_EXTERNAL_SITES', true);
        define('PNG_IS_TRANSPARENT', true);
        define('DEBUG_ON', true);
        define ('DEBUG_LEVEL', 3);

        include LIB . '/timthumb.php';
    }
}
