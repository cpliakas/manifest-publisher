<?php

namespace Cpliakas\ManifestPublisher\Traits;

use Cpliakas\ManifestPublisher\Repository;

trait Directories
{
    /**
     * @return string
     */
    public function getBaseDirectory()
    {
        return $_SERVER['HOME'] . '/.ManifestPublisher';
    }

    /**
     * @param Repository $repository
     *
     * @return string
     */
    public function getRepositoryDirectory(Repository $repository)
    {
        return $this->getBaseDirectory() . '/repos/' . $repository;
    }

    /**
     * @param Repository $repository
     * @param string     $version
     *
     * @return string
     */
    public function getPharDirectory(Repository $repository, $version)
    {
        return $this->getBaseDirectory() . '/phars/' . $repository . '/' . $version;
    }
}
