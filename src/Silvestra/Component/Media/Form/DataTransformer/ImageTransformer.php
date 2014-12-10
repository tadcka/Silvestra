<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Form\DataTransformer;

use Silvestra\Component\Media\Model\ImageInterface;
use Silvestra\Component\Media\Model\Manager\ImageManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 4:04 PM
 */
class ImageTransformer implements DataTransformerInterface
{
    /**
     * @var ImageManagerInterface
     */
    private $imageManager;

    /**
     * @var string
     */
    private $preFilename;

    /**
     * Constructor.
     *
     * @param ImageManagerInterface $imageManager
     */
    public function __construct(ImageManagerInterface $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    /**
     * @param string $preFilename
     */
    public function setPreFilename($preFilename)
    {
        $this->preFilename = $preFilename;
    }

    /**
     * Transform.
     *
     * @param ImageInterface $image
     *
     * @return ImageInterface
     */
    public function transform($image)
    {
        return $image;
    }

    /**
     * Reverse transform.
     *
     * @param ImageInterface $image
     *
     * @return ImageInterface
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($image)
    {
        if (null === $image) {
            return null;
        }

        $filename = $image->getFilename();

        if (empty($filename)) {
            return null;
        }

        if ($this->preFilename === $filename) {
            $image->setTemporary(false);
            $image->setUpdatedAt(new \DateTime());

            return $image;
        }

        $image->setFilename($this->preFilename);
        $image->setTemporary(true);

        $newImage = $this->imageManager->findByFilename($filename);

        if (null === $newImage) {
            throw new TransformationFailedException();
        }

        $newImage->setTemporary(false);
        $newImage->setUpdatedAt(new \DateTime());

        return $newImage;
    }
}
