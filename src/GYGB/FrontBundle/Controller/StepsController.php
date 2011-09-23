<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StepsController extends Controller
{

    public function stepsAction($categories = 'all', $sort = 'recent', $savings = 'all', $id = null)
    {
        $request = $this->getRequest();

        $terms = null;

        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');

        $categoryNames = array('food', 'transportation', 'energy', 'waste', 'general');
        $categoryIcons = array('food' => 'apple', 'transportation' => 'bicycle', 'energy' => 'battery', 'waste' => 'recycle-bin', 'general' => 'globe');
        $selectedCategoryFilters = $this->getSelectedCategoryFiltersArray($categories);
        $categoryFilterHREFs = $this->getCategoryFilterHREFsArray($selectedCategoryFilters, $categoryNames);
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

        if(isset($id))
        {
            $idStep = $stepRepository->findOneBy(array('id' => $id));
            if(!$idStep) throw new NotFoundHttpException("We can't find this step!");
            $idCategory = array($idStep->getCategory() => true);
        }
        else
        {
            $idCategory = array();
        }

        return $this->render('GYGBFrontBundle:Steps:steps.html.twig', array(
            'categories' => $categories,
            'categoryNames' => $categoryNames,
            'categoryIcons' => $categoryIcons,
            'selectedCategoryFilters' => $selectedCategoryFilters,
            'categoryFilterHREFs' => $categoryFilterHREFs,
            'sort' => $sort,
            'savings' => $savings,
            'totalSteps' => $totalSteps,
            'categoryTotals' => $categoryTotals,
            'stepSearchForm' => $stepSearchForm->createView(),
            'terms' => $terms,
            'id' => $id,
            'onStepsPage' => true,
            'idCategory' => $idCategory
        ));
    }

    public function allStepListAction($categories = 'all', $sort = 'popular', $savings = 'all', $terms = null, $id = null)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');

        if(isset($terms))
        {
            $steps = $stepRepository->findStepsFromTerms($terms, $em);
        }
        else
        {
            $steps = $stepRepository->findByFiltersAndSorts($em, $categories, $sort, $savings);
        }

        if(count($steps) == 1)
        {
            $stepNoun = "step";
            $resultNoun = "result";
        }
        else
        {
            $stepNoun = "steps";
            $resultNoun = "results";
        }

        return $this->render('GYGBFrontBundle:Steps:_allStepList.html.twig', array(
            'steps' => $steps,
            'categories' => $categories,
            'savings' => $savings,
            'sort' => $sort,
            'id' => $id,
            'terms' => $terms,
            'resultNoun' => $resultNoun,
            'stepNoun' => $stepNoun,
        ));
    }

    public function stepDetailsAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        $stepSubmission = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');

        $step = $stepRepository->findOneBy(array('id' => $id));
        
        if(!$step)
        {
            throw new NotFoundHttpException('We can\'t find this step!');
        }

        return $this->render('GYGBFrontBundle:Steps:_stepDetails.html.twig', array(
            'step' => $step
        ));
    }
    
    
    public function organizationAdsAction($selectedCategoryFilters)
    {
        $organizationRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Organization');
        $organizationAds = $organizationRepository->getCategoryAds($selectedCategoryFilters);

        return $this->render('GYGBFrontBundle:Steps:_organizationAds.html.twig', array(
            'organizationAds' => $organizationAds
        ));
    }

    public function getSelectedCategoryFiltersArray($categories)
    {
        $selectedCategoryFilters = array();

        foreach(array_unique(explode(' ', $categories)) as $currentCategory)
        {
            $selectedCategoryFilters[$currentCategory] = true;
        }

        return $selectedCategoryFilters;
    }

    /**
     * Build an array of HREFs for each category filter.
     * When a filter is clicked, that category is added to the category list
     * in the url, if not there, and removed if already there.
     * 
     * 
     * @param type $selectedCategoryFilters
     * @param array $categoryNames the names of the categories
     * @return associative
     *      ex element: 'food' => 'food waste' (if waste is selected, adds food)
     *      ex element: 'food' => 'waste' (if food and waste  are selected, removes food) 
     *      ex element: 'food' => 'all' (if food is the only selected filter)
     */
    public function getCategoryFilterHREFsArray($selectedCategoryFilters, $categoryNames)
    {
        $categoryFilterHREFs = array();

        // build a string with all selected category filter names
        $baseCurrentCategoryString = "";
        foreach($selectedCategoryFilters as $category => $bool)
        {
            // "all" comes in the array so ignore it
            if($category != "all")
                $baseCurrentCategoryString .= $category . " ";
        }

        foreach($categoryNames as $c)
        {
            $currentCategoryString = $baseCurrentCategoryString;
            $cLink = $baseCurrentCategoryString;

            if(isset($selectedCategoryFilters[$c]))
            {
                $currentCategoryString = str_replace($c, "", $currentCategoryString);
                // clean up white spaces
                $currentCategoryString = str_replace("  ", " ", $currentCategoryString);
            }
            else
            {
                $currentCategoryString .= $c . " ";
            }

            // if currentCategoryString is empty, make the filter link to all
            if(trim($currentCategoryString) == "")
                $categoryFilterHREFs[$c] = 'all';
            else
                $categoryFilterHREFs[$c] = trim(rtrim($currentCategoryString, ' '));
        }

        return $categoryFilterHREFs;
    }

    public function getCategoryTotals()
    {
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');

        $allSteps = $stepRepository->findBy(array('approved' => true));
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
