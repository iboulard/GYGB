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

  public function stepListAction($category = 'all', $sort = 'popular', $savings = 'all', $terms = null, $id = null)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');

    if(isset($terms))
    {
      $steps = $stepRepository->findStepsFromTerms($terms, $em);
    }
   /* else if(isset($sort) && $sort == 'recent')
    {
      $steps = $stepRepository->findRecentlyUpdated($em);
    }*/
    else
    {
      $steps = $stepRepository->findByFiltersAndSorts($em, $category, $sort, $savings);
    }
    
    return $this->render('GYGBFrontBundle:Steps:_stepList.html.twig', array(
        'steps' => $steps,
        'category' => $category,
        'savings' => $savings,
        'sort' => $sort,
        'id' => $id
    ));
  }

  public function stepsAction($category = 'all', $sort = 'popular', $savings = 'all', $id = null)
  {
    $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
    $request = $this->getRequest();
    $categoryNames = array('food', 'transportation', 'energy', 'waste', 'general');
    $categoryIcons = array('food' => 'apple', 'transportation' => 'bicycle', 'energy' => 'battery', 'waste' => 'recycle-bin', 'general' => 'globe');
    
    
    $currentCategories = explode(' ', $category);
    
    print_r($currentCategories);
    
    
    
    // get step counts (total, and category totals)
    $categoryTotals = $this->getCategoryTotals();
    $totalSteps = $categoryTotals['all'];

    $stepSearchForm = $this->createFormBuilder()
            ->add('terms', 'text', array('label' => null, 'required' => false))
            ->getForm();
    
    
    if($request->getMethod() == 'POST')
    {
      $stepSearchForm->bindRequest($request);

      if($stepSearchForm->isValid())
      {
        $data = $stepSearchForm->getData();
        
        $terms = $data['terms'];
      }
    }
    else $terms = null;

    return $this->render('GYGBFrontBundle:Steps:steps.html.twig', array(
        'category' => $category,
        'categoryNames' => $categoryNames,
        'categoryIcons' => $categoryIcons,
        'currentCategories',
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
