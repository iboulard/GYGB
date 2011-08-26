<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StepsController extends Controller
{

  public function stepsTakenAction($extendLayout = false)
  {
    $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
    $em = $this->getDoctrine()->getEntityManager();

    $stepCount = (string) $stepRepository->getNumberOfSteps($em);
    $stepDigits = array();

    for($i = 0; $i < strlen($stepCount); $i++)
    {
      $stepDigits[] = $stepCount[$i];
    }

    if($extendLayout)
    {
      return $this->render('GYGBFrontBundle:Steps:stepsTaken.html.twig', array(
          'stepDigits' => $stepDigits,
      ));
    }
    else
    {
      return $this->render('GYGBFrontBundle:Steps:_stepsTaken.html.twig', array(
          'stepDigits' => $stepDigits,
      ));
    }
  }

  public function recentStepsAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $stepSubmissionRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');
    $recentSteps = $stepSubmissionRepository->getRecentSteps('12', $em);

    return $this->render('GYGBFrontBundle:Steps:_recentSteps.html.twig', array(
        'recentSteps' => $recentSteps
    ));
  }

  public function categoryBoxesAction()
  {
    $categoryTotals = $this->getCategoryTotals();

    return $this->render('GYGBFrontBundle:Steps:_categoryBoxes.html.twig', array(
        'categoryTotals' => $categoryTotals
    ));
  }

  public function stepListAction($categories = 'all', $sort = 'popular', $savings = 'all', $terms = null, $id = null)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');

    if(isset($terms))
    {
      $steps = $stepRepository->findStepsFromTerms($terms, $em);
    }
    /*else if(isset($sort) && $sort == 'recent')
    {
      $steps = $stepRepository->findRecentlyUpdated($em);
    }*/
    else
    {
      $steps = $stepRepository->findByFiltersAndSorts($em, $categories, $sort, $savings);
    }
    
    return $this->render('GYGBFrontBundle:Steps:_stepList.html.twig', array(
        'steps' => $steps,
        'categories' => $categories,
        'savings' => $savings,
        'sort' => $sort,
        'id' => $id
    ));
  }

  
  public function getCurrentCategoryArray($categories)
  {
    $currentCategories = array();
    
    foreach(array_unique(explode(' ', $categories)) as $currentCategory)
    {
      $currentCategories[$currentCategory] = true;
    }
    
    return $currentCategories;
  }
  
  public function getCategoryLinksArray($currentCategories, $categoryNames)
  {
    $categoryLinks = array();
    
    $baseCurrentCategoryString = "";
    foreach($currentCategories as $category => $bool)
    {
      if($category != "all") $baseCurrentCategoryString .= $category." ";
    }
    
    foreach($categoryNames as $c)
    {
      $currentCategoryString = $baseCurrentCategoryString;
      $cLink = $baseCurrentCategoryString;
      
      if(isset($currentCategories[$c]))
      {
        $currentCategoryString = str_replace($c, "", $currentCategoryString);
        $currentCategoryString = str_replace("  ", " ", $currentCategoryString);
      }
      else
      {
        $currentCategoryString .= $c." ";
      }
      
      if(trim($currentCategoryString) == "") $categoryLinks[$c] = 'all';
      else $categoryLinks[$c] = trim(rtrim($currentCategoryString, ' '));
    }

    return $categoryLinks;
  }
  
  
  public function stepsAction($categories = 'all', $sort = 'popular', $savings = 'all', $id = null)
  {
    $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
    $request = $this->getRequest();
    $categoryNames = array('food', 'transportation', 'energy', 'waste', 'general');
    $categoryIcons = array('food' => 'apple', 'transportation' => 'bicycle', 'energy' => 'battery', 'waste' => 'recycle-bin', 'general' => 'globe');
   
    $currentCategories = $this->getCurrentCategoryArray($categories);
    $categoryLinks = $this->getCategoryLinksArray($currentCategories, $categoryNames);
    
    // get step counts (total, and category totals)
    $categoryTotals = $this->getCategoryTotals();
    $totalSteps = $categoryTotals['all'];

    
    
    // build Search form
    $stepSearchForm = $this->createFormBuilder()
            ->add('terms', 'text', array('label' => null, 'required' => false))
            ->getForm();
    
    
    // process Search form
    if($request->getMethod() == 'POST')
    {
      $stepSearchForm->bindRequest($request);

      if($stepSearchForm->isValid())
      {
        $data = $stepSearchForm->getData();
        
        $terms = $data['terms'];
        
        $SearchTermRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:SearchTerm');
        $em = $this->getDoctrine()->getEntityManager();
        
        $dbTerm = $SearchTermRepository->findOneByTerm($terms);
        if($dbTerm)
        {
          $dbTerm->setCount($dbTerm->getCount() + 1);
        }
        else
        {
          $dbTerm = new \GYGB\BackBundle\Entity\SearchTerm();
          $dbTerm->setCount(1);
          $dbTerm->setTerm($terms);
        }
        $dbTerm->setDatetimeLastSearched(new \Datetime());
        
        $em->persist($dbTerm);
        $em->flush();
      }
    }
    else
    {
      $terms = null;
    }
      
    return $this->render('GYGBFrontBundle:Steps:steps.html.twig', array(
        'categories' => $categories,
        'categoryNames' => $categoryNames,
        'categoryIcons' => $categoryIcons,
        'currentCategories' => $currentCategories,
        'categoryLinks' => $categoryLinks,
        'sort' => $sort,
        'savings' => $savings,
        'totalSteps' => $totalSteps,
        'categoryTotals' => $categoryTotals,
        'stepSearchForm' => $stepSearchForm->createView(),
        'terms' => $terms,
        'id' => $id
    ));
  }

  public function getCategoryTotals()
  {
    $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');

    $allSteps = $stepRepository->findAll();
    $categoryTotals = array('all' => 0, 'transportation' => 0, 'food' => 0, 'waste' => 0, 'energy' => 0, 'general' => 0);
    $totalSteps = 0;
    foreach($allSteps as $step)
    {
      $categoryTotals['all'] += $step->getCount();
      $categoryTotals[$step->getCategory()] += $step->getCount();
    }

    return $categoryTotals;
  }

}
