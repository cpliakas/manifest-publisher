<?php

namespace Cpliakas\ManifestPublisher\Traits;

use Symfony\Component\Filesystem\Filesystem;

trait HttpClient
{
    /**
     * @param string  $url
     * @param string  $filename
     * @param boolean $overwrite
     */
    public function downloadFile($url, $filename, $overwrite = false)
    {
        if (file_exists($filename) && !$overwrite) {
           return;
        }

        $this->prepareDirectory(dirname($filename));

        if (!$filedata = @file_get_contents($url)) {
            throw new \RuntimeException(sprintf('Unable to download archive "%s"', $url));
        }

        file_put_contents($filename, $filedata);
    }

    /**
     * @param string $directory
     */
    public function prepareDirectory($directory)
    {
        $fs = new Filesystem();
        if (!$fs->exists($directory)) {
            $fs->mkdir($directory);
        }
    }
}
