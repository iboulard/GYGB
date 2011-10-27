<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommunityStepsController extends Controller
{

    public function communityStepsAction()
    {
        $stepSubmissionRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');
        $commitmentRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Commitment');
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        
        $events = $stepRepository->findAllEvents($stepSubmissionRepository, $commitmentRepository);

        return $this->render('GYGBFrontBundle:CommunitySteps:communitySteps.html.twig', array(
            'events' => $events
        ));
    }



}
