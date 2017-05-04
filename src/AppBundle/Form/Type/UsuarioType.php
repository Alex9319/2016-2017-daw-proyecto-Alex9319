<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;


class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, [
                'label' => 'Nombre'
            ])
            ->add('apellidos', null, [
                'label' => 'Apellidos'
            ])
            ->add('usuario', null, [
                'label' => 'Nombre de Usuario',
                'disabled' => !$options['es_admin']
            ])
            ->add('nivelDeAcceso', null, [
                'label' => 'Nivel de Acceso',
                'disabled' => !$options['es_admin']
            ])
            ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', [
                'label' => 'Enviar Perfil Completo',
                'attr' => ['class' => 'btn btn-success']
            ]);

        if (!$options['es_admin']) {
            $builder
                ->add('antigua', PasswordType::class, [
                    'label' => 'Clave Antigua',
                    'mapped' => false,
                    'constraints' => [
                        new UserPassword([
                            'groups' => ['password']
                        ])
                    ]
                 ]);
        }

        $builder
            ->add('nueva', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Clave Nueva'
                ],
                'second_options' => [
                    'label' => 'Repetir Clave Nueva'
                ]
            ])
            ->add('cambiarContraseñas', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', [
                'label' => 'Cambiar Contraseñas',
                'attr' => ['class' => 'btn btn-success'],
                'validation_groups' => ['Default', 'password']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
            'es_admin' => false
        ]);
    }
}