<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Archivador;
use AppBundle\Form\Type\ArchivadorType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArchivadorController extends Controller
{

    /**
     * @Route("/archivador", name="listadoArchivadores")
     */
    public function indexAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Archivador', 'a')
            ->getQuery()
            ->getResult();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*numero de pagina*/
        );

        return $this->render('archivador/listar.html.twig', array('pagination' => $pagination));
    }

    /**
     * @Security("is_granted('ROLE_DOCUMENTADOR')")
     * @Route("/archivador/modificar/{id}", name="modificar_arch")
     * @Route("/archivador/nuevo", name="nuevo_arch")
     */
    public function formularioAction(Request $request, Archivador $archivadores = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $archivadores) {
            $archivadores = new Archivador();
            $em->persist($archivadores);
        }

        $form = $this->createForm(ArchivadorType::class, $archivadores);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('estado', 'Cambios guardados con éxito');
            return $this->redirectToRoute('listadoArchivadores',['archivadores'=>$archivadores->getId()]);
        }

        return $this->render('archivador/form.html.twig', [
            'archivadores' => $archivadores,
            'form' => $form->createView()
        ]);
    }
}
