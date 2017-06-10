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
use Symfony\Component\Validator\Constraints as Assert;


class UsuarioType extends AbstractType
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
            ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', [
                'label' => 'Enviar solo el perfil',
                'attr' => ['class' => 'btn btn-success'],
                'validation_groups' => ['Default']
            ]);

        if (!$options['es_admin']) {
            $builder
                ->add('antigua', PasswordType::class, [
                    'label' => 'Clave Antigua',
                    'mapped' => false,
                    'constraints' => [
                        new UserPassword([
                            'groups' => ['password']
                        ]),
                    ],
                    'attr' => array(
                        'placeholder' => 'Introduzca su Clave Antigua'
                    )
                 ]);
        }

        $builder
            ->add('nueva', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'required' => false,
                'first_options' => [
                    'label' => 'Clave Nueva',
                    'attr' => array(
                        'placeholder' => 'Introduzca su nueva Clave'
                    ),
                    'constraints' => [
                        new NotBlank([
                            'groups'=>['password']
                        ])
                    ]
                ],
                'second_options' => [
                    'label' => 'Repetir Clave Nueva',
                    'attr' => array(
                        'placeholder' => 'Repita su nueva Clave'
                    ),
                    'constraints' => [
                        new NotBlank([
                            'groups'=>['password']
                        ])
                    ]
                ],
                'constraints' => [
                    new Assert\Regex(array(
                            'pattern' =>"/^[A-Z a-z 0-9]{6}/",
                            'message'=>"La longitud mínima es de 6 carácteres"
                        )
                    )

                ]
            ])
            ->add('cambiarContrasenas', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', [
                'label' => 'Cambiar Contraseñas',
                'attr' => ['class' => 'btn btn-success'],
                'validation_groups' => ['Default', 'password']
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