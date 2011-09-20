<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{
    public function staticHomeAction()
    {
        $organizationRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Organization');

        return $this->render('GYGBFrontBundle:Home:staticHome.html.twig', array(
            'partnerBlocks' => $this->getOrganizationLogoBlocks($organizationRepository->findBy(array('founder' => true, 'approved' => true))),
            'sponsorBlocks' => $this->getOrganizationLogoBlocks($organizationRepository->findBy(array('sponsor' => true, 'approved' => true))),
            'onStaticHome' => 'true'
        ));
    }

    public function homeAction($stepTaken)
    {

        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        $organizationRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Organization');
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $categoryNames = array('food', 'transportation', 'energy', 'waste', 'general');
        $categoryIcons = array('food' => 'apple', 'transportation' => 'bicycle', 'energy' => 'battery', 'waste' => 'recycle-bin', 'general' => 'globe');
        
        $request = $this->get('request');

        $allStepObjects = $stepRepository->findAll();
        $allSteps = array();
        $allStepInfo = array();
        foreach($allStepObjects as $step)
        {
            $allStepInfo[$step->getStep()] = array('category' => $step->getCategory(), 'savings' => $step->getSavings(), 'step' => $step->getStep());
            $allSteps[] = $step->getStep();
        }

        $stepForm = $this->createFormBuilder()
                ->add('name', 'text', array('label' => 'Your Name', 'required' => false))
                ->add('category', 'hidden', array('required' => false))
                ->add('savings', 'hidden', array('required' => false))
                ->add('step', 'text', array('label' => 'What step did you take?'))
                ->getForm();

        // reset data for when form is submitted
        $stepForm->setData(array('step' => 'I ', 'category' => '', 'savings' => ''));

        // process step form
        if($request->getMethod() == 'POST')
        {
            $stepTaken = false;
            $newStep = false;

            $stepForm->bindRequest($request);

            if($stepForm->isValid())
            {
                $session = $this->getRequest()->getSession();
                $data = $stepForm->getData();

                $step = $stepRepository->findOneByStep($data['step']);

                if(!$step)
                {
                    $step = new \GYGB\BackBundle\Entity\Step();
                    $step->setStep($data['step']);
                    $step->setApproved(false);
                    $step->setCategory($data['category']);
                    $step->setSavings($data['savings']);
                    $newStep = true;
                }
               
                $em->persist($step);
                $em->flush();

                $stepSubmission = new \GYGB\BackBundle\Entity\StepSubmission();
                $stepSubmission->setName($data['name']);
                $stepSubmission->setDatetimeSubmitted(new \DateTime());
                $stepSubmission->setStep($step);
                $stepSubmission->setType('member');

                $em->persist($stepSubmission);
                $em->flush();
                $stepTaken = true;

                // save the step to the session if a new step
                /*        if($newStep)
                  {
                  // the steps are stored in an array, do not override old steps
                  if($this->getRequest()->getSession()->get('steps'))
                  {
                  $sessionSteps = $this->getRequest()->getSession()->get('steps');
                  }
                  else
                  {
                  $sessionSteps = array();
                  }
                  $sessionSteps[] = $stepSubmission;
                  $this->getRequest()->getSession()->set('steps', $sessionSteps);
                  } */

                // reset the form values
                $data = array();
                $data['step'] = '';
                $data['name'] = '';
                $stepForm->setData($data);
                
                $this->getRequest()->getSession()->setFlash('message', 'Thanks for taking a step to save money and energy!');

                return $this->redirect($this->generateUrl('home', array('stepTaken' => $stepTaken)));
            }
        }

        return $this->render('GYGBFrontBundle:Home:home.html.twig', array(
            'stepForm' => $stepForm->createView(),
            'stepTaken' => $stepTaken,
            'categoryNames' => $categoryNames,
            'categoryIcons' => $categoryIcons,
            'allSteps' => $allSteps,
            'allStepInfo' => $allStepInfo,
            'founderBlocks' => $this->getOrganizationLogoBlocks($organizationRepository->findBy(array('founder' => true, 'approved' => true))),
            'sponsorBlocks' => $this->getOrganizationLogoBlocks($organizationRepository->findBy(array('sponsor' => true, 'approved' => true))),
            'orgBlocks' => $this->getOrganizationLogoBlocks($organizationRepository->findBy(array('organization' => true, 'approved' => true)))
        ));
    }
    
    public function stepsTakenCounterAction($extendLayout = false)
    {
        $stepSubmissionRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');
        $em = $this->getDoctrine()->getEntityManager();

        $stepCount = (int) $stepSubmissionRepository->getNumberOfStepSubmissions($em);
        $stepCount = (string) $stepCount;
        $stepDigits = array();

        for($i = 0; $i < strlen($stepCount); $i++)
        {
            $stepDigits[] = $stepCount[$i];
        }

        return $this->render('GYGBFrontBundle:Home:_stepsTakenCounter.html.twig', array(
            'stepDigits' => $stepDigits,
        ));
    }

    public function recentStepListAction()
    {
        $stepSubmissionRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');
        $em = $this->getDoctrine()->getEntityManager();

        
        /*
        $sessionStepCount = 0;
        if($this->getRequest()->getSession()->get('steps'))
        {
            $sessionStepCount = count($this->getRequest()->getSession()->get('steps'));
        }
        
        $numberToRetrieve = 4 - $sessionStepCount;*/
        $numberToRetrieve = 5;

        $recentSteps = $stepSubmissionRepository->getRecentStepSubmissions($numberToRetrieve, $em);

        return $this->render('GYGBFrontBundle:Home:_recentStepList.html.twig', array(
            'recentSteps' => $recentSteps
        ));
    }

    
    /**
     * Take an array of Organization objects, and put their logos into rows,
     * based upon their width, and the width of the page.
     * This is used so that the last (incomplete) row can be centered.
     * 
     * @param arr of Organization objects $organizations
     * @return arr one element for each row of logos, with the options
     *  "width" (width of the row)
     *  "logos" (array of Organization objects) 
     */
    public function getOrganizationLogoBlocks($organizations)
    {
        $curCount = 0;
        $curLogos = array();
        $logoBlocks = array();
        $defaultWidth = 100;
        $pageWidth = 960;

        foreach($organizations as $l)
        {
            $tempCount = $curCount;

            if($l->getWidth())
            {
                $thisWidth = (int) $l->getWidth() + 10;
                $tempCount += $thisWidth;
            }
            else
            {
                $thisWidth = $defaultWidth;
                $tempCount += $thisWidth;
            }

            // if this partner makes the block to big
            if($tempCount > $pageWidth)
            {
                $logoBlocks[] = array(
                    'width' => $curCount,
                    'logos' => $curLogos
                );

                // reset and add
                $curLogos = array();
                $curLogos[] = $l;
                $curCount = $thisWidth;
            }
            else
            {
                $curCount = $tempCount;
                $curLogos[] = $l;
            }
        }

        if(sizeof($curLogos) > 0)
        {
            $logoBlocks[] = array(
                'width' => $curCount,
                'logos' => $curLogos
            );
        }

        return $logoBlocks;
    }

}
