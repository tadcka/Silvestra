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

use Silvestra\Component\Media\Filesystem;
use Silvestra\Component\Media\Model\ImageInterface;
use Silvestra\Component\Media\Model\Manager\ImageManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/24/14 11:47 PM
 */
class ImageUploader
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var ImageGenerator
     */
    private $imageGenerator;

    /**
     * @var ImageManagerInterface
     */
    private $imageManager;

    /**
     * Constructor.
     *
     * @param Filesystem $filesystem
     * @param ImageGenerator $imageGenerator
     * @param ImageManagerInterface $imageManager
     */
    public function __construct(
        Filesystem $filesystem,
        ImageGenerator $imageGenerator,
        ImageManagerInterface $imageManager
    ) {
        $this->filesystem = $filesystem;
        $this->imageGenerator = $imageGenerator;
        $this->imageManager = $imageManager;
    }

    /**
     * Create image.
     *
     * @param UploadedFile $uploadedImage
     *
     * @return ImageInterface
     */
    public function createImage(UploadedFile $uploadedImage)
    {
        $image = $this->imageManager->create();
        $filename = $this->getUniqueFilename($uploadedImage);

        $image->setFilename($filename);
        $image->setMimeType($uploadedImage->getClientMimeType());
        $image->setOrderNr(1);
        $image->setOriginalPath($this->filesystem->getRelativeFilePath($filename));
        $image->setPath($image->getOriginalPath());
        $image->setSize($uploadedImage->getClientSize());
        $image->setTemporary(true);

        $this->imageManager->add($image);

        $fileDir = $this->filesystem->getActualFileDir($filename);

        $uploadedImage->move($fileDir, $image->getFilename());

        return $image;
    }

    /**
     * Get unique filename.
     *
     * @param UploadedFile $uploadedImage
     *
     * @return string
     */
    private function getUniqueFilename(UploadedFile $uploadedImage)
    {
        return $this->imageGenerator->generateUniqueFilename($uploadedImage->getClientOriginalName());
    }
}
