<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categoria;
use AppBundle\Form\Type\CategoriaType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class CategoriaController extends Controller
{

    /**
     * @Security("is_granted('ROLE_DOCUMENTADOR')")
     * @Route("/categorias", name="listadoCategorias")
     */
    public function indexAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
            ->select('c')
            ->from('AppBundle:Categoria', 'c')
            ->getQuery()
            ->getResult();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*numero de pagina*/
        );

        return $this->render('categorias/listar.html.twig', array('pagination' => $pagination));
    }

    /**
     * @Security("is_granted('ROLE_DOCUMENTADOR')")
     * @Route("/categoria/modificar/{id}", name="modificar_cat")
     * @Route("/categoria/nueva", name="nueva_cat")
     */
    public function formularioAction(Request $request, Categoria $categoria = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $categoria) {
            $categoria = new Categoria();
            $em->persist($categoria);
        }

        $form = $this->createForm(CategoriaType::class, $categoria);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('estado', 'Cambios guardados con éxito');
            return $this->redirectToRoute('listadoCategorias',['categoria'=>$categoria->getId()]);
        }

        return $this->render('categorias/form.html.twig', [
            'categoria' => $categoria,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/categoria/eliminar/{id}", name="borrar_categoria", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function borrarAction(Categoria $categoria)
    {
        /** @var EntityManager $em */
        return $this->render('categorias/borrar.html.twig', [
        'categoria' => $categoria
        ]);
    }
    /**
     * @Route("/categoria/eliminar/{id}", name="confirmar_borrar_categoria", methods={"POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function borrarDeVerdadAction(Categoria $categoria)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        try {
            $em->remove($categoria);
            $em->flush();
            $this->addFlash('estado', 'Categoria eliminado con éxito');
        }
        catch(Exception $e) {
            $this->addFlash('error', 'No se han podido eliminar');
        }
        return $this->redirectToRoute('listadoCategorias');
    }
}
