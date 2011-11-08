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
   * @var text $story
   *
   * @ORM\Column(name="story", type="string", length="255", nullable="true")
   */
  private $story;
  /**
   * @var text $title
   *
   * @ORM\Column(name="title", type="string", length="255", nullable="true")
   */
  private $title;
  /**
   * @var text $commitment
   *
   * @ORM\Column(name="commitment", type="string", length="255", nullable="true")
   */
  private $commitment;  
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
   * @var string $stepCount
   *
   * @ORM\Column(name="stepCount", type="integer", nullable="true")
   */
  private $stepCount;
  /**
   * @var string $commitmentCount
   *
   * @ORM\Column(name="commitmentCount", type="integer", nullable="true")
   */
  private $commitmentCount;
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
  
  /** @ORM\OneToMany(targetEntity="StepSubmission", mappedBy="step", cascade={"persist", "remove"})
   * @ORM\OrderBy({"datetimeSubmitted" = "DESC"})
   */
  protected $stepSubmissions;
  
  /** @ORM\OneToMany(targetEntity="Commitment", mappedBy="step", cascade={"persist", "remove"}) 
   * @ORM\OrderBy({"datetimeSubmitted" = "DESC"})
   */
   protected $commitments;
  
    /**
     * @ORM\ManyToMany(targetEntity="Resource", inversedBy="featuredSteps")
     * @ORM\JoinTable(name="StepsToResources")
     */
    protected $featuredResources;
 
    /** @ORM\OneToMany(targetEntity="FeaturedStep", mappedBy="step", cascade={"persist", "remove"})
   */
  protected $features;
    /** @ORM\OneToOne(targetEntity="StepSubmission") */
    private $parentSubmission;
   
    /**
     * @ORM\prePersist
     */
    public function setDefaultValues()
    {
        if(!$this->category) $this->category = 'general';
        if(!$this->stepCount) $this->stepCount = '0';
        if(!$this->commitmentCount) $this->commitmentCount = '0';
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
    return $this->getTitle();
  }

    public function __construct()
    {
        $this->submissions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set stepCount
     *
     * @param integer $stepCount
     */
    public function setStepCount($stepCount)
    {
        $this->stepCount = $stepCount;
    }

    /**
     * Get stepCount
     *
     * @return integer 
     */
    public function getStepCount()
    {
        return $this->stepCount;
    }

    /**
     * Set commitmentCount
     *
     * @param integer $commitmentCount
     */
    public function setCommitmentCount($commitmentCount)
    {
        $this->commitmentCount = $commitmentCount;
    }

    /**
     * Get commitmentCount
     *
     * @return integer 
     */
    public function getCommitmentCount()
    {
        return $this->commitmentCount;
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
     * Set title
     *
     * @param text $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return text 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set commitment
     *
     * @param text $commitment
     */
    public function setCommitment($commitment)
    {
        $this->commitment = $commitment;
    }

    /**
     * Get commitment
     *
     * @return text 
     */
    public function getCommitment()
    {
        return $this->commitment;
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

    
    
    /**
     * Add featuredResourcess
     *
     * @param GYGB\BackBundle\Entity\Resource $featuredResources
     */
    public function addResource(\GYGB\BackBundle\Entity\Resource $featuredResources)
    {
        $this->featuredResources[] = $featuredResources;
    }

    

    /**
     * Add features
     *
     * @param GYGB\BackBundle\Entity\FeaturedStep $features
     */
    public function addFeaturedStep(\GYGB\BackBundle\Entity\FeaturedStep $features)
    {
        $this->features[] = $features;
    }

    /**
     * Get features
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * Get featuredResources
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFeaturedResources()
    {
        return $this->featuredResources;
    }
    
    /**
     * Set featuredResources
     *
     * @param GYGB\BackBundle\Entity\Resource $resources
     */
    public function setFeaturedResources($resources)
    {
        $this->featuredResources = $resources;
    }

    /**
     * Set parentSubmission
     *
     * @param GYGB\BackBundle\Entity\StepSubmission $parentSubmission
     */
    public function setParentSubmission(\GYGB\BackBundle\Entity\StepSubmission $parentSubmission)
    {
        $this->parentSubmission = $parentSubmission;
    }

    /**
     * Get parentSubmission
     *
     * @return GYGB\BackBundle\Entity\StepSubmission 
     */
    public function getParentSubmission()
    {
        return $this->parentSubmission;
    }
}