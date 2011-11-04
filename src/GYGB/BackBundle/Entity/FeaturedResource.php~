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
        return $this->getResource() . ' featured on the '. $this->getType(). ' page';
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
    
    /** @ORM\ManyToOne(targetEntity="Resource", inversedBy="features") */
    protected $resource;

    
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
     * Set resource
     *
     * @param GYGB\BackBundle\Entity\Resource $resource
     */
    public function setResource(\GYGB\BackBundle\Entity\Resource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * Get resource
     *
     * @return GYGB\BackBundle\Entity\Resource
     */
    public function getResource()
    {
        return $this->resource;
    }
}