<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Elementos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElementosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, [
                'label' => 'Nombre del Articulo'
            ])
            ->add('observaciones', null, [
                'label' => 'Observaciones del Articulo'
            ])
            ->add('nivel_de_acceso', null, [
                'label' => 'Nivel de acceso del Articulo'
            ])
            ->add('fecha_alta', null, [
                'label' => 'Fecha de alta del Articulo'
            ])
            ->add('fecha_baja', null, [
                'label' => 'Fecha de Baja del Articulo'
            ])
            ->add('archivador', null, [
                'label' => 'Archivador donde se encuentra el Articulo'
            ])
            ->add('categoria', null, [
                'label' => 'Categoria del Articulo'
            ])
            ->add('multimedia', null, [
                'label' => 'Multimedia del Articulo'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Elementos::class
        ]);
    }
}