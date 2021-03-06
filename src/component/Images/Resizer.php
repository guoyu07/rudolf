<?php

namespace Rudolf\Component\Images;

use PHPixie\Image as ImageManipulator;
use Rudolf\Component\Http\HttpErrorException;
use Rudolf\Component\Http\Response;

class Resizer
{
    /**
     * @var string
     */
    private $cacheExtension;

    /**
     * @var string
     */
    private $cacheDirectory;

    /**
     * @var array
     */
    private $allowedTypes;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @var string
     */
    private $src;

    /**
     * Resizer constructor.
     * @throws \RuntimeException
     */
    public function __construct()
    {
        $this->cacheExtension = '.jpg';
        $this->cacheDirectory = TEMP_ROOT.'/imageresizer/';
        $this->allowedTypes = ['gif', 'png', 'jpeg'];

        if (!file_exists($this->cacheDirectory)
            && !mkdir($this->cacheDirectory, 0775)
            && !is_dir($this->cacheDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $this->cacheDirectory));
        }
    }

    /**
     * Run resizer as cache proxy.
     *
     * @param int    $width
     * @param int    $height
     * @param string $src Base64 encoded url
     *
     * @throws HttpErrorException
     * @throws \Exception
     */
    public function runAsProxy($width, $height, $src)
    {
        $this->width = $width;
        $this->height = $height;

        $src = trim($src, '/');

        if ('http://' === substr($src, 0, 7) || 'https://' === substr($src, 0, 8)) {
            $this->src = ltrim($src, '/');
        } else {
            $this->src = '/content/'.$src;
            $this->src = urldecode($this->src);
        }

        if (true === $this->tryServeCache()) {
            exit;
        }

        if (preg_match('/^https?:\/\/[^\/]+/i', $this->src)) {
            $this->serveExternal();
        } else {
            $this->serveInternal();
        }
    }

    /**
     * Try to serve image from cache.
     * @return bool
     * @throws \Exception
     */
    private function tryServeCache()
    {
        $file = $this->createCacheName();

        if (file_exists($file)) {
            $this->serveFromCache($file);

            return true;
        }

        return false;
    }

    /**
     * Server image from cache.
     *
     * @param string $file Full path to cache file
     *
     * @see http://dtbaker.net/web-development/how-to-cache-images-generated-by-php/
     * @return void
     * @throws \Exception
     */
    private function serveFromCache($file)
    {
        $response = new Response();
        $response->setHeader(['Cache-Control', 'private, max-age=10800, pre-check=10800']);
        $response->setHeader(['Pragma', 'private']);
        $response->setHeader(['Expires', date(DATE_RFC822, strtotime(' 2 day'))]);

        $modifiedDate = gmdate('D, d M Y H:i:s', filemtime($file));

        /** @var array $_SERVER */
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])
            && (strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == filemtime($file))
        ) {
            // send the last mod time of the file back
            $response->setHeader(['Last-Modified', $modifiedDate.' GMT']);
            $response->setStatusCode(304);
            $response->send();
            exit;
        }

        $response->setHeader(['Content-Type', $this->getImageType($file, $returnFull = true)]);
        $response->setHeader(['Last-Modified', $modifiedDate.' GMT']);
        $response->setContent(file_get_contents($file));
        echo $response->send();
        exit;
    }

    /**
     * Create cache file name based on src, width, height end extension.
     *
     * @param bool $onlyFilename
     *
     * @return string
     */
    private function createCacheName($onlyFilename = false)
    {
        $filename = sha1($this->src).'_'.$this->width.'x'.$this->height.$this->cacheExtension;

        if (true === $onlyFilename) {
            return $filename;
        }

        return $this->cacheDirectory.$filename;
    }

    /**
     * Serve image from external location.
     * @throws \Exception
     */
    private function serveExternal()
    {
        $cacheFile = $this->createCacheName();

        $manipulator = new ImageManipulator();
        $image = $manipulator->load(file_get_contents($this->src));
        $image->fill($this->width, $this->height);
        $image->save($cacheFile);

        $this->serveFromCache($cacheFile);
    }

    /**
     * Serve image from internal location.
     * @throws HttpErrorException
     * @throws \Exception
     */
    private function serveInternal()
    {
        $file = $this->getAbsoluteInternalPath();

        if (!file_exists($file)) {
            throw new HttpErrorException('Image not found (error 404)', 404);
        }

        $cacheFile = $this->createCacheName();

        $manipulator = new ImageManipulator();
        $image = $manipulator->read($file);
        $image->fill($this->width, $this->height);
        $image->save($cacheFile);

        $this->serveFromCache($cacheFile);
    }

    /**
     * Get image type by mimetype.
     *
     * @param string $file
     * @param bool   $returnFull
     *
     * @throws \Exception
     *
     * @return string
     */
    public function getImageType($file, $returnFull = false)
    {
        $type = explode('/', mime_content_type($file));

        if ('image' !== $type[0]) {
            throw new \Exception('File is not image!');
        }

        if (!in_array($type[1], $this->allowedTypes)) {
            throw new \Exception('Unacceptable image type!');
        }

        if (true === $returnFull) {
            return implode('/', $type);
        }

        return $type[1];
    }

    /**
     * Get absolute path to internal image.
     *
     * @return string
     */
    private function getAbsoluteInternalPath()
    {
        if (file_exists($this->src)) {
            return $this->src;
        }

        $file = WEB_ROOT.str_replace(DIR, '', $this->src);

        if (file_exists($file)) {
            return $file;
        }

        return $this->src;
    }
}
