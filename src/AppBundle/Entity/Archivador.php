<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Archivador
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $numero;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Elementos", mappedBy="archivador")
     * @var Elementos
     * @ORM\JoinColumn(nullable=false)
     */
    private $elementos;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Armario", inversedBy="archivadores")
     * @var Armario
     * @ORM\JoinColumn(nullable=true)
     */
    private $armario;

    /**
     * Convierte el archivador en una cadena de texto
     */
    public function __toString()
    {
        return $this->getNumero() . ', ' . $this->getColor();
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
     * Set numero
     *
     * @param integer $numero
     *
     * @return Archivador
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Archivador
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set elementos
     *
     * @param \AppBundle\Entity\Elementos $elementos
     *
     * @return Archivador
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->elementos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add elemento
     *
     * @param \AppBundle\Entity\Elementos $elemento
     *
     * @return Archivador
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
     * Set armario
     *
     * @param \AppBundle\Entity\Armario $armario
     *
     * @return Archivador
     */
    public function setArmario(\AppBundle\Entity\Armario $armario)
    {
        $this->armario = $armario;

        return $this;
    }

    /**
     * Get armario
     *
     * @return \AppBundle\Entity\Armario
     */
    public function getArmario()
    {
        return $this->armario;
    }
}
