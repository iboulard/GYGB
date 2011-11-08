<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StepListController extends Controller
{
    public function stepListAction($terms = null, $steps = null, $id = '', $displayCounts = false, $linkSteps = false)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');

        $stepAdmin = $this->get('gygb.back.admin.step');

        if(isset($terms))
        {
            $steps = $stepRepository->findByTerms($em, $terms);
        }
        else if(!isset($steps))
        {
            $steps = $stepRepository->findRecentlyTaken($em);
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

        return $this->render('GYGBFrontBundle:StepList:_stepList.html.twig', array(
            'steps' => $steps,
            'terms' => $terms,
            'resultNoun' => $resultNoun,
            'stepNoun' => $stepNoun,
            'id' => $id,
            'displayCounts' => true,
            'linkSteps' => $linkSteps,
            'stepAdmin' => $stepAdmin
        ));
    }
}
