<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Archivador;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArchivadorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero',null,[
                'label'=> 'Numero del Archivador *',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca el número del Archivador',
                    'min' =>1,
                    'max' =>99999
                )
            ])
            ->add('color',null,[
                'label'=> 'Color del Archivador *',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca el color de la etiqueta del Archivador'
                )
            ])
            ->add('descripcion',TextareaType::class,[
                'label'=> 'Descripción del Archivador *',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca la descripción del Archivador'
                )
            ])
            ->add('armario',null,[
                'label'=> 'Armario *',
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