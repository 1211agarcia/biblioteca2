<?php

namespace Biblioteca\TegBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Biblioteca\TegBundle\Entity\teg;

/**
 * keyWord
 *
 * @author Armando Garcia <1211agarcia@gmail.com>
 * @author Currently Working: Armando Garcia <1211agarcia@gmail.com>
 * @version 2/12/2015
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Biblioteca\TegBundle\Entity\keyWordRepository")
 */
class keyWord
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
     *     minMessage="La Palabra es muy corta.",
     *     maxMessage="La Palabra es muy larga."
     * )
     */
    private $keyWord;

    /**
     * @ORM\ManyToOne(targetEntity="Biblioteca\TegBundle\Entity\teg", inversedBy="keyWords")
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
     * Set keyWord
     *
     * @param string $keyWord
     * @return keyWord
     */
    public function setKeyWord($keyWord)
    {
        $this->keyWord = $keyWord;

        return $this;
    }

    /**
     * Get keyWord
     *
     * @return string 
     */
    public function getKeyWord()
    {
        return $this->keyWord;
    }

    /**
     * Set teg
     *
     * @param \Biblioteca\TegBundle\Entity\teg $teg
     * @return keyWord
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
}
