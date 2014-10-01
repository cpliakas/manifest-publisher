<?php

namespace Cpliakas\ManifestPublisher;

use GitWrapper\GitWrapper;

class Repository
{
    use Traits\Directories;

    /**
     * @var string
     */
    protected $packageName;

    /**
     * @var GitWrapper
     */
    protected $gitWrapper;

    /**
     * @var array
     */
    private $pharFilenames = array();

    /**
     * @param string          $packageName
     * @param GitWrapper|null $gitWrapper
     */
    public function __construct($packageName, GitWrapper $gitWrapper = null)
    {
        $this->packageName = $packageName;

        if (null === $gitWrapper) {
            $gitWrapper = new GitWrapper();
        }

        $this->gitWrapper = $gitWrapper;
    }

    /**
     * @return string
     */
    public function getPackageName()
    {
        return $this->packageName;
    }

    /**
     * @return GitWrapper
     */
    public function getGitWrapper()
    {
        return $this->gitWrapper;
    }

    /**
     * @param  string|null                $tag
     *
     * @return \GitWrapper\GitWorkingCopy
     */
    public function checkout($tag = null)
    {
        $git = $this->gitWrapper->workingCopy($this->getRepositoryDirectory($this));

        if (!$git->isCloned()) {
            $git->clone('git@github.com:' . $this . '.git');
        }

        if ($tag !== null) {
            $git->checkout($tag);
        }

        return $git;
    }

    /**
     * @return array
     */
    public function getPackageVersions()
    {
        $git = $this->checkout()
            ->fetchAll()
            ->clearOutput()
        ;

        $output = (string) $git->tag();
        $tags = preg_split("/\r\n|\n|\r/", rtrim($output));

        return array_reverse($tags);
    }

    /**
     * @param string $tag
     *
     * @return string|false
     */
    public function getPharFilename($tag)
    {
        if (!isset($this->pharFilenames[$tag])) {

            $git = $this->checkout($tag);
            $filename = $git->getDirectory() . '/box.json';

            if (!file_exists($filename)) {
                return false;
            }

            // @todo validation, but in dev I want to see the errors
            $filedata = file_get_contents($filename);
            $json     = json_decode($filedata, true);

            $this->pharFilenames[$tag] = basename($json['output']);
        }

        return $this->pharFilenames[$tag];
    }

    /**
     * Returns the package name.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->packageName;
    }
}
