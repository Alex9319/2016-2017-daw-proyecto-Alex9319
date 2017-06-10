<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Archivador;
use AppBundle\Entity\Armario;
use AppBundle\Entity\Categoria;
use AppBundle\Entity\Elementos;
use AppBundle\Entity\Multimedia;
use AppBundle\Form\Type\MultimediaType;
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
        $password = $encoder->encodePassword($user, '123456');
        $user->setClave($password);

        $manager->persist($user);

        $armario=new Armario();
        $armario->setNombre('Armario de ejemplo de la sala 1')->setUbicacion("Armario localizado en la sala 5");
        $manager->persist($armario);

        $archivador=new Archivador();
        $archivador->setNumero(1)->setColor('Verde')->setArmario($armario)->setDescripcion("Archivador que contiene partituras");
        $manager->persist($archivador);

        $categoria=new Categoria();
        $categoria->setNumero(1)->setNombre('Principal');
        $manager->persist($categoria);

        $articulo=new Elementos();
        $articulo->setNombre("Imagen del Maestro")->setObservaciones("En la imagen podemos ver una foto del maestro con una de sus guitarras")->setLocalizacion("Linares")->setNivelDeAcceso(1200)->setFechaAlta(new \DateTime("now"))->setArchivador($archivador)->setCategoria($categoria);
        $manager->persist($articulo);

        $multimedia=new Multimedia();
        $multimedia->setNombre('Ejemplo')->setMultimedia("uploads/image/ejemplo.jpg")->setType("image/jpg")->setElementos($articulo)->setObservaciones("Imagen del maestro");
        $manager->persist($multimedia);

        $manager->flush();
    }
}
