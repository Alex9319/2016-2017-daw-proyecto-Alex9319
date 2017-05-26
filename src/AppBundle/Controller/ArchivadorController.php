<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Archivador;
use AppBundle\Form\Type\ArchivadorType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class ArchivadorController extends Controller
{

    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route("/archivador", name="listadoArchivadores")
     */
    public function indexAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
            ->select('a')
            ->addSelect('ar')
            ->from('AppBundle:Archivador', 'a')
            ->join('a.armario','ar')
            ->orderBy( 'a.numero','asc')
            ->getQuery();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*numero de pagina*/
        );

        return $this->render('archivador/listar.html.twig', array('pagination' => $pagination));
    }
    /**
     * @Security("is_granted('ROLE_DOCUMENTADOR')")
     * @Route("/archivador/listar/{id}", name="contenido_Archivador")
     */
    public function articuloAction(Request $request, Archivador $archivador)
    {
        $rol = $this->getUser()->getNiveldeacceso();
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
            ->select('e')
            ->addSelect('m')
            ->addSelect('arm')
            ->addSelect('arc')
            ->addSelect('cat')
            ->from('AppBundle:Elementos', 'e')
            ->leftJoin('e.multimedia','m')
            ->leftJoin('e.armario','arm')
            ->leftJoin('e.archivador','arc')
            ->join('e.categoria','cat')
            ->where('e.NivelDeAcceso <= :roles')
            ->andWhere('e.archivador = :id')
            ->setParameter('roles', $rol)
            ->setParameter('id', $archivador)
            ->getQuery();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*numero de pagina*/
        );

        return $this->render('archivador/listarartarch.html.twig', array('pagination' => $pagination,'archivador'=>$archivador));
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
            try {
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('listadoArchivadores');
            } catch (\Exception $e) {
                $error = $e->getCode();
                if (0 == $error) {
                    $this->addFlash('error', 'No se ha guardado el archivador ya que existe un archivador con el mismo nombre');
                }
            }
        }

        return $this->render('archivador/form.html.twig', [
            'archivadores' => $archivadores,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/archivador/eliminar/{id}", name="borrar_archivador", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function borrarAction(Archivador $archivador)
    {
        /** @var EntityManager $em */
        return $this->render('archivador/borrar.html.twig', [
            'archivador' => $archivador
        ]);
    }
    /**
     * @Route("/archivador/eliminar/{id}", name="confirmar_borrar_archivador", methods={"POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function borrarDeVerdadAction(Archivador $archivador)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        try {
            $em->remove($archivador);
            $em->flush();
            $this->addFlash('estado', 'Archivador eliminado con éxito');
        }
        catch(\Exception $e) {
            $this->addFlash('error', 'No se han podido eliminar ya que algun articulo tiene asignado este archivador');
        }
        return $this->redirectToRoute('listadoArchivadores');
    }
}
