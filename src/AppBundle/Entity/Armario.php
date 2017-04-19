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
     * @ORM\Column(type="integer")
     * @var int
     */
    private $numero;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $puerta;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Elementos", mappedBy="armario")
     * @var Elementos
     * @ORM\JoinColumn(nullable=false)
     */
    private $elementos;

    /**
     * Convierte el armario en una cadena de texto
     */
    public function __toString()
    {
        return $this->getNumero() . ', ' . $this->getPuerta();
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
     * @return Armario
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
     * Set puerta
     *
     * @param string $puerta
     *
     * @return Armario
     */
    public function setPuerta($puerta)
    {
        $this->puerta = $puerta;

        return $this;
    }

    /**
     * Get puerta
     *
     * @return string
     */
    public function getPuerta()
    {
        return $this->puerta;
    }

    /**
     * Set elementos
     *
     * @param \AppBundle\Entity\Elementos $elementos
     *
     * @return Armario
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
     * @return Armario
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
}
