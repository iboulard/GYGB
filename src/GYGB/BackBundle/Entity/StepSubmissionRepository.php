<?php

namespace GYGB\BackBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * StepSubmissionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StepSubmissionRepository extends EntityRepository
{
    public function findAllApproved($em)
    {
        $query = $this->createQueryBuilder('ss')
                ->join("ss.step", "s")
                ->andWhere('s.approved = true')
                ->andWhere('ss.approved = true')
                ->andWhere('ss.spam = false')
                ->getQuery();
        
        return $query->getResult();
    }
    
    public function findAllApprovedAndFeatured($em)
    {
        $query = $this->createQueryBuilder('ss')
                ->join("ss.step", "s")
                ->andWhere('s.approved = true')
                ->andWhere('ss.approved = true')
                ->andWhere('ss.spam = false')
                ->andWhere('ss.featured = true')
                ->getQuery();
        
        return $query->getResult();
    }
    
    public function findApprovedByStep($em, $step)
    {
        $query = $this->createQueryBuilder('ss')
                ->join("ss.step", "s")
                ->andWhere('s.approved = true')
                ->andWhere('ss.approved = true')
                ->andWhere('ss.spam = false')
                ->andWhere('s.id = '.$step->getId())
                ->getQuery();
        
        return $query->getResult();
    }
    
}