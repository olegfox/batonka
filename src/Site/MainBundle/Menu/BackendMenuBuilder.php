<?php

namespace Site\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class BackendMenuBuilder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->setCurrent($this->container->get('request')->getRequestUri());

        $menu->addChild('Меню', array('route' => 'backend_menu_index'));
        $menu->addChild('Статьи', array('route' => 'backend_page_index'));
        $menu->addChild('Слайдер', array('route' => 'backend_slider_index'));
        $menu->addChild('Фото', array('route' => 'backend_photo_index'));
        $menu->addChild('Регистрации', array('route' => 'backend_client_index'));

        return $menu;
    }

    public function userMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Выход', array('route' => 'fos_user_security_logout'));

        $menu->setCurrent($this->container->get('request')->getRequestUri());

        return $menu;
    }
}