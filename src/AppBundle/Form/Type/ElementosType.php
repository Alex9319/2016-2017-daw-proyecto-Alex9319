<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Elementos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElementosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, [
                'label' => 'Nombre del Articulo',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca el nombre del Articulo'
                )
            ])
            ->add('observaciones', TextareaType::class, [
                'label' => 'Observaciones del Articulo',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca la descripcion del articulo'
                )
            ])
            ->add('nivelDeAcceso', null, [
                'label' => 'Nivel de acceso del Articulo',
                'required' => true,
                'attr'=>array(
                    'placeholder' =>'Introduzca el nivel de acceso'
                )
            ])
            ->add('fechaAlta', null, [
                'label' => 'Fecha de Alta',
                'widget' => 'single_text',
                'required' => true
            ])
            ->add('archivador', null, [
                'label' => 'Archivador donde se encuentra el Articulo',
                'attr'=>array(
                    'placeholder'=>'Seleccione el Archivador'
                )
            ])
            ->add('armario', null, [
                'label' => 'Armario donde se encuentra el Articulo',
                'attr'=>array(
                    'placeholder'=>'Selecciona el Armario'
                )
            ])
            ->add('categoria', null, [
                'label' => 'Categoria del Articulo',
                'required' => true,
                'attr'=>array(
                    'placeholder'=>'Seleccione la Categoria'
                )
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Elementos::class
        ]);
    }
}