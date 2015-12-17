<?php

namespace Biblioteca\TegBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Biblioteca\TegBundle\Entity\documento;
use Biblioteca\TegBundle\Entity\tuthor;
use Biblioteca\TegBundle\Entity\author;
use Biblioteca\TegBundle\Entity\keyWord;

/**
 * teg
 *
 * @author Armando Garcia <1211agarcia@gmail.com>
 * @author Currently Working: Armando Garcia <1211agarcia@gmail.com>
 * @version 17/09/2015
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Biblioteca\TegBundle\Entity\tegRepository")
 */
class teg
{
    private static $escuelas = array(
                "Biología"=>"Biología",
                "Computación"=>"Computación", 
                "Física"=>"Física",
                "Matemática"=>"Matemática",
                "Química"=>"Química");

    public static function getSchools() {
        return self::$escuelas;
    }
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
     * D[Inicial de Escuela]{indica}[año en 2 digitos]
     *
     * @ORM\Column(type="string", length=20, unique=true)
     * @Assert\NotNull(message="Debe ingresar la cota")
     */
    private $cota;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20)
     * @Assert\Choice(callback = "getSchools")
     * @Assert\NotNull(message="Debe ingresar el Departamento")
     */
    private $escuela;

    /**
     * @var \Date
     *
     * @ORM\Column(type="date")
     * @Assert\Date(message="Este Valor no es una fecha")
     * @Assert\NotNull(message="Debe ingresar la fecha de publicación")
     */
    private $publicacion;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=500)
     * @Assert\Length(
     *     min=5,
     *     max=500,
     *     minMessage="El titulo es muy corto.",
     *     maxMessage="El titulo es muy largo."
     * )
     * @Assert\NotNull(message="Debe escribir un título")
     */
    private $titulo;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="keyWord", mappedBy="teg") 
     * @Assert\Valid
     *
     * @Assert\Count(
     *      min = "3",
     *      max = "15",
     *      minMessage = "Debe ingresar al menos 3 palabras",
     *      maxMessage = "No puede ingresar más de {{ limit }} palabras"
     * )
     */
    private $keyWords;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotNull(message="Debe ingresar el resumen")
     */
    private $resumen;

    /**
     * @var array
     * @ORM\OneToMany(targetEntity="author", mappedBy="teg") 
     * @Assert\Valid
     * @Assert\Count(
     *      min = "1",
     *      max = "2",
     *      minMessage = "Debe tener al menos 1 Autor",
     *      maxMessage = "Sólo puede tener como maximo {{ limit }} Autores"
     * )
     */
    private $authors;

    /**
     * @var array
     * @Assert\Count(
     *      min = "1",
     *      max = "2",
     *      minMessage = "Debe tener al menos 1 Tutor",
     *      maxMessage = "Sólo puede tener como maximo {{ limit }} Tutores"
     * )
     * @ORM\OneToMany(targetEntity="tuthor", mappedBy="teg") 
     * @Assert\Valid
     */
    private $tuthors;

    /**
     * @var array
     * @Assert\Count(
     *      min = "1",
     *      max = "5",
     *      minMessage = "Debe tener al menos 1 Archivo",
     *      maxMessage = "Sólo puede tener como maximo {{ limit }} Archivos"
     * )
     * @ORM\OneToMany(targetEntity="documento", mappedBy="teg") 
     * @Assert\Valid
     */
    protected $capitulos;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="Biblioteca\UserBundle\Entity\usuario", inversedBy="creations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $creator;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @var boolean $published
     *
     * @ORM\Column(type="boolean")
     * @Assert\NotNull(message="Debe tener un palo valido")
     */
    private $published;

    public function __construct()
    {
        $this->authors = new ArrayCollection(array(new author(),new author()));
        $this->tuthors = new ArrayCollection(array(new tuthor(),new tuthor()));
        $this->keyWords = new ArrayCollection(array(new keyword(),new keyword()));
        $this->capitulos = new ArrayCollection(array(new documento(),new documento(),new documento(),new documento(),new documento()));
        $this->published = true;
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

    public function __toString() {
        //print_r (sprintf('%s (%s)\nPalabras: %s\nAutores: %s\nTutores: %s', $this->getTitulo(), $this->getCota(), implode(",", $this->getKeyWords()), implode(",", $this->Authors()), implode(",", $this->Tuthros())));
        return sprintf($this->getTitulo().' ('.$this->getCota().')'/*.$this->getResumen().'<br>Palabras: '.$this->getKeyWords().'\nAutores: '.$this->Authors().'\nTutores: '.$this->Tuthros()*/);
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
        $capitulos->setTeg($this);
        
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
     * Remove capitulos
     *
     */
    public function removeAllCapitulos()
    {
        unset($this->capitulos);
        $this->capitulos = new ArrayCollection();
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

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return teg
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return teg
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return teg
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set creator
     *
     * @param \Biblioteca\UserBundle\Entity\usuario $creator
     * @return teg
     */
    public function setCreator(\Biblioteca\UserBundle\Entity\usuario $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \Biblioteca\UserBundle\Entity\usuario 
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Add authors
     *
     * @param \Biblioteca\TegBundle\Entity\author $authors
     * @return teg
     */
    public function addAuthor(\Biblioteca\TegBundle\Entity\author $authors)
    {
        $this->authors[] = $authors;
        $authors->setTeg($this);

        return $this;
    }

    /**
     * Remove authors
     *
     * @param \Biblioteca\TegBundle\Entity\author $authors
     */
    public function removeAuthor(\Biblioteca\TegBundle\Entity\author $authors)
    {
        $this->authors->removeElement($authors);
    }

    /**
     * Set tuthors
     *
     * @param array $tuthors
     * @return teg
     */
    public function setTuthors($tuthors)
    {
        $this->tuthors = $tuthors;

        return $this;
    }

    /**
     * Get tuthors
     *
     * @return array 
     */
    public function getTuthors()
    {
        return $this->tuthors;
    }

    /**
     * Get authors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * Add keyWords
     *
     * @param \Biblioteca\TegBundle\Entity\keyword $keyWords
     * @return teg
     */
    public function addKeyWord(\Biblioteca\TegBundle\Entity\keyword $keyWord)
    {
        $this->keyWords[] = $keyWord;
        $keyWord->setTeg($this);

        return $this;
    }

    /**
     * Remove keyWords
     *
     * @param \Biblioteca\TegBundle\Entity\keyword $keyWords
     */
    public function removeKeyWord(\Biblioteca\TegBundle\Entity\keyword $keyWords)
    {
        $this->keyWords->removeElement($keyWords);
    }

    /**
     * Get keyWords
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getKeyWords()
    {
        return $this->keyWords;
    }

    /**
     * Add tuthors
     *
     * @param \Biblioteca\TegBundle\Entity\tuthor $tuthors
     * @return teg
     */
    public function addTuthor(\Biblioteca\TegBundle\Entity\tuthor $tuthor)
    {
        $this->tuthors[] = $tuthor;
        $tuthor->setTeg($this);

        return $this;
    }

    /**
     * Remove tuthors
     *
     * @param \Biblioteca\TegBundle\Entity\tuthor $tuthors
     */
    public function removeTuthor(\Biblioteca\TegBundle\Entity\tuthor $tuthors)
    {
        $this->tuthors->removeElement($tuthors);
    }
}
