<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Silvestra <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\AdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Translation\TranslatorInterface;
use Tadcka\Bundle\AdminBundle\Event\AdminMenuEvent;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 6/6/14 12:41 AM
 */
class Builder extends ContainerAware
{
    /**
     * @return TranslatorInterface
     */
    private function getTranslator()
    {
        return $this->container->get('translator');
    }

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttributes(array('id' => 'side-menu', 'class' => 'nav'));

        $home = $menu->addChild(
            $this->getTranslator()->trans('menu.home', array(), 'SilvestraAdminBundle'),
            array('route' => 'silvestra_admin_homepage')
        );
        $home->setLabelAttribute('menu_logo', 'fa-dashboard');

        $home = $menu->addChild(
            $this->getTranslator()->trans('menu.sitemap', array(), 'SilvestraAdminBundle'),
            array('route' => 'tadcka_sitemap')
        );
        $home->setLabelAttribute('menu_logo', 'fa-sitemap');

        return $menu;
    }
}