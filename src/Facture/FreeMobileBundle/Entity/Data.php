<?php

namespace Facture\FreeMobileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Data
 *
 * @ORM\Table(name="facture__data")
 * @ORM\Entity(repositoryClass="Facture\FreeMobileBundle\Repository\DataRepository")
 */
class Data
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
     * @ORM\Column(name="conso", type="bigint")
     */
    private $conso;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * Set conso
     *
     * @param integer $conso
     * @return Data
     */
    public function setConso($conso)
    {
        $this->conso = $conso;
    
        return $this;
    }

    /**
     * Get conso
     *
     * @return integer 
     */
    public function getConso()
    {
        return $this->conso;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Data
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
}
