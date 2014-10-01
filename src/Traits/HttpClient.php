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
     * @param string  $target
     * @param boolean $overwrite
     */
    public function downloadFile($url, $target, $overwrite = false)
    {
        if (file_exists($target) && !$overwrite) {
           return;
        }

        $this->prepareDirectory(dirname($target));

        $this->getHttpClient()
            ->get($url)
            ->setResponseBody($target)
            ->send()
        ;
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
