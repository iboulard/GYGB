<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class OrganizationController extends Controller
{    
    public function organizationAction()
    {
        $organizationRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Organization');
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        $em = $this->getDoctrine()->getEntityManager();
        
        $categoryNames = array('food', 'transportation', 'energy', 'waste', 'general');
        $categoryIcons = array('food' => 'apple', 'transportation' => 'bicycle', 'energy' => 'battery', 'waste' => 'recycle-bin', 'general' => 'globe');
        
        $allStepObjects = $stepRepository->findBy(array('organization' => true));
        $allSteps = array();
        $allStepInfo = array();
        foreach($allStepObjects as $step)
        {
            $allStepInfo[$step->getStep()] = array('category' => $step->getCategory(), 'savings' => $step->getSavings(), 'step' => $step->getStep());
            $allSteps[] = $step->getStep();
        }

        
        
        $request = $this->get('request');

        $orgForm = $this->createFormBuilder()
                ->add('name', 'text', array('label' => 'Organization', 'required' => true))
                ->add('email', 'text', array('label' => 'E-mail', 'required' => true))
                ->add('website', 'text', array('label' => 'Website', 'required' => false))                
                ->add('logo', 'file', array('label' => 'Logo', 'required' => false))
                ->add('step', 'text', array('label' => 'What step did your organization take?'))
                ->add('story', 'textarea', array('label' => 'How did it go? Tell a story!', 'required' => false))
                ->add('org-category', 'hidden', array('required' => false))
                ->add('category', 'hidden', array('required' => false))
                ->add('savings', 'hidden', array('required' => false))
                ->getForm();

        $orgForm->setData(array('step' => 'We ', 'category' => '', 'savings' => ''));

        // process step form
        if($request->getMethod() == 'POST')
        {
            $orgForm->bindRequest($request);

            if($orgForm->isValid())
            {
                $session = $this->getRequest()->getSession();
                $data = $orgForm->getData();

                $step = $stepRepository->findOneByStep($data['step']);

                // add step if new
                if(!$step)
                {
                    $step = new \GYGB\BackBundle\Entity\Step();
                    $step->setStep($data['step']);
                    $step->setApproved(false);
                    $step->setCategory($data['category']);
                    $step->setSavings($data['savings']);
                    $step->setCount(1);
                    $step->setOrganization(true);
                }
                else
                {
                    $step->setCount($step->getCount() + 1);
                }
                
                $em->persist($step);
                $em->flush();

                $stepSubmission = new \GYGB\BackBundle\Entity\StepSubmission();
                $stepSubmission->setName($data['name']);
                $stepSubmission->setDatetimeSubmitted(new \DateTime());
                $stepSubmission->setStep($step);
                if(trim($data['story']) != "") $stepSubmission->setStory($data['story']);

                $em->persist($stepSubmission);
                $em->flush();
                
                $org = new \GYGB\BackBundle\Entity\Organization();
                $org->setApproved(false);
                $org->setName($data['name']);
                $org->setWebsite($data['website']);
                $org->setEmail($data['email']);
                $org->setOrganization(true);
                $org->setSponsor(false);
                $org->setFounder(false);
                if($data['org-category'] == "") $cat = 'general';
                else $cat = $data['org-category'];
                $org->setCategory($cat);

                // logo
                if($data['logo'])
                {
                    $logo = $data['logo'];
                    $extension = $logo->guessExtension();
                    if (!$extension) {
                        // extension cannot be guessed
                        $extension = 'bin';
                    }
                    $newFileName = rand(1, 99999).'.'.$extension;
                    $destPath = __DIR__.'/../../../../web/images/logos/';
                    $logo->move($destPath, $newFileName);
                    
                    $org->setLogo($newFileName);
                }
                
                $em->persist($org);
                $em->flush();

                $this->getRequest()->getSession()->setFlash('message', 'Thanks for committing to our campaign! Your organization will appear once our team confirms you.');
                return $this->redirect($this->generateUrl('home'));
            }
        }
                         
        return $this->render('GYGBFrontBundle:Organization:organization.html.twig', array(
            'orgForm' => $orgForm->createView(),
            'categoryNames' => $categoryNames,
            'categoryIcons' => $categoryIcons,
            'allSteps' => $allSteps,
            'allStepInfo' => $allStepInfo,
        ));
    }

}
