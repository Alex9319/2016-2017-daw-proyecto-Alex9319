<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

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
     * @ORM\Column(type="string")
     * @var string
     */
    private $nombre;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $observaciones;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $NivelDeAcceso;

    /**
     * @var Date
     * @ORM\Column(name="fecha_alta", type="date",nullable=true)
     */
    private $fechaAlta;

    /**
     * @var Date
     * @ORM\Column(name="fecha_baja", type="date",nullable=true)
     */
    private $fechaBaja;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Armario", inversedBy="elementos")
     * @var Armario
     * @ORM\JoinColumn(nullable=true)
     */
    private $armario;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Archivador", inversedBy="elementos")
     * @var Archivador
     * @ORM\JoinColumn(nullable=true)
     */
    private $archivador;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Categoria", inversedBy="elementos")
     * @var Categoria
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoria;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Multimedia", inversedBy="elementos")
     * @var Multimedia
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
    }

    public function __toString()
    {
        return $this->getNombre().'.....'.$this->getObservaciones();
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
     * @param integer $observaciones
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
     * @return integer
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
     * Add armario
     *
     * @param \AppBundle\Entity\Armario $armario
     *
     * @return Elementos
     */
    public function addArmario(\AppBundle\Entity\Armario $armario)
    {
        $this->armario[] = $armario;

        return $this;
    }

    /**
     * Remove armario
     *
     * @param \AppBundle\Entity\Armario $armario
     */
    public function removeArmario(\AppBundle\Entity\Armario $armario)
    {
        $this->armario->removeElement($armario);
    }

    /**
     * Get armario
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArmario()
    {
        return $this->armario;
    }

    /**
     * Add archivador
     *
     * @param \AppBundle\Entity\Archivador $archivador
     *
     * @return Elementos
     */
    public function addArchivador(\AppBundle\Entity\Archivador $archivador)
    {
        $this->archivador[] = $archivador;

        return $this;
    }

    /**
     * Remove archivador
     *
     * @param \AppBundle\Entity\Archivador $archivador
     */
    public function removeArchivador(\AppBundle\Entity\Archivador $archivador)
    {
        $this->archivador->removeElement($archivador);
    }

    /**
     * Get archivador
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArchivador()
    {
        return $this->archivador;
    }

    /**
     * Add categorium
     *
     * @param \AppBundle\Entity\Categoria $categorium
     *
     * @return Elementos
     */
    public function addCategorium(\AppBundle\Entity\Categoria $categorium)
    {
        $this->categoria[] = $categorium;

        return $this;
    }

    /**
     * Remove categorium
     *
     * @param \AppBundle\Entity\Categoria $categorium
     */
    public function removeCategorium(\AppBundle\Entity\Categoria $categorium)
    {
        $this->categoria->removeElement($categorium);
    }

    /**
     * Get categoria
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set archivador
     *
     * @param \AppBundle\Entity\Categoria $archivador
     *
     * @return Elementos
     */
    public function setArchivador(\AppBundle\Entity\Categoria $archivador = null)
    {
        $this->archivador = $archivador;

        return $this;
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

    /**
     * Set armario
     *
     * @param \AppBundle\Entity\Armario $armario
     *
     * @return Elementos
     */
    public function setArmario(\AppBundle\Entity\Armario $armario = null)
    {
        $this->armario = $armario;

        return $this;
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
     * Set multimedia
     *
     * @param \AppBundle\Entity\Multimedia $multimedia
     *
     * @return Elementos
     */
    public function setMultimedia(\AppBundle\Entity\Multimedia $multimedia)
    {
        $this->multimedia = $multimedia;

        return $this;
    }
}
