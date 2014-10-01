<?php

namespace Cpliakas\ManifestPublisher\Console;

use Cpliakas\ManifestPublisher\Manifest;
use Cpliakas\ManifestPublisher\Target as Target;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PublishGitHubCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('publish:gh-pages')
            ->setDescription('Update and publish a manifest to GitHub Pages')
            ->addArgument(
               'package-name',
               InputArgument::REQUIRED,
               'The package name in vendor/project format'
            )
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manifest = Manifest::factory($input->getArgument('package-name'))
          ->publish(new Target\GitHub())
        ;
    }
}
