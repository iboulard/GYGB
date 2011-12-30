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
                $stepSubmissions = $user->getStepSubmissions('step');
                $noStepSubmissionsText = "You haven't taken any steps yet. <a href='" . $this->generateUrl('findAStep') . "'>Take your first step &rarr;</a>";
            }
            else
            {
                $stepSubmissions = $user->getStepSubmissions('commitment');

                $noStepSubmissionsText = "You haven't commited to any steps yet. <a class='btn pull-right primary' href='" . $this->generateUrl('findAStep') . "'>Commit to a step &rarr;</a>";
            }
        }
        else
        {
            return $this->forward('GYGBFrontBundle:MySteps:register');
        }

        
        return $this->render('GYGBFrontBundle:MySteps:myStepsList.html.twig', array(
            'stepSubmissions' => $stepSubmissions,
            'type' => $type,
            'noStepSubmissionsText' => $noStepSubmissionsText
        ));
    }

    public function myStepsEditAction($id, $type = 'step')
    {
        $request = $this->getRequest();
        $stepSubmissionRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');
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
                $stepSubmission = $stepSubmissionRepository->findOneById($id);
                $stepSubmissionForm = $this->createFormBuilder()
                        ->add('story', 'text')
                        ->add('latitude', 'hidden', array('required' => false))
                        ->add('longitude', 'hidden', array('required' => false));
                
                if($stepSubmission == $stepSubmission->getStep()->getParentSubmission())
                {
                    $includeStepForm = true;
                    $stepSubmissionForm
                        ->add('title', 'text', array('label' => 'Title', 'required' => false))
                        ->add('description', 'textarea', array('label' => 'Description', 'required' => false))
                        ->add('category', 'choice', array('label' => 'What area is the step in?', 'required' => false, 'choices' => array('food' => 'Food', 'waste' => 'Waste', 'transportation' => 'Transportation', 'energy' => 'Heat and Electric')));
                }
                        
                        
                $stepSubmissionForm = $stepSubmissionForm->getForm();
                
                $data = array();
                
                $data['story'] = $stepSubmission->getText();
               
                if($includeStepForm)
                {    
                    $data['title'] = $stepSubmission->getStep()->getTitle();
                    $data['description'] = $stepSubmission->getStep()->getDescription();
                    $data['category'] = $stepSubmission->getStep()->getCategory();
                }
                $stepSubmissionForm->setData($data);
            }
            else
            {
                $stepSubmission = $stepSubmissionRepository->findOneById($id);

                $stepSubmissionForm = $this->createFormBuilder()
                        ->add('commitment', 'text')
                        ->getForm();

                $stepSubmissionForm->setData(array('commitment' => $stepSubmission->getText()));
            }
        }
        else
        {
            return $this->forward('GYGBFrontBundle:MySteps:register');
        }

        if($request->getMethod() == 'POST')
        {
            $stepSubmissionForm->bindRequest($request);

            if($stepSubmissionForm->isValid())
            {
                $session = $this->getRequest()->getSession();
                $data = $stepSubmissionForm->getData();

                if($type == 'step')
                {
                    if(trim($data['story']) != "")
                        $stepSubmission->setText($data['story']);
                        if(trim($data['latitude']) != "") $stepSubmission->setLatitude($data['latitude']);
                        if(trim($data['longitude']) != "") $stepSubmission->setLongitude($data['longitude']);

                    $em->persist($stepSubmission);
                    $em->flush();
                    
                    if($includeStepForm)
                    {
                        $step = $stepRepository->findOneById($stepSubmission->getStep()->getId());
                        $step->setTitle($data['title']);
                        $step->setDescription($data['description']);
                        $step->setCategory($data['category']);
                        
                        $em->persist($step);
                        $em->flush();   
                    }
                }
                else
                {
                    if(trim($data['commitment']) != "")
                        $stepSubmission->setText($data['commitment']);

                    $em->persist($stepSubmission);
                    $em->flush();                    
                }
                    
                $this->getRequest()->getSession()->setFlash('alert-message success', 'Your '.$type.' has been saved.');

                return $this->redirect($this->generateUrl($urlBase));
            }
        }


        return $this->render('GYGBFrontBundle:MySteps:myStepsEdit.html.twig', array(
            'stepSubmissionForm' => $stepSubmissionForm->createView(),
            'stepSubmission' => $stepSubmission,
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

            $stepSubmissionRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');
            $stepSubmission = $stepSubmissionRepository->findOneById($id);
            $step = $stepSubmission->getStep();
                
            $stepSubmissionForm = $this->createFormBuilder()
                    ->getForm();
        }
        else
        {
            return $this->forward('GYGBFrontBundle:MySteps:register');
        }

        if($request->getMethod() == 'POST')
        {
            $stepSubmissionForm->bindRequest($request);

            if($stepSubmissionForm->isValid())
            {
                $session = $this->getRequest()->getSession();

                $em->remove($stepSubmission);
                $em->flush();                
                
                $this->getRequest()->getSession()->setFlash('alert-message success', 'Your '.$type.' has been deleted.');

                return $this->redirect($this->generateUrl($urlBase));
            }
        }


        return $this->render('GYGBFrontBundle:MySteps:myStepsDelete.html.twig', array(
                    'stepSubmission' => $stepSubmission,
                    'stepSubmissionForm' => $stepSubmissionForm->createView(),
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
