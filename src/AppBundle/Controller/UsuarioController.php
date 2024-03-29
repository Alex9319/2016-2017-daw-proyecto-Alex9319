<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\NewUsuarioType;
use AppBundle\Form\Type\UsuarioType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class UsuarioController extends Controller
{

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/usuarios/modificar/{id}", name="musuarios")
     */
    public function cambiarUsuarioAction(Request $request, Usuario $usuario) {
        return $this->cambiarPerfilAction($request, $usuario);
    }

    /**
     * @Route("/perfil", name="perfil")
     */
    public function cambiarPerfilAction(Request $request, Usuario $usuario = null) {
        if (null === $usuario) {
            $usuario = $this->getUser();
        }
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(UsuarioType::class, $usuario, [
            'es_admin' => $this->isGranted('ROLE_ADMIN')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $claveFormulario = $form->get('nueva')->get('first')->getData();

            if ($claveFormulario) {
                $clave = $this->get('security.password_encoder')
                    ->encodePassword($usuario, $claveFormulario);

                $usuario->setClave($clave);
            }
            try{
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                if($usuario->getNivelDeAcceso()==2000){
                    return $this->redirectToRoute('listadoUsuarios');
                }else {
                    return $this->redirectToRoute('perfil');
                }
            }catch (\Exception $e){
                $this->addFlash('error', 'Los cambios no se han podido actualizar el nombre de usuario ya existe');
            }
        }

        return $this->render('usuarios/form.html.twig', [
            'usuario'=>$usuario,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/usuarios", name="listadoUsuarios")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function usuariosAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
            ->select('u')
            ->from('AppBundle:Usuario', 'u')
            ->getQuery();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*numero de pagina*/
        );

        return $this->render('usuarios/listar.html.twig', array('pagination' => $pagination));
    }

    /**
     * @Route("/usuarios/nuevo", name="nusuario")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function formularioAction(Request $request, Usuario $usuario = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $nusuario = $this->getUser()->getNiveldeacceso();

        if (null == $usuario) {
            $usuario = new Usuario();
            $em->persist($usuario);
        }

        $form = $this->createForm(NewUsuarioType::class, $usuario, [
            'es_admin' => $nusuario ==2000
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $claveFormulario = $form->get('nueva')->get('first')->getData();

            if ($claveFormulario) {
                $clave = $this->get('security.password_encoder')
                    ->encodePassword($usuario, $claveFormulario);

                $usuario->setClave($clave);
            }
            try{
                $em->flush();
                $this->addFlash('estado', 'Usuario registrado con éxito');
                return $this->redirectToRoute('listadoUsuarios');
            }catch (\Exception $e){
                $this->addFlash('error', 'No se ha podido registrar al usuario el nombre de usuario ya existe');
            }
        }

        return $this->render('usuarios/form.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/usuarios/eliminar/{id}", name="borrar_usuario", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function borrarAction(Usuario $usuario)
    {
        /** @var EntityManager $em */
        return $this->render('usuarios/borrar.html.twig', [
            'usuario' => $usuario
        ]);
    }
    /**
     * @Route("/usuarios/eliminar/{id}", name="confirmar_borrar_usuario", methods={"POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function borrarDeVerdadAction(Usuario $usuario)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        try {
            $em->remove($usuario);
            $em->flush();
            $this->addFlash('estado', 'Usuario eliminado con éxito');
        }
        catch(\Exception $e) {
            $this->addFlash('error', 'No se han podido eliminar al Usuario');
        }
        return $this->redirectToRoute('listadoUsuarios');
    }
}