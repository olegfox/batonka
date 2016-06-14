<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('SiteMainBundle:Page');

        $page = $repository->findOneBySlug('glavnaia');

        if (!$page)
        {
            throw $this->createNotFoundException($this->get('translator')->trans('Страница не найдена'));
        }

        $params = array(
            "page" => $page
        );

        return $this->render('SiteMainBundle:Frontend/Page:index.html.twig', $params);
    }
}
