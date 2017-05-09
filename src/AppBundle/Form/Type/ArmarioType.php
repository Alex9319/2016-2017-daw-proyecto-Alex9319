<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Armario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArmarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, [
                'label' => 'Nombre del Armario',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca el nombre del Armario'
                )
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Armario::class
        ]);
    }
}