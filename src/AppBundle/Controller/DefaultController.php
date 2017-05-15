<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function inicioAction(Request $request)
    {
        if($this->getUser()){
            $rol=$this->getUser()->getNiveldeacceso();
        }else {
            $rol = 1200;
        }
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
            ->select('e')
            ->from('AppBundle:Elementos', 'e')
            ->leftJoin('AppBundle:Multimedia', 'm','WITH','e.id=m.elementos')
            ->where('e.NivelDeAcceso <= :roles')
            ->setParameter('roles', $rol)
            ->getQuery()
            ->getResult();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/
        );

        return $this->render('layout.html.twig', array('pagination' => $pagination));
    }
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');

        // replace this example code with whatever you need
        return $this->render('aplicacion/login.html.twig', [
            'error' => $helper->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/comprobar", name="comprobar")
     * @Route("/salir", name="salir")
     */
    public function comprobarAction() {
    }

    /**
     * @Route("/contacto", name="contacto")
     */
    public function contactoAction(Request $request)
    {
        if('POST' === $request->getMethod()) {
            $nombre=$request->get('nombre');
            $apellidos=$request->get('apellidos');
            $email=$request->get('email');
            $asunto=$request->get('asunto');
            $contenido=$request->get('contenido');
            $message = \Swift_Message::newInstance()
                ->setSubject('Mensaje enviado desde la Aplicación web del Museo Andres Segovia')
                ->setFrom($this->getParameter('mailer_user'))
                ->setTo($this->getParameter('mailer_user'))
                ->setBody($this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'aplicacion/mensaje.html.twig',
                        array('nombre' => $nombre,'apellidos'=> $apellidos,'email'=>$email,'contenido'=>$contenido,'asunto'=>$asunto)
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);

            $this->addFlash('estado', 'Email mandado con exito');
        }

        return $this->render('aplicacion/contacto.html.twig');
    }

    /**
     * @Route("/buscar", name="buscar")
     */
    public function buscarAction(Request $request)
    {
        if ('' === $request->get('busco')) {
            return $this->inicioAction($request);
        } else {
            if($this->getUser()){
                $rol=$this->getUser()->getNiveldeacceso();
            }else {
                $rol = 1200;
            }
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQueryBuilder()
                ->select('e')
                ->from('AppBundle:Elementos', 'e')
                ->leftJoin('AppBundle:Multimedia', 'm', 'WITH', 'e.id=m.elementos')
                ->where('e.NivelDeAcceso <= :roles')
                ->andWhere('e.nombre LIKE :nombre')
                ->orWhere('e.observaciones LIKE :nombre')
                ->setParameter('nombre', '%' . $request->get('busco') . '%')
                ->setParameter('roles', $rol)
                ->getQuery()
                ->getResult();

            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/
            );

            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $query1 = $em->createQueryBuilder()
                ->select('c')
                ->from('AppBundle:Categoria', 'c')
                ->Where('c.nombre LIKE :nombre')
                ->setParameter('nombre', '%' . $request->get('busco') . '%')
                ->getQuery()
                ->getResult();

            $paginator1 = $this->get('knp_paginator');
            $pagination1 = $paginator1->paginate(
                $query1, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/
            );

            return $this->render('aplicacion/buscar.html.twig', array('pagination' => $pagination, 'pagination1' => $pagination1, 'variable' => $request->get('busco')));
        }
    }
}
