<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Archivador;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArchivadorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero',null,[
                'label'=> 'Numero del Archivador',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca el número del Archivador'
                )
            ])
            ->add('color',null,[
                'label'=> 'Color del Archivador',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca el color de la etiqueta del Archivador'
                )
            ])
            ->add('armario',null,[
                'label'=> 'Armario',
                'required' => true,
                'placeholder' => 'Seleccione el Armario en el que se encuentra'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Archivador::class,
            'translation_domain' => false
        ]);
    }
}