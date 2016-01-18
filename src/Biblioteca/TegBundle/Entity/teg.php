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
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(message="Debe ingresar la cota")
     */
    private $cota;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20)
     * @Assert\Choice(callback = "getSchools")
     * @Assert\NotBlank(message="Debe ingresar el Departamento")
     */
    private $escuela;

    /**
     * @var \Date
     *
     * @ORM\Column(type="date")
     * @Assert\Date(message="Este Valor no es una fecha")
     * @Assert\NotBlank(message="Debe ingresar la fecha de publicación")
     */
    private $publicacion;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     * @Assert\Length(
     *     min=5,
     *     max=500,
     *     minMessage="El titulo es muy corto.",
     *     maxMessage="El titulo es muy largo."
     * )
     * @Assert\NotBlank(message="Debe escribir un título")
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Length(
     *     min=5,
     *     minMessage="El resumen es muy corto."
     * )
     * @Assert\NotBlank(message="Debe escribir ingresar el resumen")
     */
    private $resumen;


    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;


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
     * @Assert\NotNull(message="Debe tener un valor valido")
     */
    private $published;

    /**
     * @var array
     * @ORM\OneToMany(targetEntity="author", mappedBy="teg", cascade={"persist", "remove"}, orphanRemoval=true) 
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
     * @ORM\OneToMany(targetEntity="tuthor", mappedBy="teg", cascade={"persist", "remove"}, orphanRemoval=true) 
     * @Assert\Valid
     */
    private $tuthors;

    /**
     * @var array
     * @Assert\Count(
     *      min = "1",
     *      max = "5",
     *      minMessage = "Debe tener al menos 1 Archivo, en caso de ser el tomo completo",
     *      maxMessage = "Sólo puede tener como maximo {{ limit }} Archivos"
     * )
     * @ORM\OneToMany(targetEntity="documento", mappedBy="teg", cascade={"persist", "remove"}, orphanRemoval=true) 
     * @Assert\Valid
     */
    protected $capitulos;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="keyWord", mappedBy="teg", cascade={"persist", "remove"}, orphanRemoval=true) 
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
     * @ORM\ManyToOne(targetEntity="Biblioteca\UserBundle\Entity\usuario", inversedBy="creations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $creator;
    public function __construct()
    {
        $this->authors = new ArrayCollection(array(new author()));
        $this->tuthors = new ArrayCollection(array(new tuthor()));
        $this->keyWords = new ArrayCollection();
        $this->capitulos = new ArrayCollection(array(new documento("Capitulo_1")
            ,new documento("Capitulo_2"),new documento("Capitulo_3"),
            new documento("Capitulo_4"),new documento("Capitulo_5")
            ));
        $this->published = false;
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

    public function __toString() {
        //print_r (sprintf('%s (%s)\nPalabras: %s\nAutores: %s\nTutores: %s', $this->getTitulo(), $this->getCota(), implode(",", $this->getKeyWords()), implode(",", $this->Authors()), implode(",", $this->Tuthros())));
        return sprintf($this->getTitulo().' ('.$this->getCota().')'/*.$this->getResumen().'<br>Palabras: '.$this->getKeyWords().'\nAutores: '.$this->Authors().'\nTutores: '.$this->Tuthros()*/);
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
     * Get authors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAuthors()
    {
        return $this->authors;
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
     * Get keyWords
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getKeyWords()
    {
        return $this->keyWords;
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
     * Add author
     *
     * @param \Biblioteca\TegBundle\Entity\author $author
     * @return teg
     */
    public function addAuthor(\Biblioteca\TegBundle\Entity\author $author)
    {
        $this->authors[] = $author;
        $author->setTeg($this);

        return $this;
    }
    /**
     * Add tuthor
     *
     * @param \Biblioteca\TegBundle\Entity\tuthor $tuthor
     * @return teg
     */
    public function addTuthor(\Biblioteca\TegBundle\Entity\tuthor $tuthor)
    {
        $this->tuthors[] = $tuthor;
        $tuthor->setTeg($this);

        return $this;
    }
    /**
     * Add keyWord
     *
     * @param \Biblioteca\TegBundle\Entity\keyword $keyWord
     * @return teg
     */
    public function addKeyWord(\Biblioteca\TegBundle\Entity\keyword $keyWord)
    {
        $this->keyWords[] = $keyWord;
        $keyWord->setTeg($this);

        return $this;
    }
    /**
     * Add capitulo
     *
     * @param \Biblioteca\TegBundle\Entity\documento $capitulo
     * @return teg
     */
    public function addCapitulo(\Biblioteca\TegBundle\Entity\documento $capitulo)
    {
        $this->capitulos[] = $capitulo;
        $capitulo->setTeg($this);
        
        return $this;
    }
    /**
     * Remove author
     *
     * @param \Biblioteca\TegBundle\Entity\author $author
     */
    public function removeAuthor(\Biblioteca\TegBundle\Entity\author $author)
    {
        $this->authors->removeElement($author);
        $author->setTeg(null);
    }
    /**
     * Remove tuthor
     *
     * @param \Biblioteca\TegBundle\Entity\tuthor $tuthor
     */
    public function removeTuthor(\Biblioteca\TegBundle\Entity\tuthor $tuthor)
    {
        $this->tuthors->removeElement($tuthor);
        $tuthor->setTeg(null);
    }
    /**
     * Remove keyWord
     *
     * @param \Biblioteca\TegBundle\Entity\keyword $keyWord
     */
    public function removeKeyWord(\Biblioteca\TegBundle\Entity\keyword $keyWord)
    {
        $this->keyWords->removeElement($keyWords);
        $keyWord->setTeg(null);
    }
    /**
     * Remove capitulo
     *
     * @param \Biblioteca\TegBundle\Entity\documento $capitulo
     */
    public function removeCapitulo(\Biblioteca\TegBundle\Entity\documento $capitulo)
    {
        $this->capitulos->removeElement($capitulo);
        $capitulo->setTeg(null);
    }

    /**
     * Remove authors
     *
     */
    public function removeAllAuthors()
    {
        $capitulo->setTeg(null);
        $this->authors->clear();

    }
    /**
     * Remove tuthors
     *
     */
    public function removeAllTuthors()
    {
        $this->tuthors->clear();
    }
    /**
     * Remove keyWords
     *
     */
    public function removeAllKeyWords()
    {
        $this->keyWords->clear();
    }
    /**
     * Remove capitulos
     *
     */
    public function removeAllCapitulos()
    {
        $this->capitulos->clear();
    }

}