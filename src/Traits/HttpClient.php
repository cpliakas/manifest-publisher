<?php

namespace Cpliakas\ManifestPublisher\Traits;

use Guzzle\Http\Client;
use Symfony\Component\Filesystem\Filesystem;

trait HttpClient
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @param  Client $client
     *
     * @return Repository
     */
    public function setHttpClient(Client $client)
    {
        $this->httpClient = $client;
        return $this;
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        if (!isset($this->httpClient)) {
            $this->httpClient = new Client();
        }
        return $this->httpClient;
    }

    /**
     * @param  string $url
     *
     * @return array
     */
    public function getJson($url)
    {
        return $this->getHttpClient()
            ->get($url)
            ->send()
            ->json()
        ;
    }

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
