<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('SiteMainBundle:Page');
        $repository_slider = $this->getDoctrine()->getRepository('SiteMainBundle:Slider');

        $page = $repository->findOneBySlug('glavnaia');
        $sliders = $repository_slider->findBy(array('main' => true), array('position' => 'asc'));

        if (!$page)
        {
            throw $this->createNotFoundException($this->get('translator')->trans('Страница не найдена'));
        }

        $params = array(
            "page" => $page,
            "sliders" => $sliders
        );

        return $this->render('SiteMainBundle:Frontend/Main:index.html.twig', $params);
    }
}
