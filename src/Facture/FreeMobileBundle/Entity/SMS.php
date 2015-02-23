<?php

namespace Facture\FreeMobileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SMS
 *
 * @ORM\Table(name="facture__sms")
 * @ORM\Entity(repositoryClass="Facture\FreeMobileBundle\Repository\SMSRepository")
 */
class SMS
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
     * @var float
     *
     * @ORM\Column(name="cout", type="float")
     */
    private $cout;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;


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
     * @return SMS
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
     * @return SMS
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
     * @return SMS
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
     * Set cout
     *
     * @param float $cout
     * @return SMS
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

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return SMS
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    
        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }
}
