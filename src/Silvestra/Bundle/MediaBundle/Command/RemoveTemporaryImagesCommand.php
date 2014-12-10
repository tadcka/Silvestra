<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\MediaBundle\Command;

use Silvestra\Component\Media\Image\ImageFilesystemManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/11/14 12:51 AM
 */
class RemoveTemporaryImagesCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('media:image:remove_temporary_images')
            ->setDescription('Remove temporary images.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getImageFilesystemManager()->removeTemporaryImages();

        $output->writeln('Finished!');
    }

    /**
     * @return ImageFilesystemManager
     */
    private function getImageFilesystemManager()
    {
        return $this->getContainer()->get('silvestra_media.image.manager.filesystem');
    }
}
