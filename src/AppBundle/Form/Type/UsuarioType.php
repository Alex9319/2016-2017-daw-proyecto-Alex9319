<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                'label' => 'Nombre de Usuario'
            ])
            ->add('nivelDeAcceso', null, [
                'label' => 'Nivel de Acceso',
                'disabled' => !$options['es_admin']
            ])
            ->add('save', SubmitType::class, array('label' => 'Guardar Usuario', 'attr' => array('class'=> 'btn btn-success')));

        if (!$options['es_admin']) {
            $builder
                ->add('antigua', PasswordType::class, [
                    'label' => 'Clave Antigua',
                    'mapped' => false,
                    'constraints' => [
                        new UserPassword()
                    ]
                 ]);
        }

        $builder
            ->add('nueva', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Clave Nueva',
                ],
                'second_options' => [
                    'label' => 'Repetir Clave Nueva'
                ]
            ])
            ->add('save', SubmitType::class, array('label' => 'Guardar Usuario y Contraseña', 'attr' => array('class'=> 'btn btn-success')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
            'es_admin' => false
        ]);
    }
}