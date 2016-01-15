<?php

namespace Biblioteca\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Biblioteca\TegBundle\Validator\Constraints as TegAssert;

/**
 * usuario
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="Biblioteca\UserBundle\Entity\usuarioRepository")
 * 
 * @author Armando Garcia <1211agarcia@gmail.com>
 */
class usuario extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     *
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=5,
     *     max=50,
     *     minMessage="El nombre es muy corto. (min 5)",
     *     maxMessage="El nombre es muy largo. (max 50)"
     * )
     * @TegAssert\ContainsAlphanumeric
     */
    protected $name;
    

    /**
     * @ORM\OneToMany(targetEntity="Biblioteca\TegBundle\Entity\teg", mappedBy="creator")
     * @Assert\Valid()
     */
    protected $creations;


    public function __construct()
    {
        parent::__construct();
        // tu propia lógica
        $this->creations = new ArrayCollection();
    }

    /**
     * Implementación de una lista de roles para los usuarios 
     * 
     * @throws Exception
     * @param Rol $rol 
     */
    public function addRole($rol)
    {
        switch($rol){
            case 1:
                array_push($this->roles, 'ROLE_USER');
                break;
            case 2:
                array_push($this->roles, 'ROLE_ESTUDIANTE');
                break;
            case 3:
                array_push($this->roles, 'ROLE_ADMIN');
                break;
            case 4:
                array_push($this->roles, 'ROLE_SUPER_ADMIN');
                break;
            default:
                array_push($this->roles, 'ROLE_USER');
                break;
        }
    }      
    /**
     * 
     * @throws Exception
     * @param array $roles 
     */
    public function setRoles(array $roles)
    {
        $this->roles = array();

        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
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
     * @param string $nombre
     * @return usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return usuario
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
     * Add creation
     *
     * @param \Biblioteca\TegBundle\Entity\teg $creation
     * @return usuario
     */
    public function addCreation(\Biblioteca\TegBundle\Entity\teg $creation)
    {
        $this->creations[] = $creation;
        $creation->setCreator($this);

        return $this;
    }

    /**
     * Remove creations
     *
     * @param \Biblioteca\TegBundle\Entity\teg $creations
     */
    public function removeCreation(\Biblioteca\TegBundle\Entity\teg $creations)
    {
        $this->creations->removeElement($creations);
    }

    /**
     * Get creations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCreations()
    {
        return $this->creations;
    }
}
