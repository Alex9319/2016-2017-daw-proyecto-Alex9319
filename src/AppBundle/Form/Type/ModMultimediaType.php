<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Multimedia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModMultimediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',null,array(
                'label' => 'Nombre del articulo'
            ))
            ->add('observaciones',TextareaType::class,array(
                'label' => 'Descripción del articulo',
            ))
            ->add('nuevo_multimedia', FileType::class ,array(
                'label' => 'Fichero multimedia nuevo del articulo',
                'mapped' => false,
                'required'=>false
            ))
            ->add('elementos',null,[
                'label'=>'Id de elemento',
                'required' => true,
                'placeholder' => 'Seleccione el articulo al que pertenece'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Multimedia::class,
            'translation_domain' => false
        ]);
    }
}