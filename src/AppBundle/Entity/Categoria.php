<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Categoria
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
    private $numero;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Categoria")
     * @var Categoria
     * @ORM\JoinColumn(nullable=true)
     */
    private $padre;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Elementos", mappedBy="categoria")
     * @var Elementos
     * @ORM\JoinColumn(nullable=false)
     */
    private $elementos;

    public function __toString()
    {
        $cat = $this;

        $resultado = $this->getNumero() . '. ' . $this->getNombre();

        while($cat->getPadre()) {
            $cat = $cat->getPadre();
            $resultado = $cat->getNumero() . '.' . $resultado;
        }

        return $resultado;
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
     * @param integer $nombre
     *
     * @return Categoria
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return integer
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set padre
     *
     * @param \AppBundle\Entity\Categoria $padre
     *
     * @return Categoria
     */
    public function setPadre(\AppBundle\Entity\Categoria $padre)
    {
        $this->padre = $padre;

        return $this;
    }

    /**
     * Get padre
     *
     * @return \AppBundle\Entity\Categoria
     */
    public function getPadre()
    {
        return $this->padre;
    }

    /**
     * Set elementos
     *
     * @param \AppBundle\Entity\Elementos $elementos
     *
     * @return Categoria
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
     * Set numero
     *
     * @param integer $numero
     *
     * @return Categoria
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
     * Add elemento
     *
     * @param \AppBundle\Entity\Elementos $elemento
     *
     * @return Categoria
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
