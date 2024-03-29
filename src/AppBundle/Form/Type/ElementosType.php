<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Elementos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElementosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, [
                'label' => 'Nombre del Artículo *',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca el nombre del Artículo'
                )
            ])
            ->add('observaciones', TextareaType::class, [
                'label' => 'Observaciones del Artículo *',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca la descripcion del artículo'
                )
            ])
            ->add('localizacion', null, [
                'label' => 'Localización *',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca la Ciudad de donde procede el articulo'
                )
            ])
            ->add('nivelDeAcceso', IntegerType::class, [
                'label' => 'Nivel de acceso del Artículo *',
                'required' => true,
                'attr'=>array(
                    'placeholder' =>'Introduzca el Nivel de Acceso (MENOR de 1200 PÚBLICO, MAYOR de 1200 hasta 1999 PRIVADO)',
                    'min' =>1,
                    'max' =>1999
                ),
            ])
            ->add('fechaAlta', null, [
                'label' => 'Fecha de Alta *',
                'widget' => 'single_text',
                'required' => true,
                'placeholder'=>'dd/mm/aaaa'
            ])
            ->add('archivador', null, [
                'label' => 'Archivador donde se encuentra el Artículo *',
                'placeholder'=>'Seleccione el Archivador',
                'class'=>'AppBundle\Entity\Archivador',
                'required' => true
            ])
            ->add('categoria', null, [
                'label' => 'Categoria del Artículo *',
                'required' => true,
                'placeholder'=>'Seleccione la Categoria'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Elementos::class,
            'translation_domain' => false
        ]);
    }
}