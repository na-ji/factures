<?php

namespace Facture\FreeMobileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MMS
 *
 * @ORM\Table(name="facture__mms")
 * @ORM\Entity(repositoryClass="Facture\FreeMobileBundle\Repository\MMSRepository")
 */
class MMS
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
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Facture\FreeMobileBundle\Entity\Contact",cascade={"persist"})
     */
    private $contact;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="origine", type="string", length=255)
     */
    private $origine;

    /**
     * @var integer
     *
     * @ORM\Column(name="volume", type="integer")
     */
    private $volume;

    /**
     * @var float
     *
     * @ORM\Column(name="cout", type="float")
     */
    private $cout;


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
     * Set contact
     *
     * @param integer $contact
     * @return MMS
     */
    public function setContact(\Facture\FreeMobileBundle\Entity\Contact $contact)
    {
        $this->contact = $contact;
    
        return $this;
    }

    /**
     * Get contact
     *
     * @return integer 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return MMS
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set origine
     *
     * @param string $origine
     * @return MMS
     */
    public function setOrigine($origine)
    {
        $this->origine = $origine;
    
        return $this;
    }

    /**
     * Get origine
     *
     * @return string 
     */
    public function getOrigine()
    {
        return $this->origine;
    }

    /**
     * Set volume
     *
     * @param integer $volume
     * @return MMS
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
    
        return $this;
    }

    /**
     * Get volume
     *
     * @return integer 
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Set cout
     *
     * @param float $cout
     * @return MMS
     */
    public function setCout($cout)
    {
        $this->cout = $cout;
    
        return $this;
    }

    /**
     * Get cout
     *
     * @return float 
     */
    public function getCout()
    {
        return $this->cout;
    }
}
