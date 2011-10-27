<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FindAStepController extends Controller
{

    public function findAStepAction()
    {
        $request = $this->getRequest();

        $terms = null;

        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');

        $categoryNames = array('food', 'transportation', 'energy', 'waste', 'general');
        $categoryLabels = array('food' => 'Local Food', 'transportation' => 'Transportation', 'energy' => 'Heat and Electricity', 'waste' => 'Waste Reduction', 'general' => 'General');
        
        $categoryTotals = $stepRepository->findCategoryStepTotals();
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

        return $this->render('GYGBFrontBundle:FindAStep:findAStep.html.twig', array(
            'categoryNames' => $categoryNames,
            'categoryLabels' => $categoryLabels,
            'totalSteps' => $totalSteps,
            'categoryTotals' => $categoryTotals,
            'stepSearchForm' => $stepSearchForm->createView(),
            'terms' => $terms,
            'onStepsPage' => true,
        ));
    }

    public function allStepListAction($categories = 'all', $sort = 'recent', $savings = 'all', $terms = null, $id = null, $type = 'all')
    {
        $em = $this->getDoctrine()->getEntityManager();
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');

        if(isset($terms))
        {
            $steps = $stepRepository->findByTerms($em, $terms);
        }
        else
        {
//            $steps = $stepRepository->findByFiltersAndSorts($em, $categories, $sort, $savings, $type);
            $steps = $stepRepository->findRecentlySubmitted($em);
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

        return $this->render('GYGBFrontBundle:FindAStep:_allStepList.html.twig', array(
            'steps' => $steps,
            'categories' => $categories,
            'savings' => $savings,
            'sort' => $sort,
            'type' => $type,
            'id' => $id,
            'terms' => $terms,
            'resultNoun' => $resultNoun,
            'stepNoun' => $stepNoun,
        ));
    }

    public function stepDetailsAction($id, $hidden)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        $stepSubmission = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');

        $step = $stepRepository->findOneBy(array('id' => $id));
        
        if(!$step)
        {
            throw new NotFoundHttpException('We can\'t find this step!');
        }

        return $this->render('GYGBFrontBundle:FindAStep:_stepDetails.html.twig', array(
            'step' => $step,
            'hidden' => $hidden
        ));
    }
    
    
    public function organizationAdsAction()
    {
        $organizationRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Organization');
        $organizationAds = $organizationRepository->findBy(array('organization' => '1'));

        return $this->render('GYGBFrontBundle:FindAStep:_organizationAds.html.twig', array(
            'organizationAds' => $organizationAds
        ));
    }

}
