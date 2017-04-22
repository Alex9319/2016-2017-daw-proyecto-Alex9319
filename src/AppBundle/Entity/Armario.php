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
        return $this->getNumero() . ', ' . $this->getPuerta();
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

    /**
     * Get elementos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getElementos()
    {
        return $this->elementos;
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
}
