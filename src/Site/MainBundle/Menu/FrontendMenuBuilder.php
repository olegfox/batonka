<?php

namespace Site\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class FrontendMenuBuilder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $request = $this->container->get('request');

        $routeName = $request->get('_route');

        $em = $this->container->get('doctrine.orm.entity_manager');

        $repository = $em->getRepository('SiteMainBundle:Menu');

        $menus = $repository->findBy(array('parent' => null), array('position' => 'asc'));

        $menu = $factory->createItem('root');

        $menu->setChildrenAttribute('class', 'nav nav-pills black');

        foreach ($menus as $key => $m) {
            if($m->getPage() && $m->getPage()->getSlug() != 'glavnaia') {
                $mm = $menu->addChild($m->getTitle(), array(
                    'route' => 'frontend_page_index',
                    'routeParameters' => array(
                        'slug' => $m->getPage()->getSlug()
                    )
                ));
            } else {
                $mm = $menu->addChild($m->getTitle(), array(
                    'route' => 'frontend_homepage'
                ));
            }
        }

        $menu->setCurrent($this->container->get('request')->getRequestUri());

        return $menu;
    }

    public function sidebarMenu(FactoryInterface $factory, array $options)
    {
        $request = $this->container->get('request');

        $routeName = $request->get('_route');

        $em = $this->container->get('doctrine.orm.entity_manager');

        $repository = $em->getRepository('SiteMainBundle:Menu');
        $repository_page = $em->getRepository('SiteMainBundle:Page');

        if ($routeName == 'frontend_subpage_index') {
            $slug = $request->get('parent');
        } else {
            $slug = $request->get('slug');
        }

        if (strlen($slug) > 0) {
            $page = $repository_page->findOneBy(array('slug' => $slug));
            $menus = $repository->findBy(array('parent' => $page->getMenu()[0]->getId()), array('position' => 'asc'));
        } else {
            $menus = array();
        }

        $menu = $factory->createItem('root');

        $menu->setChildrenAttribute('class', 'nav nav-pills black');

        foreach ($menus as $key => $m) {
            if($m->getPage() && $m->getPage()->getSlug() != 'glavnaia') {
                $mm = $menu->addChild($m->getTitle(), array(
                    'route' => 'frontend_subpage_index',
                    'routeParameters' => array(
                        'parent' => $m->getParent()->getPage()->getSlug(),
                        'slug' => $m->getPage()->getSlug()
                    )
                ));
            } else {
                $mm = $menu->addChild($m->getTitle(), array(
                    'route' => 'frontend_homepage'
                ));
            }
        }

        $menu->setCurrent($this->container->get('request')->getRequestUri());

        return $menu;
    }
}