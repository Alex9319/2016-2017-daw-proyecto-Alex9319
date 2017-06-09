<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Multimedia
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true, length=25)
     * @var string
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", nullable=false, length=100)
     * @var string
     */
    private $multimedia;
    /**
     * @ORM\Column(type="string", nullable=false, length=25)
     * @var string
     */
    private $type;
    /**
     * @ORM\Column(type="string", nullable=true, length=100)
     * @var string
     */
    private $observaciones;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Elementos", inversedBy="multimedia")
     * @var Elementos
     * @ORM\JoinColumn(nullable=false)
     */
    private $elementos;

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
     * @return Multimedia
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
     * Set multimedia
     *
     * @param string $multimedia
     *
     * @return Multimedia
     */
    public function setMultimedia($multimedia)
    {
        $this->multimedia = $multimedia;

        return $this;
    }

    /**
     * Get multimedia
     *
     * @return string
     */
    public function getMultimedia()
    {
        return $this->multimedia;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Multimedia
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * @param string $observaciones
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    /**
     * Set elementos
     *
     * @param \AppBundle\Entity\Elementos $elementos
     *
     * @return Multimedia
     */
    public function setElementos(\AppBundle\Entity\Elementos $elementos)
    {
        $this->elementos = $elementos;

        return $this;
    }

    /**
     * Get elementos
     *
     * @return \AppBundle\Entity\Elementos
     */
    public function getElementos()
    {
        return $this->elementos;
    }
}
