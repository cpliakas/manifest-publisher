<?php

namespace Cpliakas\ManifestPublisher;

use Cpliakas\ManifestPublisher\Target\TargetInterface;

class Manifest
{
    use Traits\HttpClient;

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var Repository
     */
    protected $targetRepository;

    /**
     * @param Repository $repository
     */
    public function __construct(Repository $repository, Repository $targetRepository = null)
    {
        $this->repository = $repository;
        $this->targetRepository = $targetRepository ?: $repository;
    }

    /**
     * @param string $packageName
     * @param string $targetName
     *
     * @return Manifest
     */
    public static function factory($packageName, $targetName = null)
    {
        $repository = new Repository($packageName);
        $targetRepository = ($targetName) ? new Repository($targetName) : null;

        return new static($repository, $targetRepository);
    }

    /**
     * @return Repository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param  TargetInterface $target
     *
     * @return array
     *
     * @see http://moquet.net/blog/distributing-php-cli/
     */
    public function build(TargetInterface $target)
    {
        $manifest = [];

        $versions = $this->repository->getPackageVersions();
        foreach ($versions as $version) {

            $filepath = $target->downloadPhar($this->repository, $version);
            if (!$filepath) {
                continue;
            }

            $manifest[] = [
                'name'    => basename($filepath),
                'sha1'    => sha1_file($filepath),
                'url'     => $target->getPharUrl($this->repository, $version),
                'version' => $version,
            ];
        }

        return $manifest;
    }

    /**
     * Returns the manifest as JSON.
     *
     * @param TargetInterface $target
     */
    public function publish(TargetInterface $target)
    {
        $json = $this->jsonEncode($this->build($target));
        $target->publishManifest($this->targetRepository, $json);
    }

    /**
     * @param array $data
     *
     * @return string
     */
    public function jsonEncode(array $data)
    {
        $options = JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES;
        return json_encode($data, $options);
    }
}
