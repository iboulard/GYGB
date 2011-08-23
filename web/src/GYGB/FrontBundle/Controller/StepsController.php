<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StepsController extends Controller
{

  public function stepsTakenAction($extendLayout = false)
  {
    $stepRepository = $this->getDoctrine()->getRepository('GYGBFrontBundle:Step');
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
    
    $stepSubmissionRepository = $this->getDoctrine()->getRepository('GYGBFrontBundle:StepSubmission');
    $recentSteps = $stepSubmissionRepository->getRecentSteps('5', $em);
    
    return $this->render('GYGBFrontBundle:Steps:_recentSteps.html.twig', array(
        'recentSteps' => $recentSteps
    ));
    
  }

}
