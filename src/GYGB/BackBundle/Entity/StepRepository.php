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

    public function findCategoryStepTotals()
    {
        $allSteps = $this->findBy(array('approved' => true));
        $categoryTotals = array('all' => 0, 'transportation' => 0, 'food' => 0, 'waste' => 0, 'energy' => 0, 'general' => 0);
        $totalSteps = 0;
        foreach($allSteps as $step)
        {
            $categoryTotals['all'] += 1;
            $categoryTotals[$step->getCategory()] += 1;
        }

        return $categoryTotals;
    }

    public function findCategoryStepSubmissionTotals()
    {
        $allSteps = $this->findBy(array('approved' => true));
        $categoryTotals = array('all' => 0, 'transportation' => 0, 'food' => 0, 'waste' => 0, 'energy' => 0, 'general' => 0);
        $totalSteps = 0;
        foreach($allSteps as $step)
        {
            $categoryTotals['all'] += $step->getCount();
            $categoryTotals[$step->getCategory()] += $step->getCount();
        }

        return $categoryTotals;
    }

    public function findByTerms($em, $terms)
    {
        $query = $this->createQueryBuilder('s');
        $query->andWhere('s.actionTitle LIKE :title');
        $query->setParameter('title', '%' . $terms . '%');

        return $query->getQuery()->getResult();
    }

    public function findByFiltersAndSorts($em, $category, $sort, $savings, $type)
    {
        $query = $this->createQueryBuilder('s');

        if(isset($savings) && $savings != 'all')
        {
            $savings = explode(' ', $savings);
            $savingsWhere = '';
            $i = 0;
            foreach($savings as $s)
            {
                $savingsWhere .= 's.savings = :savings' . $i . ' OR ';
                $query->setParameter('savings' . $i, $s);

                $i++;
            }

            $savingsWhere = rtrim($savingsWhere, ' OR ');
            $query->andWhere($savingsWhere);
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
                $categoryWhere .= 's.category = :category' . $i . ' OR ';
                $query->setParameter('category' . $i, $c);

                $i++;
            }

            $categoryWhere = rtrim($categoryWhere, ' OR ');
            $query->andWhere($categoryWhere);
        }

        if(isset($type) && $type != 'all')
        {
            $type = explode(' ', $type);
            $typeWhere = '';
            $i = 0;
            foreach($type as $t)
            {
                $typeWhere .= 's.:type = 1' . $i . ' OR ';
                $query->setParameter('type' . $i, $t);

                $i++;
            }

            $typeWhere = rtrim($typeWhere, ' OR ');
            $query->andWhere($typeWhere);
        }

        if(isset($sort) && $sort == 'popular')
        {
            $query->join('s.submissions', 'ss');
            $query->groupBy('s.id');
            $query->orderBy('s.count', 'DESC');
        }
        else if(isset($sort) && $sort == 'recent')
        {
            $query->join('s.submissions', 'ss');
            $query->orderBy('ss.datetimeSubmitted', 'DESC');
        }

        $query->andWhere('s.approved = true');

        return $query->getQuery()->getResult();
    }
    
    public function findRecentlySubmitted($em)
    {
        $query = $this->createQueryBuilder('s');
        $query->join('s.submissions', 'ss');
        $query->orderBy('ss.datetimeSubmitted', 'DESC');
        $query->andWhere('s.approved = true');
        $resultsA = $query->getQuery()->getResult();
        
        $queryB = $this->createQueryBuilder('sb');
        $queryB->andWhere('sb.count = 0');
        $resultsB = $queryB->getQuery()->getResult();
        
        return array_merge($resultsA, $resultsB);
    }

    
}