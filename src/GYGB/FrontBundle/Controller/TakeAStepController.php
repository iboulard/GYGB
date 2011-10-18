<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TakeAStepController extends Controller
{
    public function takeAStepAction($id = null)
    {
        if(isset($id))
        {
            $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
            $step = $stepRepository->findOneBy(array('id' => $id));
        }
        else
        {
            $step = null;
        }

        return $this->render('GYGBFrontBundle:TakeAStep:takeAStep.html.twig', array(
            'step' => $step
        ));
    }

}