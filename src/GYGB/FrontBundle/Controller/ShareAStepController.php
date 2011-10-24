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
            $allStepInfo[$step->getTitle()] = array('category' => $step->getCategory(), 'savings' => $step->getSavings(), 'title' => $step->getTitle());
            $allSteps[] = $step->getTitle();
            $stepObjects[] = $step;
        }

        $stepTitles = array();
        
        foreach($stepObjects as $s)
        {
            $stepTitles[$s->getTitle()] = $s->getTitle();
        }
        
        $stepForm = $this->createFormBuilder()
                ->add('stepDropdown', 'choice', array('label' => ' ','required' => false, 'choices' => $stepTitles))
                ->add('step', 'text', array('label' => 'Title (ex: "Plant a Garden!")', 'required' => false))
                ->add('action', 'text', array('label' => 'Action (ex: "I planted a garden")', 'required' => false))
                ->add('description', 'textarea', array('label' => 'Description (what will help others take this step?)', 'required' => false))
                ->add('category', 'hidden', array('required' => false))
                ->add('stepFromID', 'hidden', array('required' => false))
                ->add('savings', 'hidden', array('required' => false))
                ->add('story', 'textarea', array('label' => 'What did you do? How did it go?', 'required' => false));
        
        if(!$this->get('security.context')->isGranted('ROLE_USER'))
        {
            $stepForm->add('name', 'text', array('label' => 'Your Name', 'required' => true))
                ->add('email', 'text', array('label' => 'Your E-mail', 'required' => true));

        }

        $stepForm = $stepForm->getForm();

        if(isset($selectedStep)) $stepForm->setData(array('story' => $selectedStep->getStory(), 'stepFromID' => $selectedStep->getTitle()));
        
        // process step form
        if($request->getMethod() == 'POST')
        {
            $highlightStep = false;
            $stepForm->bindRequest($request);

            if($stepForm->isValid())
            {
                $session = $this->getRequest()->getSession();
                $data = $stepForm->getData();

                if(trim($data['stepDropdown']) == "" && trim($data['step']) == "" && trim($data['stepFromID']) == "")
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
                else if(trim($data['stepDropdown']) != "")
                {
                    $step_title = $data['stepDropdown'];                    
                }
                else if(trim($data['stepFromID']) != "")
                {
                    $step_title = $data['stepFromID'];                    
                }
                else
                {
                    $step_title = $data['step'];
                }
                
                $step = $stepRepository->findOneBytitle($step_title);

                // add step if new
                if(!$step)
                {
                    $step = new \GYGB\BackBundle\Entity\Step();
                    $step->setTitle($step_title);
                    $step->setApproved(false);
                    $step->setDescription($data['description']);
                    $step->setCategory($data['category']);
                    $step->setSavings($data['savings']);
                    $step->setStepCount(1);
                    $step->setIndividual(true);
                    $step->setCommitmentCount(1);
                    
                    $em->persist($step);
                    $em->flush();

                }
                else
                {
                    $step->setStepCount($step->getStepCount() + 1);
                }
               
                // unapproved steps and new steps (that are inherently unapproved) should not be highlighted
                if(!$step || $step->getApproved() == false)
                {
                    $this->getRequest()->getSession()->setFlash('message', 'Thanks for taking a step to save money and energy! Your step will appear when our team approves it.');
                }
                else
                {
                    if($this->get('security.context')->isGranted('ROLE_USER'))
                    {
                        $this->getRequest()->getSession()->setFlash('message', 'Thanks for taking a step to save money and energy!');
                    }
                    else
                    {
                        $this->getRequest()->getSession()->setFlash('page-message', 'Thanks for taking a step to save money and energy!  Create and account to return and take more steps.');
                    }
                    
                }
                
                
                $stepSubmission = new \GYGB\BackBundle\Entity\StepSubmission();
                
                if($this->get('security.context')->isGranted('ROLE_USER'))
                {
                    $user = $this->get('security.context')->getToken()->getUser();
                    $stepSubmission->setName($user->getName());
                    $stepSubmission->setEmail($user->getEmail());
                    $stepSubmission->setUser($user);
                }
                else
                {
                    $stepSubmission->setName($data['name']);
                    $stepSubmission->setEmail($data['email']);
                    $session->set('userName', $data['name']);
                    $session->set('userEmail', $data['email']);
                }
                
                $stepSubmission->setDatetimeSubmitted(new \DateTime());
                $stepSubmission->setStep($step);
                if(trim($data['story']) != "") $stepSubmission->setStory($data['story']);

                $em->persist($stepSubmission);
                $em->flush();

                $step->addStepSubmission($stepSubmission);
                
                $em->persist($step);
                $em->flush();

                
                if($this->get('security.context')->isGranted('ROLE_USER'))
                {
                    return $this->redirect($this->generateUrl('findAStep'));
                }
                else
                {
                    return $this->redirect($this->generateUrl('fos_user_registration_register'));                    
                }
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