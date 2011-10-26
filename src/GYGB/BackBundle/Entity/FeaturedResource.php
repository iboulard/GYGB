<?php

namespace GYGB\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GYGB\BackBundle\Entity\FeaturedResource
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GYGB\BackBundle\Entity\FeaturedResourceRepository")
 */
class FeaturedResource
{

    public function __toString()
    {
        return $this->getOrganization() . ' featured on the '. $this->getType(). ' page';
    }

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;
    
    /** @ORM\ManyToOne(targetEntity="Organization", inversedBy="features") */
    protected $organization;

    
    public static function getTypes()
    {
        return array (
            'home' => 'home',
            'take a step' => 'take a step'
        );
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
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set organization
     *
     * @param GYGB\BackBundle\Entity\Organization $organization
     */
    public function setOrganization(\GYGB\BackBundle\Entity\Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * Get organization
     *
     * @return GYGB\BackBundle\Entity\Organization 
     */
    public function getOrganization()
    {
        return $this->organization;
    }
}