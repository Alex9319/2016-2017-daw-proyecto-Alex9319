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
     * @Security("is_granted('ROLE_USER')")
     * @Route("/articulos", name="listadoArticulos")
     */
    public function indexAction(Request $request)
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
            ->setParameter('roles', $rol)
            ->orderBy( 'e.fechaAlta','desc')
            ->getQuery();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*numero de pagina*/
        );

        return $this->render('elementos/listar.html.twig', array('pagination' => $pagination));
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
            try{
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('listadoArticulos');
            }catch (\Exception $e){
                    $this->addFlash('error', 'No se ha guardado el articulo ya que existe un articulo con el mismo nombre');
            }
        }

        return $this->render('elementos/form.html.twig', [
            'elementos' => $elementos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/articulos/desactivar/{id}", name="desactivar_articulo", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function desactivarAction(Elementos $articulo)
    {
        /** @var EntityManager $em */
        return $this->render('elementos/borrar.html.twig', [
            'articulo' => $articulo
        ]);
    }
    /**
     * @Route("/articulos/desactivar/{id}", name="confirmar_desactivar_articulo", methods={"POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function desactivarDeVerdadAction(Elementos $articulo)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        try {
            $articulo->setFechaBaja(new \DateTime("now"));
            $em->flush();
            $this->addFlash('estado', 'Articulo desactivado con éxito');
        }
        catch(\Exception $e) {
            $this->addFlash('error', 'No se han podido desactivar');
        }
        return $this->redirectToRoute('listadoArticulos');
    }

    /**
     * @Route("/articulos/reactivar/{id}", name="reactivar_articulo", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function reactivarAction(Elementos $articulo)
    {
        /** @var EntityManager $em */
        return $this->render('elementos/reactivar.html.twig', [
            'articulo' => $articulo
        ]);
    }

    /**
     * @Route("/articulos/reactivar/{id}", name="confirmar_activar_articulo", methods={"POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function reactivarDeVerdadAction(Elementos $articulo)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        try {
            $articulo->setFechaBaja(null);
            $em->flush();
            $this->addFlash('estado', 'Articulo activado con éxito');
        }
        catch(\Exception $e) {
            $this->addFlash('error', 'No se han podido activar');
        }
        return $this->redirectToRoute('listadoArticulos');
    }
}
