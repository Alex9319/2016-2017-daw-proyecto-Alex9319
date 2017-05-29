<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Elementos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, nullable=false)
     * @var string
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $observaciones;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var int
     */
    private $NivelDeAcceso;

    /**
     * @var \DateTime
     * @ORM\Column(name="fecha_alta", type="date",nullable=false)
     */
    private $fechaAlta;

    /**
     * @var \DateTime
     * @ORM\Column(name="fecha_baja", type="date",nullable=true)
     */
    private $fechaBaja;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Archivador", inversedBy="elementos")
     * @var Archivador
     * @ORM\JoinColumn(nullable=false)
     */
    private $archivador;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Categoria", inversedBy="elementos")
     * @var Categoria
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoria;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Multimedia", mappedBy="elementos")
     * @var Collection
     * @ORM\JoinColumn(nullable=false)
     */
    private $multimedia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->armario = new \Doctrine\Common\Collections\ArrayCollection();
        $this->archivador = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categoria = new \Doctrine\Common\Collections\ArrayCollection();
        $this->multimedia = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNombre();
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
     * @return Elementos
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
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Elementos
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set nivelDeAcceso
     *
     * @param integer $nivelDeAcceso
     *
     * @return Elementos
     */
    public function setNivelDeAcceso($nivelDeAcceso)
    {
        $this->NivelDeAcceso = $nivelDeAcceso;

        return $this;
    }

    /**
     * Get nivelDeAcceso
     *
     * @return integer
     */
    public function getNivelDeAcceso()
    {
        return $this->NivelDeAcceso;
    }

    /**
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     *
     * @return Elementos
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    /**
     * Get fechaAlta
     *
     * @return \DateTime
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * Set fechaBaja
     *
     * @param \DateTime $fechaBaja
     *
     * @return Elementos
     */
    public function setFechaBaja($fechaBaja)
    {
        $this->fechaBaja = $fechaBaja;

        return $this;
    }

    /**
     * Get fechaBaja
     *
     * @return \DateTime
     */
    public function getFechaBaja()
    {
        return $this->fechaBaja;
    }

    /**
     * Set archivador
     *
     * @param \AppBundle\Entity\Archivador $archivador
     *
     * @return Elementos
     */
    public function setArchivador(\AppBundle\Entity\Archivador $archivador = null)
    {
        $this->archivador = $archivador;

        return $this;
    }

    /**
     * Get archivador
     *
     * @return \AppBundle\Entity\Archivador
     */
    public function getArchivador()
    {
        return $this->archivador;
    }

    /**
     * Set categoria
     *
     * @param \AppBundle\Entity\Categoria $categoria
     *
     * @return Elementos
     */
    public function setCategoria(\AppBundle\Entity\Categoria $categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \AppBundle\Entity\Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Add multimedia
     *
     * @param \AppBundle\Entity\Multimedia $multimedia
     *
     * @return Elementos
     */
    public function addMultimedia(\AppBundle\Entity\Multimedia $multimedia)
    {
        $this->multimedia[] = $multimedia;

        return $this;
    }

    /**
     * Remove multimedia
     *
     * @param \AppBundle\Entity\Multimedia $multimedia
     */
    public function removeMultimedia(\AppBundle\Entity\Multimedia $multimedia)
    {
        $this->multimedia->removeElement($multimedia);
    }

    /**
     * Get multimedia
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMultimedia()
    {
        return $this->multimedia;
    }
}
