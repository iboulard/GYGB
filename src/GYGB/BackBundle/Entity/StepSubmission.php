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
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=255, nullable="true")
     */
    private $type;
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
     * @var text $text
     *
     * @ORM\Column(name="text", type="string", length=255, nullable="true")
     */
    private $text;
    /**
     * @var integer $latitude
     *
     * @ORM\Column(name="latitude", type="string", length="255", nullable="true")
     */
    private $latitude;
    /**
     * @var integer $longitude
     *
     * @ORM\Column(name="longitude", type="string", length="255", nullable="true")
     */
    private $longitude;
    /**
    * @var smallint $approved
    *
    * @ORM\Column(name="approved", type="boolean", nullable="true")
    */
    private $approved;
    /**
    * @var smallint $spam
    *
    * @ORM\Column(name="spam", type="boolean", nullable="true")
    */
    private $spam;
    /**
    * @var smallint $featured
    *
    * @ORM\Column(name="featured", type="boolean", nullable="true")
    */
    private $featured;    
    
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

    protected static $typeChoices = array (
        'step' => 'step',
        'commitment' => 'commitment'
    );

    public static function getTypeChoices() {
        return self::$typeChoices;
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
    
    public function getNameForDisplay()
    {
      if($this->getUser())
      {
          return $this->getUser()->getName();
      }    
      else if(isset($this->name))
      {
        return $this->name;
      }
      else
      {
        return 'Anonymous';          
      }
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
        if($this->getStep())
            return $this->getName() . ' - ' . $this->getStep();
        else
            return false;
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
        $this->approved = false;
        $this->spam = false;
        $this->featured = false;
    }

    

    
    public function getAbbreviatedText()
    {
        if($this->textCanBeAbbreviated())
        {
            return substr($this->getText(), 2);
        }
        else
        {
            return $this->getText();
        }
    }

    public function textCanBeAbbreviated()
    {
        if($this->textStartsWithI() && !$this->textContainsPronoun())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function textStartsWithI()
    {
        return substr($this->getText(), 0, 2) === 'I ';
    }

    public function textContainsPronoun()
    {
        return strstr($this->getText(), " my ")
            || strstr($this->getText(), " I ")
            || strstr($this->getText(), " I'")
            || strstr($this->getText(), " our ")
            || strstr($this->getText(), " we ");
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

    /**
     * Set latitude
     *
     * @param string $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }


    /**
     * Set approved
     *
     * @param boolean $approved
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;
    }

    /**
     * Get approved
     *
     * @return boolean 
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set spam
     *
     * @param boolean $spam
     */
    public function setSpam($spam)
    {
        $this->spam = $spam;
    }

    /**
     * Get spam
     *
     * @return boolean 
     */
    public function getSpam()
    {
        return $this->spam;
    }

    /**
     * Set featured
     *
     * @param boolean $featured
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;
    }

    /**
     * Get featured
     *
     * @return boolean 
     */
    public function getFeatured()
    {
        return $this->featured;
    }

    /**
     * Set text
     *
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
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
}