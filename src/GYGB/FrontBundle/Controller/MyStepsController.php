<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MyStepsController extends Controller
{

    public function myStepsListAction($type = 'step')
    {
        if($this->get('security.context')->isGranted('ROLE_USER'))
        {
            $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
            $user = $this->get('security.context')->getToken()->getUser();

            if($type == 'step')
            {
                $stepSubmissions = $user->getStepSubmissions();
                $events = $stepRepository->turnStepsSubmissionsIntoEvents($stepSubmissions);
                $noEventsText = "You haven't taken any steps yet. <a href='" . $this->generateUrl('findAStep') . "'>Take your first step &rarr;</a>";
            }
            else
            {
                $commitments = $user->getCommitments();
                $events = $stepRepository->turnCommitmentsIntoEvents($commitments);
                $noEventsText = "You haven't commited to any steps yet. <a class='btn pull-right primary' href='" . $this->generateUrl('findAStep') . "'>Commit to a step &rarr;</a>";
            }
        }
        else
        {
            return $this->forward('GYGBFrontBundle:MySteps:register');
        }

        
        return $this->render('GYGBFrontBundle:MySteps:myStepsList.html.twig', array(
            'events' => $events,
            'type' => $type,
            'noEventsText' => $noEventsText
        ));
    }

    public function myStepsEditAction($id, $type = 'step')
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();
        $urlBase = 'my'.ucfirst($type).'s';
        $includeStepForm = false;        
        $categoryNames = array('food', 'transportation', 'energy', 'waste');
        
        if($this->get('security.context')->isGranted('ROLE_USER'))
        {
            $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
            $user = $this->get('security.context')->getToken()->getUser();


            if($type == 'step')
            {
                $stepSubmissionRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');
                $eventObject = $stepSubmissionRepository->findOneById($id);
                $event = $stepRepository->turnStepSubmissionIntoEvent($eventObject);
                $eventForm = $this->createFormBuilder()
                        ->add('story', 'text')
                        ->add('latitude', 'hidden', array('required' => false))
                        ->add('longitude', 'hidden', array('required' => false));
                
                if($eventObject == $eventObject->getStep()->getParentSubmission())
                {
                    $includeStepForm = true;
                    $eventForm
                        ->add('title', 'text', array('label' => 'Title', 'required' => false))
                        ->add('commitment', 'text', array('label' => 'Commitment', 'required' => false))
                        ->add('step', 'text', array('label' => 'Step', 'required' => false))
                        ->add('description', 'textarea', array('label' => 'Description', 'required' => false))
                        ->add('category', 'choice', array('label' => 'What area is the step in?', 'required' => false, 'choices' => array('food' => 'Food', 'waste' => 'Waste', 'transportation' => 'Transportation', 'energy' => 'Heat and Electric')));
                }
                        
                        
                $eventForm = $eventForm->getForm();
                
                $data = array();
                
                $data['story'] = $eventObject->getStory();
               
                if($includeStepForm)
                {    
                    $data['title'] = $eventObject->getStep()->getTitle();
                    $data['commitment'] = $eventObject->getStep()->getCommitment();
                    $data['step'] = $eventObject->getStep()->getStory();
                    $data['description'] = $eventObject->getStep()->getDescription();
                    $data['category'] = $eventObject->getStep()->getCategory();
                }
                $eventForm->setData($data);
            }
            else
            {
                $commitmentRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Commitment');
                $eventObject = $commitmentRepository->findOneById($id);
                $event = $stepRepository->turnCommitmentIntoEvent($eventObject);
                $eventForm = $this->createFormBuilder()
                        ->add('commitment', 'text')
                        ->getForm();

                $eventForm->setData(array('commitment' => $eventObject->getCommitment()));
            }
        }
        else
        {
            return $this->forward('GYGBFrontBundle:MySteps:register');
        }

        if($request->getMethod() == 'POST')
        {
            $eventForm->bindRequest($request);

            if($eventForm->isValid())
            {
                $session = $this->getRequest()->getSession();
                $data = $eventForm->getData();

                if($type == 'step')
                {
                    if(trim($data['story']) != "")
                        $eventObject->setStory($data['story']);
                        if(trim($data['latitude']) != "") $eventObject->setLatitude($data['latitude']);
                        if(trim($data['longitude']) != "") $eventObject->setLongitude($data['longitude']);

                    $em->persist($eventObject);
                    $em->flush();
                    
                    if($includeStepForm)
                    {
                        $step = $stepRepository->findOneById($eventObject->getStep()->getId());
                        $step->setTitle($data['title']);
                        $step->setStory($data['step']);
                        $step->setCommitment($data['commitment']);
                        $step->setDescription($data['description']);
                        $step->setCategory($data['category']);
                        
                        $em->persist($step);
                        $em->flush();   
                    }
                }
                else
                {
                    if(trim($data['commitment']) != "")
                        $eventObject->setCommitment($data['commitment']);

                    $em->persist($eventObject);
                    $em->flush();                    
                }
                    
                $this->getRequest()->getSession()->setFlash('alert-message success', 'Your '.$type.' has been saved.');

                return $this->redirect($this->generateUrl($urlBase));
            }
        }


        return $this->render('GYGBFrontBundle:MySteps:myStepsEdit.html.twig', array(
            'eventObject' => $eventObject,
            'eventForm' => $eventForm->createView(),
            'event' => $event,
            'type' => $type,
            'urlBase' => $urlBase,
            'includeStepForm' => $includeStepForm,
            'categoryNames' => $categoryNames
        ));
    }

    public function myStepsDeleteAction($id, $type = 'step')
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();
        $urlBase = 'my'.ucfirst($type).'s';
        
        if($this->get('security.context')->isGranted('ROLE_USER'))
        {
            $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
            $user = $this->get('security.context')->getToken()->getUser();

            if($type == 'step')
            {
                $stepSubmissionRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');
                $eventObject = $stepSubmissionRepository->findOneById($id);
                $event = $stepRepository->turnStepSubmissionIntoEvent($eventObject);
                $step = $eventObject->getStep();
            }
            else
            {
                $commitmentRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Commitment');
                $eventObject = $commitmentRepository->findOneById($id);
                $event = $stepRepository->turnCommitmentIntoEvent($eventObject);
                $step = $eventObject->getStep();                
            }
                
            $eventForm = $this->createFormBuilder()
                    ->getForm();
        }
        else
        {
            return $this->forward('GYGBFrontBundle:MySteps:register');
        }

        if($request->getMethod() == 'POST')
        {
            $eventForm->bindRequest($request);

            if($eventForm->isValid())
            {
                $session = $this->getRequest()->getSession();

                $em->remove($eventObject);
                
                // decrement step count
                $step->setStepCount($step->getStepCount() - 1);
                $em->flush();                
                
                $this->getRequest()->getSession()->setFlash('alert-message success', 'Your '.$type.' has been deleted.');

                return $this->redirect($this->generateUrl($urlBase));
            }
        }


        return $this->render('GYGBFrontBundle:MySteps:myStepsDelete.html.twig', array(
                    'eventObject' => $eventObject,
                    'eventForm' => $eventForm->createView(),
                    'event' => $event,
                    'type' => $type,
                    'urlBase' => $urlBase
                ));
    }

    public function registerAction()
    {
        return $this->render('GYGBFrontBundle:MySteps:register.html.twig', array(
                ));
    }

}
