<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Image;

use Psr\Log\LoggerInterface;
use Silvestra\Component\Media\Exception\IOException;
use Silvestra\Component\Media\Filesystem;
use Silvestra\Component\Media\Model\Manager\ImageManagerInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/11/14 12:11 AM
 */
class ImageFilesystemManager
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var ImageManagerInterface
     */
    private $imageManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string
     */
    private $removeUpToHours = 1;

    /**
     * Constructor.
     *
     * @param Filesystem $filesystem
     * @param ImageManagerInterface $imageManager
     * @param LoggerInterface $logger
     */
    public function __construct(Filesystem $filesystem, ImageManagerInterface $imageManager, LoggerInterface $logger)
    {
        $this->filesystem = $filesystem;
        $this->imageManager = $imageManager;
        $this->logger = $logger;
    }

    /**
     * Set remove up to hours.
     *
     * @param string $removeUpToHours
     */
    public function setRemoveUpToHours($removeUpToHours)
    {
        $this->removeUpToHours = $removeUpToHours;
    }

    public function removeImagesCache()
    {

    }

    /**
     * Remove temporary images.
     */
    public function removeTemporaryImages()
    {
        $images = $this->imageManager->findTemporaryImages(new \DateTime(sprintf('-%s hours', $this->removeUpToHours)));

        foreach ($images as $image) {
            $absolutePath = $this->filesystem->getRootDir() . $image->getPath();
            if (file_exists($absolutePath)) {
                $this->removeImageFile($absolutePath);
                $this->logger->info(sprintf('Removed temporary image: %s', $absolutePath));
            }

            $absoluteOriginalPath = $this->filesystem->getRootDir() . $image->getOriginalPath();
            if (file_exists($absoluteOriginalPath)) {
                $this->removeImageFile($absoluteOriginalPath);
                $this->logger->info(sprintf('Removed temporary image: %s', $absoluteOriginalPath));
            }

            $this->imageManager->remove($image);
        }

        $this->imageManager->save();
    }

    /**
     * Remove image file.
     *
     * @param string $absolutePath
     *
     * @throws IOException
     */
    private function removeImageFile($absolutePath)
    {
        if (true !== @unlink($absolutePath)) {
            throw new IOException(sprintf('Failed to remove image "%s".', $absolutePath), 0, null, $absolutePath);
        }
    }
}
