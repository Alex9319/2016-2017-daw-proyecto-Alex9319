<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Armario;
use AppBundle\Form\Type\ArmarioType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArmarioController extends Controller
{

    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route("/armarios", name="listadoArmarios")
     */
    public function indexAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Armario', 'a')
            ->orderBy( 'a.nombre','asc')
            ->getQuery();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*numero de pagina*/
        );
        return $this->render('armarios/listar.html.twig', array('pagination' => $pagination));
    }

    /**
     * @Security("is_granted('ROLE_DOCUMENTADOR')")
     * @Route("/armario/modificar/{id}", name="modificar_arm")
     * @Route("/armario/nuevo", name="nuevo_arm")
     */
    public function formularioAction(Request $request, Armario $armario = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $armario) {
            $armario = new Armario();
            $em->persist($armario);
        }

        $form = $this->createForm(ArmarioType::class, $armario);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('listadoArmarios');
            }catch (\Exception $e){
                    $this->addFlash('error', 'No se ha guardado el armario ya que existe un armario con el mismo nombre');
            }
        }

        return $this->render('armarios/form.html.twig', [
            'armario' => $armario,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Security("is_granted('ROLE_DOCUMENTADOR')")
     * @Route("/armario/listar/{id}", name="contenido_Armario")
     */
    public function articuloAction(Request $request, Armario $armario)
    {
        $rol = $this->getUser()->getNiveldeacceso();
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
            ->select('arc')
            ->addSelect('arm')
            ->from('AppBundle:Archivador', 'arc')
            ->leftJoin('arc.armario','arm')
            ->andWhere('arc.armario=:id')
            ->setParameter('id', $armario)
            ->orderBy('arc.numero','asc')
            ->getQuery();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*numero de pagina*/
        );

        return $this->render('armarios/listararcharm.html.twig', array('pagination' => $pagination,'armario'=>$armario));
    }

    /**
     * @Route("/armario/eliminar/{id}", name="borrar_armario", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function borrarAction(Armario $armario)
    {
        /** @var EntityManager $em */
        return $this->render('armarios/borrar.html.twig', [
            'armario' => $armario
        ]);
    }
    /**
     * @Route("/armario/eliminar/{id}", name="confirmar_borrar_armario", methods={"POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function borrarDeVerdadAction(Armario $armario)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        try {
            $em->remove($armario);
            $em->flush();
            $this->addFlash('estado', 'Armario eliminado con éxito');
        }
        catch(\Exception $e) {
            $this->addFlash('error', 'No se han podido eliminar ya que hay archivadores en este armario');
        }
        return $this->redirectToRoute('listadoArmarios');
    }
}
