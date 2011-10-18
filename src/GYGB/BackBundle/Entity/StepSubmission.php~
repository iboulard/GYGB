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
     * @ORM\Column(name="story", type="text", nullable="true")
     */
    private $story;
    /**
     * @var datetime $datetimeSubmitted
     *
     * @ORM\Column(name="datetimeSubmitted", type="datetime")
     */
    private $datetimeSubmitted;
    /** @ORM\ManyToOne(targetEntity="Step", inversedBy="StepSubmission") */
    protected $Step;

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

    /**
     * Set Step
     *
     * @param GYGB\BackBundle\Entity\Step $Step
     */
    public function setStep(\GYGB\BackBundle\Entity\Step $Step)
    {
        $this->Step = $Step;
    }

    /**
     * Get step
     *
     * @return GYGB\BackBundle\Entity\Step 
     */
    public function getStep()
    {
        return $this->Step;
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
}