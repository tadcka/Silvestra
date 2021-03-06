<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Site\Model\Manager;

use Silvestra\Component\Site\Model\SiteInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
interface SiteManagerInterface
{
    /**
     * Find site.
     *
     * @return null|SiteInterface
     */
    public function find();

    /**
     * Create new Site object.
     *
     * @return SiteInterface
     */
    public function create();

    /**
     * Add Site object to persistent layer.
     *
     * @param SiteInterface $site
     * @param bool $save
     */
    public function add(SiteInterface $site, $save = false);

    /**
     * Remove Site object from persistent layer.
     *
     * @param SiteInterface $site
     * @param bool $save
     */
    public function remove(SiteInterface $site, $save = false);

    /**
     * Save persistent layer.
     */
    public function save();

    /**
     * Clear Site objects from persistent layer.
     */
    public function clear();

    /**
     * Get Site object class name.
     *
     * @return string
     */
    public function getClass();
}
