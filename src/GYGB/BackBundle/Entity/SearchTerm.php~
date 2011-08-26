<?php

namespace GYGB\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GYGB\BackBundle\Entity\SearchTerm
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SearchTerm
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
     * @var string $term
     *
     * @ORM\Column(name="term", type="string", length=255)
     */
    private $term;

    /**
     * @var datetime $datetimeLastSearched
     *
     * @ORM\Column(name="datetimeLastSearched", type="datetime")
     */
    private $datetimeLastSearched;

    /**
     * @var integer $count
     *
     * @ORM\Column(name="count", type="integer")
     */
    private $count;


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
     * Set term
     *
     * @param string $term
     */
    public function setTerm($term)
    {
        $this->term = $term;
    }

    /**
     * Get term
     *
     * @return string 
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Set datetimeLastSearched
     *
     * @param datetime $datetimeLastSearched
     */
    public function setDatetimeLastSearched($datetimeLastSearched)
    {
        $this->datetimeLastSearched = $datetimeLastSearched;
    }

    /**
     * Get datetimeLastSearched
     *
     * @return datetime 
     */
    public function getDatetimeLastSearched()
    {
        return $this->datetimeLastSearched;
    }

    /**
     * Set count
     *
     * @param integer $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }
}