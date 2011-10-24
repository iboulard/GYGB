<?php

namespace GYGB\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GYGB\BackBundle\Entity\StepSubmission
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GYGB\BackBundle\Entity\StepSubmissionRepository")
 */
class StepSubmission
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
     * @var integer $website
     *
     * @ORM\Column(name="website", type="string", length="255", nullable="true")
     */
    private $website;
    /**
     * @var integer $email
     *
     * @ORM\Column(name="email", type="string", length="255", nullable="true")
     */
    private $email;
    /**
     * @var text $story
     *
     * @ORM\Column(name="story", type="string", length=255, nullable="true")
     */
    private $story;
    /**
     * @var datetime $datetimeSubmitted
     *
     * @ORM\Column(name="datetimeSubmitted", type="datetime")
     */
    private $datetimeSubmitted;
    /** @ORM\ManyToOne(targetEntity="Step", inversedBy="stepSubmissions") */
    protected $step;
    
    /** @ORM\ManyToOne(targetEntity="User", inversedBy="stepSubmissions") */
    protected $user;

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
        if(!isset($this->name))
            return 'Anonymous';
        else
            return $this->name;
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

    public function __toString()
    {
        return $this->getName() . ' - ' . $this->getStep();
    }

    /**
     * Set website
     *
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set story
     *
     * @param text $story
     */
    public function setStory($story)
    {
        $this->story = $story;
    }

    /**
     * Get story
     *
     * @return text 
     */
    public function getStory()
    {
        return $this->story;
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

    public function __construct()
    {
        $this->Users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    

    
    public function getAbbreviatedStory()
    {
        if($this->storyCanBeAbbreviated())
        {
            return substr($this->getStory(), 2);
        }
        else
        {
            return $this->getStory();
        }
    }

    public function storyCanBeAbbreviated()
    {
        if($this->storyStartsWithI() && !$this->storyContainsPronoun())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function storyStartsWithI()
    {
        return substr($this->getStory(), 0, 2) === 'I ';
    }

    public function storyContainsPronoun()
    {
        return strstr($this->getStory(), " my ");
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