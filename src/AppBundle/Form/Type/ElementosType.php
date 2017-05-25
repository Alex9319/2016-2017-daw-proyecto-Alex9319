<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Elementos;
use AppBundle\Form\Listener\AddArchivador;
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
                'label' => 'Nombre del Articulo',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca el nombre del Articulo'
                )
            ])
            ->add('observaciones', TextareaType::class, [
                'label' => 'Observaciones del Articulo',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduzca la descripcion del articulo'
                )
            ])
            ->add('nivelDeAcceso', IntegerType::class, [
                'label' => 'Nivel de acceso del Articulo',
                'required' => true,
                'attr'=>array(
                    'placeholder' =>'Introduzca el Nivel de Acceso (MENOR de 1200 PÚBLICO, MAYOR de 1200 hasta 1999 PRIVADO)',
                    'min' =>1,
                    'max' =>1999
                ),
            ])
            ->add('fechaAlta', null, [
                'label' => 'Fecha de Alta',
                'widget' => 'single_text',
                'required' => true,
                'placeholder'=>'dd/mm/aaaa'
            ])
            ->add('armario', null, [
                'label' => 'Armario donde se encuentra el Archivador',
                'placeholder'=>'Seleccione el un Armario',
                'class'=>'AppBundle\Entity\Armario',
                'required' => false
            ])
            ->add('archivador', null, [
                'label' => 'Archivador donde se encuentra el Articulo',
                'placeholder'=>'Seleccione el Archivador',
                'class'=>'AppBundle\Entity\Archivador',
                'required' => false
            ])
            ->add('categoria', null, [
                'label' => 'Categoria del Articulo',
                'required' => true,
                'placeholder'=>'Seleccione la Categoria'
            ]);
        // Añadimos un EventListener que actualizará el campo archivadores
        // para que sus opciones correspondan
        // con el armario seleccionado por el usuario
        $builder->addEventSubscriber(new AddArchivador());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Elementos::class,
            'translation_domain' => false
        ]);
    }
    public function getNombre()
    {
        return 'nombre';
    }
}