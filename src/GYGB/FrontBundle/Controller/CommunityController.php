<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommunityController extends Controller
{

    public function communityStepsAction()
    {
        $stepSubmissionRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        $commitmentRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Commitment');

        $events = $stepRepository->findAllEvents($stepSubmissionRepository, $commitmentRepository);

        return $this->render('GYGBFrontBundle:Community:communitySteps.html.twig', array(
            'events' => $events
        ));
    }

    public function stepsTakenCounterAction($extendLayout = false)
    {
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        $stepTotals = $stepRepository->findCategoryStepSubmissionTotals();
        
        $count = $stepTotals['all'];
        $counterDigits = $this->buildCounterDigits($count);
        
        return $this->render('GYGBFrontBundle:Community:_counter.html.twig', array(
            'counterDigits' => $counterDigits,
            'text' => 'Steps Taken',
            'id' => 'steps-taken'
        ));
    }
    
    public function commitmentsMadeCounterAction($extendLayout = false)
    {
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        $stepTotals = $stepRepository->findCategoryCommitmentsTotals();
        
        $count = $stepTotals['all'];
        $counterDigits = $this->buildCounterDigits($count);
        
        return $this->render('GYGBFrontBundle:Community:_counter.html.twig', array(
            'counterDigits' => $counterDigits,
            'text' => 'Commitments Made',
            'id' => 'commitments-made'
        ));
    }
    
    protected function buildCounterDigits($count)
    {
        $count = (int) $count;
        $count = (string) $count;
        $counterDigits = array();

        for($i = 0; $i < strlen($count); $i++)
        {
            $counterDigits[] = $count[$i];
        }
        
        return $counterDigits;
    }


}
