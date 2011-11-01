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
        $terms = null;
        $request = $this->getRequest();
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');

        $categoryNames = array('food', 'transportation', 'energy', 'waste');
        $categoryLabels = array('food' => 'Local Food', 'transportation' => 'Transportation', 'energy' => 'Heat and Electric', 'waste' => 'Waste Reduction');
        
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
        ));
    }

}
