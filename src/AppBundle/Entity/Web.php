<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Web
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
     * @ORM\Column(type="string")
     * @var string
     */
    private $imagen;

    /**
     * @ORM\Column(type="string")
     * @var string
     */

    private $footer;

    /**
     * @ORM\Column(type="string")
     * @var string
     */

    private $imageninicial;

    /**
     * @ORM\Column(type="string")
     * @var string
     */

    private $textoinicial;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @param string $imagen
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
        return $this;
    }

    /**
     * @return string
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * @param string $footer
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageninicial()
    {
        return $this->imageninicial;
    }

    /**
     * @param string $imageninicial
     */
    public function setImageninicial($imageninicial)
    {
        $this->imageninicial = $imageninicial;
        return $this;
    }

    /**
     * @return string
     */
    public function getTextoinicial()
    {
        return $this->textoinicial;
    }

    /**
     * @param string $textoinicial
     */
    public function setTextoinicial($textoinicial)
    {
        $this->textoinicial = $textoinicial;
        return $this;
    }


}