<?php

namespace Biblioteca\TegBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Biblioteca\TegBundle\Entity\teg;

/**
 * author
 *
 * @author Armando Garcia <1211agarcia@gmail.com>
 * @author Currently Working: Armando Garcia <1211agarcia@gmail.com>
 * @version 2/12/2015
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Biblioteca\TegBundle\Entity\authorRepository")
 */
class author
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
     * @ORM\Column(type="string", length=25)
     * @Assert\Length(
     *     min=3,
     *     max=25,
     *     minMessage="El nombre es muy corto.",
     *     maxMessage="El nombre es muy largo."
     * )
     * @Assert\NotNull(message="Debe ingresar el Nombre del Autor")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=25)
     * @Assert\Length(
     *     min=3,
     *     max=25,
     *     minMessage="El Apellido es muy corto.",
     *     maxMessage="El Apellido es muy largo."
     * )
     * @Assert\NotNull(message="Debe ingresar el Apellido del Autor")
     */
    private $lastname;

    /**
     * @ORM\ManyToOne(targetEntity="Biblioteca\TegBundle\Entity\teg", inversedBy="authors")
     * @ORM\JoinColumn(name="teg_id", referencedColumnName="id")
     */
    private $teg;


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
     * Set name
     *
     * @param string $name
     * @return author
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return author
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set teg
     *
     * @param \Biblioteca\TegBundle\Entity\teg $teg
     * @return author
     */
    public function setTeg(\Biblioteca\TegBundle\Entity\teg $teg = null)
    {
        $this->teg = $teg;

        return $this;
    }

    /**
     * Get teg
     *
     * @return \Biblioteca\TegBundle\Entity\teg 
     */
    public function getTeg()
    {
        return $this->teg;
    }

    public function __toString() {
        return sprintf('%s %s', $this->getName(), $this->getLastname());
    }
}
