<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Configuracion
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * @var string
     */
    private $clave;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $valor;

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set valor
     *
     * @param string $valor
     *
     * @return Configuracion
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return Configuracion
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }
}
