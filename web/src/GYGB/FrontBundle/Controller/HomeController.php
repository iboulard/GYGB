<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{

  public function homeAction($id = null)
  {
    // get repository, entity manager, and request
    $stepRepository = $this->getDoctrine()->getRepository('GYGBFrontBundle:Step');
    $em = $this->getDoctrine()->getEntityManager();
    $request = $this->get('request');
    $stepTaken = false;

    $basicSteps = $stepRepository->getBasicSteps();

    $customStepForm = $this->createFormBuilder()
            ->add('name', 'text', array('label' => 'Your Name', 'required' => false))
            ->add('step', 'textarea', array('label' => 'What step did you take?'))
            ->getForm();


    // process custom step form
    if($request->getMethod() == 'POST')
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
    }
    else if(isset($id))
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

      return $this->render('GYGBFrontBundle:Home:home.html.twig', array(
          'basicSteps' => $basicSteps,
          'customStepForm' => $customStepForm->createView(),
          'stepTaken' => $stepTaken,
      ));
  }

}
