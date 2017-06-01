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
        if($rol==2000){
            $query = $em->createQueryBuilder()
                ->select('e')
                ->addSelect('m')
                ->from('AppBundle:Elementos', 'e')
                ->leftJoin('e.multimedia', 'm')
                ->where('e.NivelDeAcceso <= :roles')
                ->setParameter('roles', $rol)
                ->orderBy('e.fechaAlta', 'desc')
                ->getQuery();
        }else {
            $query = $em->createQueryBuilder()
                ->select('e')
                ->addSelect('m')
                ->from('AppBundle:Elementos', 'e')
                ->leftJoin('e.multimedia', 'm')
                ->where('e.NivelDeAcceso <= :roles')
                ->andWhere('e.fechaBaja is null')
                ->setParameter('roles', $rol)
                ->orderBy('e.fechaAlta', 'desc')
                ->getQuery();
        }

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
            if($rol===2000){
                $pagination = $em->createQueryBuilder()
                    ->select('e')
                    ->addSelect('m')
                    ->addSelect('arc')
                    ->addSelect('cat')
                    ->from('AppBundle:Elementos', 'e')
                    ->leftJoin('e.multimedia', 'm')
                    ->leftJoin('e.archivador', 'arc')
                    ->join('e.categoria', 'cat')
                    ->where('e.NivelDeAcceso <= :roles')
                    ->andWhere('e.nombre LIKE :nombre')
                    ->orWhere('e.observaciones LIKE :nombre')
                    ->setParameter('nombre', '%' . $request->get('busco') . '%')
                    ->setParameter('roles', $rol)
                    ->orderBy('e.fechaAlta', 'desc')
                    ->getQuery()
                    ->getResult();
            }else {
                $query = $em->createQueryBuilder()
                    ->select('e')
                    ->addSelect('m')
                    ->addSelect('arc')
                    ->addSelect('cat')
                    ->from('AppBundle:Elementos', 'e')
                    ->leftJoin('e.multimedia', 'm')
                    ->leftJoin('e.archivador', 'arc')
                    ->join('e.categoria', 'cat')
                    ->Where('e.nombre LIKE :nombre')
                    ->orWhere('e.observaciones LIKE :nombre')
                    ->andwhere('e.NivelDeAcceso <= :roles')
                    ->andWhere('e.fechaBaja is null')
                    ->setParameter('nombre', '%' . $request->get('busco') . '%')
                    ->setParameter('roles', $rol)
                    ->orderBy('e.fechaAlta', 'desc')
                    ->getQuery()
                    ->getResult();

                $paginator  = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                    $query, /* query NOT result */
                    $request->query->getInt('page', 1)/*page number*/,
                    12/*limit per page*/
                );
            }

            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $query1 = $em->createQueryBuilder()
                ->select('cat')
                ->from('AppBundle:Categoria', 'cat')
                ->Where('cat.nombre LIKE :nombre')
                ->setParameter('nombre', '%' . $request->get('busco') . '%')
                ->getQuery()
                ->getResult();

            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $query2 = $em->createQueryBuilder()
                ->select('arm')
                ->from('AppBundle:Armario', 'arm')
                ->Where('arm.nombre LIKE :nombre')
                ->setParameter('nombre', '%' . $request->get('busco') . '%')
                ->getQuery()
                ->getResult();

            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $query3 = $em->createQueryBuilder()
                ->select('arc')
                ->from('AppBundle:Archivador', 'arc')
                ->Where('arc.numero LIKE :nombre')
                ->orWhere('arc.color LIKE :nombre')
                ->setParameter('nombre', '%' . $request->get('busco') . '%')
                ->getQuery()
                ->getResult();

            return $this->render('aplicacion/buscar.html.twig', array('pagination' => $pagination, 'pagination1' => $query1, 'pagination2' => $query2, 'pagination3' => $query3, 'variable' => $request->get('busco')));
        }
    }
}
