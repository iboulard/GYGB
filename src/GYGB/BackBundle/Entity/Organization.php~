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
     * @var boolean $sponsor
     *
     * @ORM\Column(name="sponsor", type="boolean")
     */
    private $sponsor;
    /**
     * @var boolean $founder
     *
     * @ORM\Column(name="founder", type="boolean")
     */
    private $founder;
    /**
     * @var boolean $organization
     *
     * @ORM\Column(name="organization", type="boolean")
     */
    private $organization;
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
     * Set sponsor
     *
     * @param boolean $sponsor
     */
    public function setSponsor($sponsor)
    {
        $this->sponsor = $sponsor;
    }

    /**
     * Get sponsor
     *
     * @return boolean 
     */
    public function getSponsor()
    {
        return $this->sponsor;
    }

    /**
     * Set founder
     *
     * @param boolean $founder
     */
    public function setFounder($founder)
    {
        $this->founder = $founder;
    }

    /**
     * Get founder
     *
     * @return boolean 
     */
    public function getFounder()
    {
        return $this->founder;
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
}