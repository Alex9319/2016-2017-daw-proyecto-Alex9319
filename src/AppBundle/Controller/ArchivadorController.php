<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Archivador;
use AppBundle\Entity\Armario;
use AppBundle\Form\Type\ArchivadorType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArchivadorController extends Controller
{

    /**
     * @Route("/archivador", name="listadoArchivadores")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $archivadores = $em->createQueryBuilder()
            ->select('c')
            ->from('AppBundle:Archivador', 'c')
            ->getQuery()
            ->getResult();

        return $this->render('archivador/listar.html.twig', [
            'archivadores' => $archivadores,
        ]);
    }

    /**
     * @Route("/archivador/modificar/{id}", name="modificar_arch")
     * @Route("/archivador/nuevo", name="nuevo_arch")
     */
    public function formularioAction(Request $request, Archivador $archivadores = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $archivadores) {
            $archivadores = new Armario();
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
