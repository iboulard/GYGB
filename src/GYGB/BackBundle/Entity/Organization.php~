<?php

namespace GYGB\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GYGB\BackBundle\Entity\Organization
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="GYGB\BackBundle\Entity\OrganizationRepository")
 */
class Organization
{

    public function __toString()
    {
        return $this->getName();
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text", nullable="true")
     */
    private $description;
    /**
     * @var string $website
     *
     * @ORM\Column(name="website", type="string", length=400, nullable="true")
     */
    private $website;
    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable="true")
     */
    private $email;
    /**
     * @var string $logo
     *
     * @ORM\Column(name="logo", type="string", length=400, nullable="true")
     */
    private $logo;
    
    protected $file;
    
    /**
     * @var string $category
     *
     * @ORM\Column(name="category", type="string", length=255)
     */
    private $category;
    /**
     * @var string $width
     *
     * @ORM\Column(name="width", type="string", length=255, nullable="true")
     */
    private $width;
   
    /**
     * @var boolean $approved
     *
     * @ORM\Column(name="approved", type="boolean")
     */
    private $approved;
    /**
     * @var boolean $featured
     *
     * @ORM\Column(name="featured", type="boolean")
     */
    private $featured;

   /**
     * @ORM\ManyToMany(targetEntity="Step", mappedBy="featuredOrganizations")
    */
    protected $featuredSteps;

    /**
     * @ORM\prePersist
     */
    public function setDefaultValues()
    {
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
     * Set logo
     *
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
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
        return $this->category;
    }

    /**
     * Set width
     *
     * @param string $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * Get width
     *
     * @return string 
     */
    public function getWidth()
    {
        return $this->width;
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

    public function getAbsolutePath()
    {
        return null === $this->logo ? null : $this->getUploadRootDir() . '/' . $this->logo;
    }

    public function getWebPath()
    {
        return null === $this->logo ? null : $this->getUploadDir() . '/' . $this->logo;
    }

    protected function getUploadRootDir($basepath)
    {
        // the absolute directory path where uploaded documents should be saved
        return $basepath . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'files/logos';
    }

    public function upload($basepath)
    {
        // the file property can be empty if the field is not required
        if(null === $this->file)
        {
            return;
        }

        if(null === $basepath)
        {
            return;
        }

        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the target filename to move to
        $this->file->move($this->getUploadRootDir($basepath), $this->file->getClientOriginalName());

        // set the path property to the filename where you'ved saved the file
        $this->setLogo($this->file->getClientOriginalName());

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    public function __construct()
    {
        $this->featuredSteps = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add featuredSteps
     *
     * @param GYGB\BackBundle\Entity\Step $featuredSteps
     */
    public function addStep(\GYGB\BackBundle\Entity\Step $featuredSteps)
    {
        $this->featuredSteps[] = $featuredSteps;
    }

    /**
     * Get featuredSteps
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFeaturedSteps()
    {
        return $this->featuredSteps;
    }
}