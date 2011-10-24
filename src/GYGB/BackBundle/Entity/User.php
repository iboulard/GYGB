<?php
namespace GYGB\BackBundle\Entity;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="GYGB\BackBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    public function __toString()
    {
      return $this->name;
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /** @ORM\OneToMany(targetEntity="StepSubmission", mappedBy="user", cascade={"persist", "remove"}) */
    protected $stepSubmissions;
  
    /** @ORM\OneToMany(targetEntity="Commitment", mappedBy="user", cascade={"persist", "remove"}) */
    protected $commitments;
    
    
    public function __construct()
    {
        parent::__construct();
        // your own logic
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Add stepSubmissions
     *
     * @param GYGB\BackBundle\Entity\StepSubmission $stepSubmissions
     */
    public function addStepSubmission(\GYGB\BackBundle\Entity\StepSubmission $stepSubmissions)
    {
        $this->stepSubmissions[] = $stepSubmissions;
    }

    /**
     * Get stepSubmissions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getStepSubmissions()
    {
        return $this->stepSubmissions;
    }

    /**
     * Add commitments
     *
     * @param GYGB\BackBundle\Entity\Commitment $commitments
     */
    public function addCommitment(\GYGB\BackBundle\Entity\Commitment $commitments)
    {
        $this->commitments[] = $commitments;
    }

    /**
     * Get commitments
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCommitments()
    {
        return $this->commitments;
    }
}