<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Multimedia;
use AppBundle\Form\Type\MultimediaType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MultimediaController extends Controller
{

    /**
     * @Route("/multimedia", name="listadoMultimedia")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $multimedia = $em->createQueryBuilder()
            ->select('m')
            ->from('AppBundle:Multimedia', 'm')
            ->getQuery()
            ->getResult();

        return $this->render('multimedia/listar.html.twig', [
            'multimedia' => $multimedia,
        ]);
    }

    /**
     * @Security("is_granted('ROLE_DOCUMENTADOR')")
     * @Route("/multimedia/modificar/{id}", name="modificar_multimedia")
     * @Route("/multimedia/nuevo", name="nuevo_multimedia")
     */
    public function formularioAction(Request $request, Multimedia $multimedia = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $multimedia) {
            $multimedia = new Multimedia();
            $em->persist($multimedia);
        }

        $form = $this->createForm(MultimediaType::class, $multimedia);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            // Recogemos el fichero
            $file=$form['multimedia']->getData();
             
            // Sacamos la extensión del fichero
            $ext=$file->getMimeType();
             
            // Le ponemos un nombre al fichero
            $file_name=$file->getClientOriginalName();
             
            // Guardamos el fichero en el directorio uploads que estará en el directorio /web/uploads del framework
            $file->move("uploads", $file_name);

             
            // Establecemos el nombre de fichero en el atributo de la entidad
            $multimedia->setNombre($file->getClientOriginalName())->setType($ext);

            $em->flush();

            $em->persist($multimedia);

            $this->addFlash('estado', 'Cambios guardados con éxito');
            return $this->redirectToRoute('listadoMultimedia',['multimedia'=>$multimedia->getId()]);
        }

        return $this->render('multimedia/form.html.twig', [
            'multimedia' => $multimedia,
            'form' => $form->createView()
        ]);
    }
}
