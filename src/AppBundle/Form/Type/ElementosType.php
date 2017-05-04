<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Elementos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
            ->add('nivelDeAcceso', null, [
                'label' => 'Nivel de acceso del Articulo'
            ])
            ->add('fechaAlta', null, [
                'label' => 'Fecha de alta del Articulo'
            ])
            ->add('archivador', null, [
                'label' => 'Archivador donde se encuentra el Articulo'
            ])
            ->add('armario', null, [
                'label' => 'Armario donde se encuentra el Articulo'
            ])
            ->add('categoria', null, [
                'label' => 'Categoria del Articulo'
            ])
            ->add('multimedia', CollectionType::class,[
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