<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ShareAStepController extends Controller
{
    public function shareAStepAction($id = null)
    {
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $categoryNames = array('food', 'transportation', 'energy', 'waste', 'general');
        
        $request = $this->get('request');

        if(isset($id))
        {
            $selectedStep = $stepRepository->findOneById($id);
        }
        else
        {
            $selectedStep = null;
        }
        
        $allStepObjects = $stepRepository->findBy(array('individual' => true));
        $allSteps = array();
        $allStepInfo = array();
        $stepObjects = array();
        foreach($allStepObjects as $step)
        {
            $allStepInfo[$step->getStep()] = array('category' => $step->getCategory(), 'savings' => $step->getSavings(), 'step' => $step->getStep());
            $allSteps[] = $step->getStep();
            $stepObjects[] = $step;
        }

        $stepTitles = array();
        
        foreach($stepObjects as $s)
        {
            $stepTitles[$s->getActionTitle()] = $s->getActionTitle();
        }
        
        $stepForm = $this->createFormBuilder()
                ->add('step_dropdown', 'choice', array('label' => ' ','required' => false, 'choices' => $stepTitles))
                ->add('step', 'text', array('label' => 'Title (ex: "Plant a Garden!")', 'required' => false))
                ->add('action', 'text', array('label' => 'Action (ex: "I planted a garden")', 'required' => false))
                ->add('description', 'textarea', array('label' => 'Description (what will help others take this step?)', 'required' => false))
                ->add('category', 'hidden', array('required' => false))
                ->add('savings', 'hidden', array('required' => false))
                ->add('story', 'textarea', array('label' => 'What did you do? How did it go?', 'required' => false))
                ->add('name', 'text', array('label' => 'Your Name', 'required' => true))
                ->add('email', 'text', array('label' => 'Your E-mail', 'required' => true))
                ->getForm();


        if(isset($selectedStep)) $stepForm->setData(array('step_dropdown' => $selectedStep->getActionTitle()));
        
        // process step form
        if($request->getMethod() == 'POST')
        {
            $highlightStep = false;
            $stepForm->bindRequest($request);

            if($stepForm->isValid())
            {
                $session = $this->getRequest()->getSession();
                $data = $stepForm->getData();

                if(trim($data['step_dropdown']) == "" && trim($data['step']) == "")
                {
                    $this->getRequest()->getSession()->setFlash('error-message', 'Please select a step or share a new one.');

                    return $this->render('GYGBFrontBundle:ShareAStep:shareAStep.html.twig', array(
                        'stepForm' => $stepForm->createView(),
                        'categoryNames' => $categoryNames,
                        'allSteps' => $allSteps,
                        'allStepInfo' => $allStepInfo,
                        'stepObjects' => $stepObjects,
                        'id' => $id,
                        'selectedStep' => $selectedStep
                    ));
                }
                else if(trim($data['step_dropdown']) != "")
                {
                    $step_title = $data['step_dropdown'];                    
                }
                else
                {
                    $step_title = $data['step'];
                }
                
                $step = $stepRepository->findOneByActionTitle($step_title);

                // add step if new
                if(!$step)
                {
                    $step = new \GYGB\BackBundle\Entity\Step();
                    $step->setActionTitle($step_title);
                    $step->setApproved(false);
                    $step->setDescription($data['description']);
                    $step->setCategory($data['category']);
                    $step->setSavings($data['savings']);
                    $step->setCount(1);
                    $step->setIndividual(true);
                }
                else
                {
                    $step->setCount($step->getCount() + 1);
                }
               
                // unapproved steps and new steps (that are inherently unapproved) should not be highlighted
                if(!$step || $step->getApproved() == false)
                {
                    $this->getRequest()->getSession()->setFlash('message', 'Thanks for taking a step to save money and energy! Your step will appear when our team approves it.');
                }
                else
                {
                    $this->getRequest()->getSession()->setFlash('message', 'Thanks for taking a step to save money and energy!');
                }
                
                
                $em->persist($step);
                $em->flush();

                $stepSubmission = new \GYGB\BackBundle\Entity\StepSubmission();
                $stepSubmission->setName($data['name']);
                $stepSubmission->setEmail($data['email']);
                $stepSubmission->setDatetimeSubmitted(new \DateTime());
                $stepSubmission->setStep($step);
                if(trim($data['story']) != "") $stepSubmission->setStory($data['story']);

                $em->persist($stepSubmission);
                $em->flush();

                return $this->redirect($this->generateUrl('home'));
            }
        }

        return $this->render('GYGBFrontBundle:ShareAStep:shareAStep.html.twig', array(
            'stepForm' => $stepForm->createView(),
            'categoryNames' => $categoryNames,
            'allSteps' => $allSteps,
            'allStepInfo' => $allStepInfo,
            'stepObjects' => $stepObjects,
            'id' => $id,
            'selectedStep' => $selectedStep
        ));
    }

}