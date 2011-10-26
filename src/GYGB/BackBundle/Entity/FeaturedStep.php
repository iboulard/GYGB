<?php

namespace GYGB\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GYGB\BackBundle\Entity\FeaturedStep
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GYGB\BackBundle\Entity\FeaturedStepRepository")
 */
class FeaturedStep
{

    public function __toString()
    {
        return $this->getStep() . ' featured on the '. $this->getType(). ' page';
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
    
    /** @ORM\ManyToOne(targetEntity="Step", inversedBy="features") */
    protected $step;

    
    public static function getTypes()
    {
        return array (
            'home' => 'home',
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
     * Set step
     *
     * @param GYGB\BackBundle\Entity\Step $step
     */
    public function setStep(\GYGB\BackBundle\Entity\Step $step)
    {
        $this->step = $step;
    }

    /**
     * Get step
     *
     * @return GYGB\BackBundle\Entity\Step 
     */
    public function getStep()
    {
        return $this->step;
    }
}