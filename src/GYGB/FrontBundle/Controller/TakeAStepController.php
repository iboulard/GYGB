<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TakeAStepController extends Controller
{
    public function takeAStepAction($id = null)
    {
        $organizationRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Organization');

        if(isset($id))
        {
            $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
            $step = $stepRepository->findOneBy(array('id' => $id));
            
            
            if($step->getFeaturedOrganization()) {
                $organizations = $organizationRepository->findById($step->getFeaturedOrganization());
            }
            else 
            {
                $organizations = $organizationRepository->findBy(array('category' => $step->getCategory()));
            }
            
            return $this->render('GYGBFrontBundle:TakeAStep:takeAStep.html.twig', array(
                'step' => $step,
                'organizations' => $organizations,
            ));
        }
        else
        {
            $organizations = $organizationRepository->findBy(array('organization' => '1'));
        
            return $this->render('GYGBFrontBundle:TakeAStep:resources.html.twig', array(
                'organizations' => $organizations
            ));
        }

        
    }

}