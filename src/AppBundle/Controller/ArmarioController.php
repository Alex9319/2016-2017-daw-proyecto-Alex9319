<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Armario;
use AppBundle\Form\Type\ArmarioType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArmarioController extends Controller
{

    /**
     * @Route("/armarios", name="listadoArmarios")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $armarios = $em->createQueryBuilder()
            ->select('c')
            ->from('AppBundle:Armario', 'c')
            ->getQuery()
            ->getResult();

        return $this->render('armarios/listar.html.twig', [
            'armarios' => $armarios,
        ]);
    }

    /**
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
            $em->flush();
            $this->addFlash('estado', 'Cambios guardados con éxito');
            return $this->redirectToRoute('listadoArmarios',['armario'=>$armario->getId()]);
        }

        return $this->render('armarios/form.html.twig', [
            'armario' => $armario,
            'form' => $form->createView()
        ]);
    }
}
