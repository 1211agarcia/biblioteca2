<?php

namespace Biblioteca\TegBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * teg
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Biblioteca\TegBundle\Entity\tegRepository")
 */
class teg
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cota", type="string", length=20, unique=true,nullable=false)
     */
    private $cota;

    /**
     * @var string
     *
     * @ORM\Column(name="escuela", type="string", length=20, nullable=false)
     */
    private $escuela;

    /**
     * @var \Date
     *
     * @ORM\Column(name="publicacion", type="date", nullable=false)
     */
    private $publicacion;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=500, nullable=false)
     * @Assert\Length(
     *     min=5,
     *     max=500,
     *     minMessage="El titulo es muy corto.",
     *     maxMessage="El titulo es muy largo."
     * )
     */
    private $titulo;

    /**
     * @var array
     *
     * @ORM\Column(name="palabrasClave", type="array", nullable=false)
     */
    private $palabrasClave;

    /**
     * @var string
     *
     * @ORM\Column(name="resumen", type="text", nullable=false)
     */
    private $resumen;

    /**
     * @var array
     *
     * @ORM\Column(name="autores", type="array", nullable=false)
     */
    private $autores;

    /**
     * @var array
     *
     * @ORM\Column(name="tutores", type="array", nullable=false)
     */
    private $tutores;

    /**
     *
     * @ORM\OneToMany(targetEntity="documento", mappedBy="id") 
     */
    protected $capitulos;

    public function __construct()
    {
        $this->autores = new ArrayCollection(array(''));
        $this->tutores = new ArrayCollection(array(''));
        $this->palabrasClave = new ArrayCollection(array('','',''));
        $this->capitulos = new ArrayCollection(array(''));
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
     * Set cota
     *
     * @param string $cota
     * @return teg
     */
    public function setCota($cota)
    {
        $this->cota = $cota;

        return $this;
    }

    /**
     * Get cota
     *
     * @return string 
     */
    public function getCota()
    {
        return $this->cota;
    }

    /**
     * Set escuela
     *
     * @param string $escuela
     * @return teg
     */
    public function setEscuela($escuela)
    {
        $this->escuela = $escuela;

        return $this;
    }

    /**
     * Get escuela
     *
     * @return string 
     */
    public function getEscuela()
    {
        return $this->escuela;
    }

    /**
     * Set publicacion
     *
     * @param \Date $publicacion
     * @return teg
     */
    public function setPublicacion($publicacion)
    {
        $this->publicacion = $publicacion;

        return $this;
    }

    /**
     * Get publicacion
     *
     * @return \Date 
     */
    public function getPublicacion()
    {
        return $this->publicacion;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return teg
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set palabrasClave
     *
     * @param string $palabrasClave
     * @return teg
     */
    public function setPalabrasClave($palabrasClave)
    {
        $this->palabrasClave = $palabrasClave;

        return $this;
    }

    /**
     * Get palabrasClave
     *
     * @return string 
     */
    public function getPalabrasClave()
    {
        return $this->palabrasClave;
    }

    /**
     * Set resumen
     *
     * @param string $resumen
     * @return teg
     */
    public function setResumen($resumen)
    {
        $this->resumen = $resumen;

        return $this;
    }

    /**
     * Get resumen
     *
     * @return string 
     */
    public function getResumen()
    {
        return $this->resumen;
    }

    /**
     * Set autores
     *
     * @param array $autores
     * @return teg
     */
    public function setAutores($autores)
    {
        $this->autores = $autores;
        return $this;
    }

    /**
     * Get autores
     *
     * @return array
     */
    public function getAutores()
    {
       return $this->autores;
  //     return implode(",", $this->autores);
      
    }

    /**
     * Set tutores
     *
     * @param array $tutores
     * @return teg
     */
    public function setTutores($tutores)
    {
        $this->tutores = $tutores;
        return $this;
    }

    /**
     * Get tutores
     *
     * @return array
     */
    public function getTutores()
    {
       return $this->tutores;
      
    }

    public function __toString() {
        return sprintf('%d at %s (%s)', $this->getId(), $this->getCota(), $this->getTitulo());
    }


    

    /**
     * Add capitulos
     *
     * @param \Biblioteca\TegBundle\Entity\documento $capitulos
     * @return teg
     */
    public function addCapitulo(\Biblioteca\TegBundle\Entity\documento $capitulos)
    {
        $this->capitulos[] = $capitulos;

        return $this;
    }

    /**
     * Remove capitulos
     *
     * @param \Biblioteca\TegBundle\Entity\documento $capitulos
     */
    public function removeCapitulo(\Biblioteca\TegBundle\Entity\documento $capitulos)
    {
        $this->capitulos->removeElement($capitulos);
    }

    /**
     * Get capitulos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCapitulos()
    {
        return $this->capitulos;
    }
}
