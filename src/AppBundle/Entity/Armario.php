<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Armario
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string",unique=true, nullable=false, length=25)
     * @var string
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", nullable=false, length=50)
     * @var string
     */
    private $ubicacion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Archivador", mappedBy="armario")
     * @var Archivador
     * @ORM\JoinColumn(nullable=false)
     */
    private $archivadores;

    /**
     * Convierte el armario en una cadena de texto
     */
    public function __toString()
    {
        return $this->getNombre();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->elementos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->archivadores = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Armario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add archivadore
     *
     * @param \AppBundle\Entity\Archivador $archivadore
     *
     * @return Armario
     */
    public function addArchivadore(\AppBundle\Entity\Archivador $archivadore)
    {
        $this->archivadores[] = $archivadore;

        return $this;
    }

    /**
     * Remove archivadore
     *
     * @param \AppBundle\Entity\Archivador $archivadore
     */
    public function removeArchivadore(\AppBundle\Entity\Archivador $archivadore)
    {
        $this->archivadores->removeElement($archivadore);
    }

    /**
     * Get archivadores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArchivadores()
    {
        return $this->archivadores;
    }

    /**
     * Set ubicacion
     *
     * @param string $ubicacion
     *
     * @return Armario
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get ubicacion
     *
     * @return string
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }
}
