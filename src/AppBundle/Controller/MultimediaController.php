<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Multimedia;
use AppBundle\Form\Type\ModMultimediaType;
use AppBundle\Form\Type\MultimediaType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class MultimediaController extends Controller
{

    /**
     * @Security("is_granted('ROLE_DOCUMENTADOR')")
     * @Route("/multimedia", name="listadoMultimedia")
     */
    public function indexAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $multimedia = $em->createQueryBuilder()
            ->select('m')
            ->from('AppBundle:Multimedia', 'm')
            ->getQuery()
            ->getResult();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $multimedia, /* query NOT result */
            $request->query->getInt('page', 1)/*numero de pagina*/
        );

        return $this->render('multimedia/listar.html.twig', array('pagination' => $pagination));
    }

    /**
     * @Security("is_granted('ROLE_DOCUMENTADOR')")
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
            // Recogemos el fichero
            $file=$form['multimedia']->getData();
             
            // Sacamos la extensión del fichero
            $ext=$file->getMimeType();
             
            // Le ponemos un nombre al fichero
            $file_name=$file->getClientOriginalName();

            if(substr($ext, 0,6 )=='image/'){
                // Guardamos el fichero en el directorio uploads que estará en el directorio /web/uploads del framework
                $file->move("uploads/image", $file_name);
                // Establecemos el nombre de fichero en el atributo de la entidad
                $multimedia->setNombre($file->getClientOriginalName())->setType($ext)->setMultimedia('uploads/image/'.$multimedia->getNombre());
            }
            elseif (substr($ext, 0,6 )=='video/'){
                // Guardamos el fichero en el directorio uploads que estará en el directorio /web/uploads del framework
                $file->move("uploads/video", $file_name);
                // Establecemos el nombre de fichero en el atributo de la entidad
                $multimedia->setNombre($file->getClientOriginalName())->setType($ext)->setMultimedia('uploads/video/'.$multimedia->getNombre());
            }
            elseif (substr($ext, 0,6 )=='audio/'){
                // Guardamos el fichero en el directorio uploads que estará en el directorio /web/uploads del framework
                $file->move("uploads/audio", $file_name);
                // Establecemos el nombre de fichero en el atributo de la entidad
                $multimedia->setNombre($file->getClientOriginalName())->setType($ext)->setMultimedia('uploads/audio/'.$multimedia->getNombre());
            }

            $em->persist($multimedia);

            $em->flush();

            $this->addFlash('estado', 'Cambios guardados con éxito');
            return $this->redirectToRoute('listadoMultimedia',['multimedia'=>$multimedia->getId()]);
        }

        return $this->render('multimedia/form.html.twig', [
            'multimedia' => $multimedia,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Security("is_granted('ROLE_DOCUMENTADOR')")
     * @Route("/multimedia/modificar/{id}", name="modificar_multimedia")
     */
    public function modificarAction(Request $request, Multimedia $multimedia )
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ModMultimediaType::class, $multimedia);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form['nuevo_multimedia']->getData()) {
                // Recogemos el fichero
                $file = $form['nuevo_multimedia']->getData();

                // Sacamos la extensión del fichero
                $ext = $file->getMimeType();

                // Le ponemos un nombre al fichero
                $file_name = $file->getClientOriginalName();

                //Borramos el fichero antiguo
                $img=$multimedia->getMultimedia();

                if(substr($ext, 0,6 )=='image/'){
                    // Guardamos el fichero en el directorio uploads que estará en el directorio /web/uploads del framework
                    $file->move("uploads/image", $file_name);
                    // Establecemos el nombre de fichero en el atributo de la entidad
                    $multimedia->setNombre($file->getClientOriginalName())->setType($ext)->setMultimedia('uploads/image/'.$multimedia->getNombre());
                    unlink($img);
                }
                elseif (substr($ext, 0,6 )=='video/'){
                    // Guardamos el fichero en el directorio uploads que estará en el directorio /web/uploads del framework
                    $file->move("uploads/video", $file_name);
                    // Establecemos el nombre de fichero en el atributo de la entidad
                    $multimedia->setNombre($file->getClientOriginalName())->setType($ext)->setMultimedia('uploads/video/'.$multimedia->getNombre());
                    unlink($img);
                }
                elseif (substr($ext, 0,6 )=='audio/'){
                    // Guardamos el fichero en el directorio uploads que estará en el directorio /web/uploads del framework
                    $file->move("uploads/audio", $file_name);
                    // Establecemos el nombre de fichero en el atributo de la entidad
                    $multimedia->setNombre($file->getClientOriginalName())->setType($ext)->setMultimedia('uploads/audio/'.$multimedia->getNombre());
                    unlink($img);
                }
            }
            $em->persist($multimedia);

            $em->flush();
            $this->addFlash('estado', 'Cambios guardados con éxito');

            return $this->redirectToRoute('listadoMultimedia',['multimedia'=>$multimedia->getId()]);
        }

        return $this->render('multimedia/modificar.html.twig', [
            'multimedia' => $multimedia,
            'form' => $form->createView(),
            'archivo'=>'/'.$multimedia->getMultimedia(),
            'contenido'=>$multimedia->getNombre(),
            'tipo'=>$multimedia->getType()
        ]);
    }
    /**
     * @Route("/multimedia/eliminar/{id}", name="borrar_multimedia", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function borrarAction(Multimedia $multimedia)
    {
        /** @var EntityManager $em */
        return $this->render('multimedia/borrar.html.twig', [
            'multimedia' => $multimedia
        ]);
    }
    /**
     * @Route("/multimedia/eliminar/{id}", name="confirmar_borrar_multimedia", methods={"POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function borrarDeVerdadAction(Multimedia $multimedia)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        try {
            unlink($multimedia->getMultimedia());
            $em->remove($multimedia);
            $em->flush();
            $this->addFlash('estado', 'Archivo multimedia eliminado con éxito');
        }
        catch(Exception $e) {
            $this->addFlash('error', 'No se han podido eliminar');
        }
        return $this->redirectToRoute('listadoMultimedia');
    }
}
