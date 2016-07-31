<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Site\MainBundle\Entity\Client;
use Site\MainBundle\Form\ClientType;

class AuthController extends Controller
{
    public function registrationAction(Request $request)
    {
        $entity = new Client();
        $form   = $this->createCreateForm($entity);

        $form->add('submit', 'submit', array(
            'label' => 'регистрация',
            'attr' => array(
                'class' => 'btn btn-default btn-lg',
                'ng-disabled' => '!site_mainbundle_client.$valid'         
            )
        ));

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                if ($request->get('xhr'))
                {
                    return new Response('', 200);
                }
                else
                {
                    return $this->redirect($this->generateUrl('frontend_register_index'));
                }
            }

            die(var_dump($form->getErrors()));

        }

        return $this->render('SiteMainBundle:Frontend/Main:registration.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    private function createCreateForm(Client $entity)
    {
        $form = $this->createForm(new ClientType(), $entity, array(
            'action' => $this->generateUrl('frontend_register_index') . '?xhr=true',
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'backend.create'));

        return $form;
    }
}
