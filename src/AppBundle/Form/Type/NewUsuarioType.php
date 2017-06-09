<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\NotBlank;


class NewUsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, [
                'label' => 'Nombre',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca el Nombre'
                )
            ])
            ->add('apellidos', null, [
                'label' => 'Apellidos',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca el Apellido'
                )
            ])
            ->add('usuario', null, [
                'label' => 'Nombre de Usuario',
                'disabled' => !$options['es_admin'],
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca su nombre de Usuario'
                )
            ])
            ->add('nivelDeAcceso', null, [
                'label' => 'Nivel de Acceso',
                'disabled' => !$options['es_admin'],
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca el Nivel de Acceso (2000 => Administrador, 1500 => Documentador, 1200 => Usuario)'
                )
            ])
            ->add('nueva', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'required' => false,
                'first_options' => [
                    'label' => 'Clave Nueva',
                    'attr' => array(
                        'placeholder' => 'Introduzca su nueva Clave',
                        'min' =>'6'
                    ),
                    'constraints' => [
                        new NotBlank([
                            'groups'=>['Default']
                        ])
                    ]
                ],
                'second_options' => [
                    'label' => 'Repetir Clave Nueva',
                    'attr' => array(
                        'placeholder' => 'Repita su nueva Clave',
                        'min' =>'6'
                    ),
                    'constraints' => [
                        new NotBlank([
                            'groups'=>['Default']
                        ])
                    ]
                ]
            ])
            ->add('Guardar Usuario', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', [
                'label' => 'Guardar Usuario',
                'attr' => ['class' => 'btn btn-success'],
                'validation_groups' => ['Default']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
            'es_admin' => false,
            'validation_groups'=>['Default'],
            'translation_domain' => false
        ]);
    }
}