<?php

namespace AppBundle\Form\Listener;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddArchivador implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            //FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit',
        );
    }

    /**
     * Este evento se ejecuta al momento de crear el formulario
     * o al llamar al método $form->setData($user),
     * y nos sirve para obtener datos inicales del objeto asociado al form.
     * Ya que por ejemplo si el objeto viene de la base de datos y contiene
     * ya un pais establecido, lo ideal es que el campo state se carge inicalmente con
     * los estados de dicho pais.
     */
//    public function preSetData(FormEvent $event)
//    {
//        $data = $event->getData();
//        //data es un arreglo con los valores establecidos por el usuario en el form.
//
//        $armario = ($nombre and $nombre->getArmario()) ? $nombre->getArmario() : null;
//        //como $data contiene el armario seleccionado por el usuario al enviar el formulario,
//        // usamos el valor de la posicion $data['armario'] para filtrar el sql de los estados
//        $this->addField($event->getForm(), $armario);
//    }

    /**
     * Cuando el usuario llene los datos del formulario y haga el envío del mismo,
     * este método será ejecutado.
     */
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        //data es un arreglo con los valores establecidos por el usuario en el form.

        //como $data contiene el armario seleccionado por el usuario al enviar el formulario,
        // usamos el valor de la posicion $data['armario'] para filtrar el sql de los estados
        $this->addField($event->getForm(), $data['archivador']);
    }

    protected function addField(Form $form, $archivador)
    {
        // actualizamos el campo archivadores, pasandole el armario a la opción
        // query_builder, para que el dql tome en cuenta el armario
        // y filtre la consulta por su valor.
        $form->add('archivador', null, array(
            'class' => 'AppBundle\Entity\Archivador',
            'query_builder' => function(EntityRepository $er) use ($archivador){
                return $er->createQueryBuilder('archivadores')
                    ->select('a.id')
                    ->from('AppBundle:Archivador', 'a')
                    ->where('archivador.id =: archivador')
                    ->setParameter('archivador', $archivador);
            }
        ));
    }

}