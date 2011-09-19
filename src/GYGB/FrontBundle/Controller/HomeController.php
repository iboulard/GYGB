<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{

    public function getLogoBlocks($logos)
    {
        $curCount = 0;
        $curLogos = array();
        $logoBlocks = array();

        foreach($logos as $l)
        {
            $tempCount = $curCount;

            if($l->getWidth())
            {
                $thisWidth = (int) $l->getWidth() + 10;
                $tempCount += $thisWidth;
            }
            else
            {
                $thisWidth = 100;
                $tempCount += $thisWidth;
            }

            // if this partner makes the block to big
            if($tempCount > 960)
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

    public function staticHomeAction()
    {
        $organizationRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Organization');

        return $this->render('GYGBFrontBundle:Home:staticHome.html.twig', array(
            'partnerBlocks' => $this->getLogoBlocks($organizationRepository->findBy(array('type' => 'partner', 'approved' => true))),
            'onStaticHome' => 'true'
        ));
    }

    public function homeAction($stepTaken)
    {

        // get repository, entity manager, and request
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        $organizationRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Organization');
        $em = $this->getDoctrine()->getEntityManager();
        $categoryNames = array('food', 'transportation', 'energy', 'waste', 'general');
        $categoryIcons = array('food' => 'apple', 'transportation' => 'bicycle', 'energy' => 'battery', 'waste' => 'recycle-bin', 'general' => 'globe');
        $request = $this->get('request');

        $basicSteps = $stepRepository->getBasicSteps();

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

        $stepForm->setData(array('step' => 'I ', 'category' => '', 'savings' => ''));

        // process step form
        if($request->getMethod() == 'POST' && !$stepTaken)
        {
            $stepTaken = false;

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
                else
                {
                    $newStep = false;
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

                $data = array();
                $data['step'] = '';
                $data['name'] = '';
                $stepForm->setData($data);
                $stepTaken = true;
                $this->getRequest()->getSession()->setFlash('message', 'Thanks for taking a step to save money and energy!');

                return $this->redirect($this->generateUrl('home', array('stepTaken' => $stepTaken)));
            }
        }

        return $this->render('GYGBFrontBundle:Home:home.html.twig', array(
            'basicSteps' => $basicSteps,
            'stepForm' => $stepForm->createView(),
            'stepTaken' => $stepTaken,
            'categoryNames' => $categoryNames,
            'categoryIcons' => $categoryIcons,
            'allSteps' => $allSteps,
            'allStepInfo' => $allStepInfo,
            'partnerBlocks' => $this->getLogoBlocks($organizationRepository->findBy(array('type' => 'partner', 'approved' => true))),
            'orgBlocks' => $this->getLogoBlocks($organizationRepository->findBy(array('type' => 'organization', 'approved' => true)))
        ));
    }

}
