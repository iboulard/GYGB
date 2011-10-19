<?php

namespace GYGB\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GYGB\BackBundle\Entity\Step
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GYGB\BackBundle\Entity\StepRepository") @ORM\HasLifeCycleCallbacks
 */
class Step
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
   * @var text $step
   *
   * @ORM\Column(name="step", type="text", nullable="true")
   */
  private $step;
  /**
   * @var text $actionTitle
   *
   * @ORM\Column(name="actionTitle", type="text")
   */
  private $actionTitle;
  /**
   * @var text $description
   *
   * @ORM\Column(name="description", type="text", nullable="true")
   */
  private $description;
  /**
   * @var smallint $approved
   *
   * @ORM\Column(name="approved", type="boolean", nullable="true")
   */
  private $approved;
  /**
   * @var string $savings
   *
   * @ORM\Column(name="savings", type="string", length="255", nullable="true")
   */
  private $savings;
  /**
   * @var string $category
   *
   * @ORM\Column(name="category", type="string", length="255", nullable="true")
   */
  private $category;
  /**
   * @var string $count
   *
   * @ORM\Column(name="count", type="integer")
   */
  private $count;
  /**
   * @var smallint $individual
   *
   * @ORM\Column(name="individual", type="boolean", nullable="true")
   */
  private $individual;     
  /**
   * @var smallint $organization
   *
   * @ORM\Column(name="organization", type="boolean", nullable="true")
   */
  private $organization;     
  /**
   * @var smallint $renter
   *
   * @ORM\Column(name="renter", type="boolean", nullable="true")
   */
  private $renter;     
  /**
   * @var smallint $landlord
   *
   * @ORM\Column(name="landlord", type="boolean", nullable="true")
   */
  private $landlord;     
  /**
   * @var smallint $homeowner
   *
   * @ORM\Column(name="homeowner", type="boolean", nullable="true")
   */
  private $homeowner;     
  /**
   * @var smallint $student
   *
   * @ORM\Column(name="student", type="boolean", nullable="true")
   */
  private $student;     
  /**
   * @var string $featuredOrganization
   *
   * @ORM\Column(name="featuredOrganization", type="integer", nullable="true")
   */
  private $featuredOrganization;
  
  /** @ORM\OneToMany(targetEntity="StepSubmission", mappedBy="Step", cascade={"persist", "remove"}) */
  protected $submissions;
  
  function onPrePersist()
  {
    $this->category = 'general';
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
   * Set step
   *
   * @param text $step
   */
  public function setStep($step)
  {
    $this->step = $step;
  }

  /**
   * Get step
   *
   * @return text 
   */
  public function getStep()
  {
    return $this->step;
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
   * Add submissions
   *
   * @param GYGB\BackBundle\Entity\StepSubmission $submissions
   */
  public function addSubmissions(\GYGB\BackBundle\Entity\StepSubmission $submissions)
  {
    $this->submissions[] = $submissions;
  }

  /**
   * Get submissions
   *
   * @return Doctrine\Common\Collections\Collection 
   */
  public function getSubmissions()
  {
    return $this->submissions;
  }
  
  public function getAbbrvStep()
  {
    if($this->stepIsAbbreviated())
    {
      return substr($this->getStep(), 2);
    }
    else
    {
      return $this->getStep();
    }
  }

  public function stepIsAbbreviated()
  {
    if($this->stepStartsWithI() && !$this->stepContainsPronoun())
    {
        return true;
    }
    else
    {
        return false;
    }
  }
  
  public function stepStartsWithI()
  {
    return substr($this->getStep(), 0, 2) === 'I ';
  }
  
  public function stepContainsPronoun()
  {
      return strstr($this->getStep(), " my ");
  }

  /**
   * Set category
   *
   * @param string $category
   */
  public function setCategory($category)
  {
    $this->category = $category;
  }

  /**
   * Get category
   *
   * @return string 
   */
  public function getCategory()
  {
    if(!isset($this->category))
      return 'general';
    else
      return $this->category;
  }

  /**
   * Set savings
   *
   * @param string $savings
   */
  public function setSavings($savings)
  {
    $this->savings = $savings;
  }

  /**
   * Get savings
   *
   * @return string 
   */
  public function getSavings()
  {
    return $this->savings;
  }

  public function getSavingsLabel()
  {
    switch($this->getSavings())
    {
      case 'low':
        return '$';
      case 'medium':
        return '$$';
      case 'high';
        return '$$$';
    }

    return null;
  }

  public static function getCategoryChoices()
  {
    return array(
        'general' => 'General',
        'food' => 'Food',
        'energy' => 'Energy',
        'waste' => 'Waste',
        'transportation' => 'Transportation'
    );
  }

  public static function getSavingsChoices()
  {
    return array(
        'low' => 'Low ($)',
        'medium' => 'Medium ($$)',
        'high' => 'High ($$$)',
    );
  }
  
  public function __toString()
  {
    return $this->getStep();
  }

    public function __construct()
    {
        $this->submissions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add submissions
     *
     * @param GYGB\BackBundle\Entity\StepSubmission $submissions
     */
    public function addStepSubmission(\GYGB\BackBundle\Entity\StepSubmission $submissions)
    {
        $this->submissions[] = $submissions;
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
     * Set count
     *
     * @param string $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * Get count
     *
     * @return string 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    

    /**
     * Set actionTitle
     *
     * @param text $actionTitle
     */
    public function setActionTitle($actionTitle)
    {
        $this->actionTitle = $actionTitle;
    }

    /**
     * Get actionTitle
     *
     * @return text 
     */
    public function getActionTitle()
    {
        return $this->actionTitle;
    }

    /**
     * Set individual
     *
     * @param boolean $individual
     */
    public function setIndividual($individual)
    {
        $this->individual = $individual;
    }

    /**
     * Get individual
     *
     * @return boolean 
     */
    public function getIndividual()
    {
        return $this->individual;
    }

    /**
     * Set organization
     *
     * @param boolean $organization
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;
    }

    /**
     * Get organization
     *
     * @return boolean 
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Set renter
     *
     * @param boolean $renter
     */
    public function setRenter($renter)
    {
        $this->renter = $renter;
    }

    /**
     * Get renter
     *
     * @return boolean 
     */
    public function getRenter()
    {
        return $this->renter;
    }

    /**
     * Set landlord
     *
     * @param boolean $landlord
     */
    public function setLandlord($landlord)
    {
        $this->landlord = $landlord;
    }

    /**
     * Get landlord
     *
     * @return boolean 
     */
    public function getLandlord()
    {
        return $this->landlord;
    }

    /**
     * Set homeowner
     *
     * @param boolean $homeowner
     */
    public function setHomeowner($homeowner)
    {
        $this->homeowner = $homeowner;
    }

    /**
     * Get homeowner
     *
     * @return boolean 
     */
    public function getHomeowner()
    {
        return $this->homeowner;
    }

    /**
     * Set student
     *
     * @param boolean $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }

    /**
     * Get student
     *
     * @return boolean 
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set featuredOrganization
     *
     * @param integer $featuredOrganization
     */
    public function setFeaturedOrganization($featuredOrganization)
    {
        $this->featuredOrganization = $featuredOrganization;
    }

    /**
     * Get featuredOrganization
     *
     * @return integer 
     */
    public function getFeaturedOrganization()
    {
        return $this->featuredOrganization;
    }
}