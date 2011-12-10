<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ShareAStepController extends Controller
{
    public function shareAStepAction($id = null, $custom = false)
    {
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $categoryNames = array('food', 'transportation', 'energy', 'waste');
        
        $request = $this->get('request');

        if(isset($id))
        {
            $selectedStep = $stepRepository->findOneById($id);
        }
        else
        {
            $selectedStep = null;
        }
        
        $allStepObjects = $stepRepository->findBy(array('approved' => true));
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
                ->add('stepDropdown', 'choice', array('label' => 'Choose a step','required' => false, 'choices' => $stepTitles))
                ->add('title', 'text', array('label' => 'Title', 'required' => false))
                ->add('commitment', 'text', array('label' => 'Commitment', 'required' => false))
                ->add('step', 'text', array('label' => 'Step', 'required' => false))
                ->add('description', 'textarea', array('label' => 'Description', 'required' => false))
                ->add('category', 'hidden', array('required' => false))
                ->add('stepFromID', 'hidden', array('required' => false))
                ->add('latitude', 'hidden', array('required' => false))
                ->add('longitude', 'hidden', array('required' => false))
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

                if(trim($data['stepDropdown']) == "" && trim($data['title']) == "" && trim($data['stepFromID']) == "")
                {
                    $this->getRequest()->getSession()->setFlash('alert-message error', 'Please select a step or share a new one.');

                    return $this->render('GYGBFrontBundle:ShareAStep:shareAStep.html.twig', array(
                        'stepForm' => $stepForm->createView(),
                        'categoryNames' => $categoryNames,
                        'allSteps' => $allSteps,
                        'allStepInfo' => $allStepInfo,
                        'stepObjects' => $stepObjects,
                        'id' => $id,
                        'selectedStep' => $selectedStep,
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
                    $step_title = $data['title'];
                }
                
                $step = $stepRepository->findOneBytitle($step_title);
                $stepSubmission = new \GYGB\BackBundle\Entity\StepSubmission();
                $newStep = false;
                
                // add step if new
                if(!$step)
                {
                    $newStep = true;
                    $step = new \GYGB\BackBundle\Entity\Step();
                    $step->setTitle($step_title);
                    $step->setApproved(false);
                    $step->setDescription($data['description']);
                    $step->setCategory($data['category']);
                    //$step->setSavings($data['savings']);
                    $step->setStepCount(1);
                    $step->setIndividual(true);
                    $step->setCommitmentCount(0);
                    $step->setCommitment($data['commitment']);
                    $step->setStory($data['step']);
                    
                    $em->persist($step);
                    $em->flush();
                }
                else
                {
                    $step->setStepCount($step->getStepCount() + 1);
                }
               
                
                if($this->get('security.context')->isGranted('ROLE_USER'))
                {
                    $user = $this->get('security.context')->getToken()->getUser();
                    
                    $stepSubmissionArray = array();
                    foreach($user->getStepSubmissions() as $ss)
                    {
                        $stepSubmissionArray[] = $ss->getStep();
                    }
                    if(in_array($step, $stepSubmissionArray)) {
                        $this->getRequest()->getSession()->setFlash('alert-message error', 'You have already taken this step.  Try selecting a different step.');

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
                $stepSubmission->setSpam(false);

                if(trim($data['story']) != "") $stepSubmission->setStory($data['story']);
                if(trim($data['latitude']) != "") $stepSubmission->setLatitude($data['latitude']);
                if(trim($data['longitude']) != "") $stepSubmission->setLongitude($data['longitude']);

                if($stepSubmission->getStory() == $step->getStory()) $stepSubmission->setApproved(true);
                else $stepSubmission->setApproved(false);
                
                $em->persist($stepSubmission);
                $em->flush();

                $step->addStepSubmission($stepSubmission);
                
                if($newStep)
                {
                    $step->setParentSubmission($stepSubmission);
                }
                
                $em->persist($step);
                $em->flush();

                
                // unapproved steps and new steps (that are inherently unapproved) should not be highlighted
                if($newStep || !$stepSubmission->getApproved())
                {
                    $this->getRequest()->getSession()->setFlash('template-flash', '::_thanksNeedsApproval.html.twig');
                }
                else
                {
                    $this->getRequest()->getSession()->setFlash('template-flash', '::_thanks.html.twig');
                }
                
                if($this->get('security.context')->isGranted('ROLE_USER'))
                {
                    return $this->redirect($this->generateUrl('community'));
                }
                else
                {
                    return $this->redirect($this->generateUrl('fos_user_registration_register'));                    
                }
            }
        }
        
        $stepAdmin = $this->get('gygb.back.admin.step');


        return $this->render('GYGBFrontBundle:ShareAStep:shareAStep.html.twig', array(
            'stepForm' => $stepForm->createView(),
            'categoryNames' => $categoryNames,
            'allSteps' => $allSteps,
            'allStepInfo' => $allStepInfo,
            'stepObjects' => $stepObjects,
            'id' => $id,
            'selectedStep' => $selectedStep,
            'custom' => $custom,
            'stepAdmin' => $stepAdmin
        ));
    }

}