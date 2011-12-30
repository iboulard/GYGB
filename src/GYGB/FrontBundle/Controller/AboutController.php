<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AboutController extends Controller
{    
    public function aboutAction()
    {                    
        return $this->render('GYGBFrontBundle:About:about.html.twig', array());
    }

    public function fixStepSubmissionTypesAction()
    {
        $stepSubmissionRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');
        $em = $this->getDoctrine()->getEntityManager();
        
        $stepSubmissions = $stepSubmissionRepository->findAll();
        
        foreach($stepSubmissions as $ss) {
            $ss->setType('step');
            $em->persist($ss);
        }
        
        $em->flush();
    }
    
    public function convertCommitmentsAction()
    {
        $stepSubmissionRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');
        $commitmentRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Commitment');
        $em = $this->getDoctrine()->getEntityManager();
        
        $commitments = $commitmentRepository->findAll();
        
        foreach($commitments as $c) {
            $ss = new \GYGB\BackBundle\Entity\StepSubmission();
            
            $ss->setApproved($c->getApproved());
            $ss->setDatetimeSubmitted($c->getDatetimeSubmitted());
            $ss->setEmail($c->getEmail());
            $ss->setFeatured($c->getFeatured());
            $ss->setName($c->getName());
            $ss->setSpam($c->getSpam());
            $ss->setStep($c->getStep());
            $ss->setText($c->getCommitment());
            if($c->getUser()) $ss->setUser($c->getUser());
            
            $ss->setType('commitment');
            
            $em->persist($ss);
        }
        
        $em->flush();
        
    }
}
