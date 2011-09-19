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
   * @ORM\Column(name="step", type="text")
   */
  private $step;
  /**
   * @var smallint $isBasic
   *
   * @ORM\Column(name="isBasic", type="boolean", nullable="true")
   */
  private $isBasic;
  /**
   * @var smallint $approved
   *
   * @ORM\Column(name="approved", type="boolean", nullable="true")
   */
  private $approved;
  /**
   * @var integer $savings
   *
   * @ORM\Column(name="savings", type="string", length="255", nullable="true")
   */
  private $savings;
  /**
   * @var integer $category
   *
   * @ORM\Column(name="category", type="string", length="255", nullable="true")
   */
  private $category;
  
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

  /**
   * Set isBasic
   *
   * @param boolean $isBasic
   */
  public function setIsBasic($isBasic)
  {
    $this->isBasic = $isBasic;
  }

  /**
   * Get isBasic
   *
   * @return boolean 
   */
  public function getIsBasic()
  {
    return $this->isBasic;
  }

  public function getAbbrvStep()
  {
    if($this->stepStartsWithI())
    {
      return substr($this->getStep(), 2);
    }
    else
    {
      return $this->getStep();
    }
  }

  public function stepStartsWithI()
  {
    return substr($this->getStep(), 0, 2) === 'I ';
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
    
    public function getCount()
    {
        return count($this->submissions);
/*        if($this->getApproved())
        {
            return count($this->submissions);        
        }
        else
        {
            return null;
        }
*/    }

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
}