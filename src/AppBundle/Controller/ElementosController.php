<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Elementos;
use AppBundle\Form\Type\ElementosType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ElementosController extends Controller
{

    /**
     * @Route("/articulos", name="listadoArticulos")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $elementos = $em->createQueryBuilder()
            ->select('e')
            ->from('AppBundle:Elementos', 'e')
            ->getQuery()
            ->getResult();

        return $this->render('elementos/listar.html.twig', [
            'elementos' => $elementos,
        ]);
    }

    /**
     * @Security("is_granted('ROLE_DOCUMENTADOR')")
     * @Route("/articulos/modificar/{id}", name="modificar_articulo")
     * @Route("/articulos/nuevo", name="nuevo_articulo")
     */
    public function formularioAction(Request $request, Elementos $elementos = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $elementos) {
            $elementos = new Elementos();
            $em->persist($elementos);
        }

        $form = $this->createForm(ElementosType::class, $elementos);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('estado', 'Cambios guardados con éxito');
            return $this->redirectToRoute('listadoArticulos',['elementos'=>$elementos->getId()]);
        }

        return $this->render('elementos/form.html.twig', [
            'elementos' => $elementos,
            'form' => $form->createView()
        ]);
    }
}