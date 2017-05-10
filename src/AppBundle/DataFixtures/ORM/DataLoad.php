<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Archivador;
use AppBundle\Entity\Armario;
use AppBundle\Entity\Categoria;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Usuario;

class dataLoad implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {

        $user = new Usuario();
        $user->setNombre('Administrador')->setNivelDeAcceso(2000)->setUsuario('root')->setApellidos('Admin');

        // the 'security.password_encoder' service requires Symfony 2.6 or higher
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, '1234');
        $user->setClave($password);

        $manager->persist($user);

        $armario=new Armario();
        $armario->setNombre('1. Derecha');
        $manager->persist($armario);

        $armario1=new Armario();
        $armario1->setNombre('1. Izquierda');
        $manager->persist($armario1);

        $archivador=new Archivador();
        $archivador->setNumero(1)->setColor('Verde')->setArmario($armario);
        $manager->persist($archivador);

        $archivador1=new Archivador();
        $archivador1->setNumero(2)->setColor('Rojo')->setArmario($armario1);
        $manager->persist($archivador1);

        $categoria=new Categoria();
        $categoria->setNumero(1)->setNombre('Principal');
        $manager->persist($categoria);

        $categoria1=new Categoria();
        $categoria1->setNumero(2)->setNombre('Hija')->setPadre($categoria);
        $manager->persist($categoria1);

        $manager->flush();
    }
}
