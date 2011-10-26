<?php

namespace GYGB\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GYGB\BackBundle\Entity\Commitment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GYGB\BackBundle\Entity\CommitmentRepository")
 */
class Commitment
{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable="true")
     */
    private $name;
    /**
     * @var integer $email
     *
     * @ORM\Column(name="email", type="string", length="255", nullable="true")
     */
    private $email;
    /**
     * @var integer $commitment
     *
     * @ORM\Column(name="commitment", type="string", length="255", nullable="true")
     */
    private $commitment;
    /**
     * @var datetime $datetimeSubmitted
     *
     * @ORM\Column(name="datetimeSubmitted", type="datetime")
     */
    private $datetimeSubmitted;
    
    /** @ORM\ManyToOne(targetEntity="Step", inversedBy="commitments") */
    protected $step;

    /** @ORM\ManyToOne(targetEntity="User", inversedBy="commitments") */
    protected $user;

    public function __construct()
    {
        $this->Users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set datetimeSubmitted
     *
     * @param datetime $datetimeSubmitted
     */
    public function setDatetimeSubmitted($datetimeSubmitted)
    {
        $this->datetimeSubmitted = $datetimeSubmitted;
    }

    /**
     * Get datetimeSubmitted
     *
     * @return datetime 
     */
    public function getDatetimeSubmitted()
    {
        return $this->datetimeSubmitted;
    }

    

    
    
    
    public function getAbbreviatedCommitment()
    {
        if($this->commitmentCanBeAbbreviated())
        {
            return substr($this->getCommitment(), 2);
        }
        else
        {
            return $this->getCommitment();
        }
    }

    public function commitmentCanBeAbbreviated()
    {
        if($this->commitmentStartsWithI() && !$this->commitmentContainsPronoun())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function commitmentStartsWithI()
    {
        return substr($this->getCommitment(), 0, 2) === 'I ';
    }

    public function commitmentContainsPronoun()
    {
        return strstr($this->getCommitment(), " my ")
                || strstr($this->getCommitment(), " their ")
                || strstr($this->getCommitment(), " we ")
                || strstr($this->getCommitment(), " our ")
                || strstr($this->getCommitment(), " we ");
    }


    /**
     * Set commitment
     *
     * @param string $commitment
     */
    public function setCommitment($commitment)
    {
        $this->commitment = $commitment;
    }

    /**
     * Get commitment
     *
     * @return string 
     */
    public function getCommitment()
    {
        return $this->commitment;
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

    /**
     * Set user
     *
     * @param GYGB\BackBundle\Entity\User $user
     */
    public function setUser(\GYGB\BackBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return GYGB\BackBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}