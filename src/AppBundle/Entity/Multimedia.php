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
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $multimedia;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Elementos", mappedBy="multimedia")
     * @var Elementos
     * @ORM\JoinColumn(nullable=false)
     */
    private $elementos;

    public function __toString()
    {
        return $this->getMultimedia();
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
     * Add elemento
     *
     * @param \AppBundle\Entity\Elementos $elemento
     *
     * @return Multimedia
     */
    public function addElemento(\AppBundle\Entity\Elementos $elemento)
    {
        $this->elementos[] = $elemento;

        return $this;
    }

    /**
     * Remove elemento
     *
     * @param \AppBundle\Entity\Elementos $elemento
     */
    public function removeElemento(\AppBundle\Entity\Elementos $elemento)
    {
        $this->elementos->removeElement($elemento);
    }

    /**
     * Get elementos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getElementos()
    {
        return $this->elementos;
    }
}
