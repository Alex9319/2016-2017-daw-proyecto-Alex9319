<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Categoria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero', null, [
                'label' => 'Numero de la Categoria',
                'required' => true,
                'attr' => array(
                   'placeholder' => 'Introduzca el numero de la Categoria'
                )
            ])
            ->add('nombre', null, [
                'label' => 'Nombre de la Categoria',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca Nombre de la Categoria'
                )
            ])
            ->add('padre', null, [
                'label' => 'Categoria padre',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Seleccione la categoria superior'
                )
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categoria::class
        ]);
    }
}