<?php

namespace Cpliakas\ManifestPublisher\Target;

use Cpliakas\ManifestPublisher\Repository;

interface TargetInterface
{
    /**
     * Downloads the Phar, returns the filepath the Phar was downloaded to.
     *
     * @param  Repository $repository
     * @param  string     $version
     * @param  boolean    $overwrite
     *
     * @return string
     */
    public function downloadPhar(Repository $repository, $version, $overwrite = false);

    /**
     * Returns the URL to download the Phar.
     *
     * @param  Repository $repository
     * @param  string     $version
     *
     * @return string|false
     */
    public function getPharUrl(Repository $repository, $version);

    /**
     * @param string $json
     */
    public function publishManifest(Repository $repository, $json);
}
