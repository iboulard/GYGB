<?php

namespace GYGB\BackBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * StepRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StepRepository extends EntityRepository
{

  public function getNumberOfSteps($em)
  {
    $query = $em->createQuery('SELECT SUM(s.count) FROM GYGBBackBundle:Step s');
    $count = $query->getSingleScalarResult();

    return $count;
  }

  public function getBasicSteps()
  {
    $steps = $this->findByIsBasic('1');

    $basicSteps = array();

    foreach($steps as $step)
    {
      $basicSteps[] = $step;
    }

    return $basicSteps;
  }

  public function findStepsFromTerms($terms, $em)
  {
    $query = $em->createQuery(
                    "SELECT s FROM GYGBBackBundle:Step s WHERE s.step LIKE '%" . $terms . "%'"
    );

    return $query->getResult();
  }

  public function findRecentlyUpdated($em)
  {
    $query = $em->createQuery(
                    "SELECT s, ss FROM GYGBBackBundle:Step s JOIN s.submissions ss"
    );

    return $query->getResult();
  }

  public function findByFiltersAndSorts($em, $category, $sort, $savings)
  {
    $query = $this->createQueryBuilder('s');
    
    if(isset($savings) && $savings != 'all')
    {
      $query->andWhere('s.savings = :savings');
      $query->setParameter('savings', $savings);
    }

    if(isset($category) && $category != 'all')
    {
      // categories are a space delimited string
      // add a "where category = x OR category = y"
      $categories = explode(' ', $category);
      $categoryWhere = '';
      
      $i = 0;
      foreach($categories as $c)
      {
        $categoryWhere .= 's.category = :category'.$i.' OR ';
        $query->setParameter('category'.$i, $c);
        
        $i++;
      }
      
      $categoryWhere = rtrim($categoryWhere, ' OR ');
      $query->andWhere($categoryWhere);   
    }
    
    if(isset($sort) && $sort == 'popular')
    {
      $query->orderBy('s.count', 'DESC');
    }
    else if(isset($sort) && $sort == 'recent')
    {
      $query->orderBy('s.step', 'DESC');
    }
    
    return $query->getQuery()->getResult();
  }

}