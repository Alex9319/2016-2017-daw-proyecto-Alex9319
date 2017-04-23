<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categoria;
use AppBundle\Form\Type\CategoriaType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoriaController extends Controller
{

    /**
     * @Route("/categorias", name="listadoCategorias")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $categorias = $em->createQueryBuilder()
            ->select('c')
            ->from('AppBundle:Categoria', 'c')
            ->getQuery()
            ->getResult();

        return $this->render('categorias/listar.html.twig', [
            'categorias' => $categorias,
        ]);
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
}
