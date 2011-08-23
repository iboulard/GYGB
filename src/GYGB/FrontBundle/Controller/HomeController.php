<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{

  public function homeAction($stepTaken)
  {
    // get repository, entity manager, and request
    $stepRepository = $this->getDoctrine()->getRepository('GYGBFrontBundle:Step');
    $em = $this->getDoctrine()->getEntityManager();
    $categoryNames = array('food', 'transportation', 'energy', 'waste', 'general');
    $categoryIcons = array('food' => 'apple', 'transportation' => 'bicycle', 'energy' => 'battery', 'waste' => 'recycle-bin', 'general' => 'globe');
    $request = $this->get('request');
    
    $basicSteps = $stepRepository->getBasicSteps();

    $customStepForm = $this->createFormBuilder()
            ->add('name', 'text', array('label' => 'Your Name', 'required' => false))
            ->add('category', 'hidden', array('required' => false))
            ->add('savings', 'hidden', array('required' => false))
            ->add('step', 'text', array('label' => 'What step did you take?'))
            ->getForm();

    $customStepForm->setData(array('step' => 'I ', 'category' => '', 'savings' => ''));
    
    // process custom step form
    if($request->getMethod() == 'POST' && !$stepTaken)
    {
      $customStepForm->bindRequest($request);

      if($customStepForm->isValid())
      {
        $session = $this->getRequest()->getSession();
        $data = $customStepForm->getData();

        $step = $stepRepository->findOneByStep($data['step']);

        if($step)
        {
          $step->setCount($step->getCount() + 1);
        }
        else
        {
          $step = new \GYGB\FrontBundle\Entity\Step();
          $step->setStep($data['step']);
          $step->setCount('1');
          $step->setCategory($data['category']);
          $step->setSavings($data['savings']);
        }

        $em->persist($step);
        $em->flush();

        $stepSubmission = new \GYGB\FrontBundle\Entity\StepSubmission();
        $stepSubmission->setName($data['name']);
        $stepSubmission->setDatetimeSubmitted(new \DateTime());
        $stepSubmission->setStep($step);

        $em->persist($stepSubmission);
        $em->flush();

        $data['step'] = '';
        $data['name'] = '';
        $customStepForm->setData($data);
        $stepTaken = true;
      }
      
      $this->redirect($this->generateUrl('home', array('stepTaken' => true)));
    }
    /*   else if(isset($id))
      {

      $step = $stepRepository->findOneById($id);

      if($step)
      {
      $step->setCount($step->getCount() + 1);
      $em->persist($step);
      $em->flush();

      $stepSubmission = new \GYGB\FrontBundle\Entity\StepSubmission();
      //$stepSubmission->setName($data['name']);
      $stepSubmission->setDatetimeSubmitted(new \DateTime());
      $stepSubmission->setStep($step);

      $em->persist($stepSubmission);
      $em->flush();
      $stepTaken = true;
      }

      }
     */



    return $this->render('GYGBFrontBundle:Home:home.html.twig', array(
        'basicSteps' => $basicSteps,
        'customStepForm' => $customStepForm->createView(),
        'stepTaken' => $stepTaken,
        'categoryNames' => $categoryNames,
        'categoryIcons' => $categoryIcons,
    ));
  }

}
