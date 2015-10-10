<?php

namespace Cpliakas\ManifestPublisher\Target;

use Cpliakas\ManifestPublisher\Repository;
use Cpliakas\ManifestPublisher\Traits as Traits;

class GitHub implements TargetInterface
{
    use Traits\HttpClient;
    use Traits\Directories;

    /**
     * {@inheritDoc}
     */
    public function downloadPhar(Repository $repository, $version, $overwrite = false)
    {
        if (!$url = $this->getPharUrl($repository, $version)) {
            return false;
        }

        $directory = $this->getPharDirectory($repository, $version);
        $filepath  = $directory . '/' . basename($url);

        try {
            $this->downloadFile($url, $filepath, $overwrite);
        } catch (\RuntimeException $e) {
            return false;
        }
        return $filepath;
    }

    /**
     * {@inheritdoc}
     */
    public function getPharUrl(Repository $repository, $version)
    {
        if ($filename = $repository->getPharFilename($version)) {
            return 'https://github.com/' . $repository . '/releases/download/' . $version . '/' . $filename;
        } else {
            return false;
        }
    }

    /**
     * {@inheritDoc}
     *
     * Publishes the manifest to GitHub pages.
     */
    public function publishManifest(Repository $repository, $json)
    {
        $git = $this->checkoutGitHubPages($repository);

        file_put_contents($git->getDirectory() . '/manifest.json', $json);
        $git->add('manifest.json');

        if ($git->hasChanges()) {
            $git
                ->commit('Manifest published by the cpliakas/manifest-publisher tool')
                ->push()
            ;
        }
    }

    /**
     * @param Repository $repository
     *
     * @return \GitWrapper\GitWorkingCopy
     */
    public function checkoutGitHubPages(Repository $repository)
    {
        $isProjectPage = !preg_match('#\.github\.io$#', $repository->getPackageName());
        $branch = $isProjectPage ? 'gh-pages' : 'master';
        $directory = $this->getGitHubPagesDirectory($repository);
        $git = $repository->getGitWrapper()->workingCopy($directory);

        if (!$git->isCloned()) {
            $git->clone('git@github.com:' . $repository . '.git');
        }

        $git
            ->checkout($branch)
            ->pull()
        ;

        return $git;
    }

    /**
     * @param Repository $repository
     *
     * @return string
     */
    public function getGitHubPagesDirectory(Repository $repository)
    {
        return $this->getBaseDirectory() . '/gh-pages/' . $repository;
    }
}
