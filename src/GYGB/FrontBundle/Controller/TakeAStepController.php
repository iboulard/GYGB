<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TakeAStepController extends Controller
{
    public function takeAStepAction($id = null)
    {
        if(isset($id))
        {
            $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
            $step = $stepRepository->findOneBy(array('id' => $id));
        
            if(!$step) return $this->forward('GYGBFrontBundle:TakeAStep:resourceList', array('category' => $category));
            else return $this->forward('GYGBFrontBundle:TakeAStep:stepPage', array('id' => $id, 'step' => $step));
        }
        else
        {
            return $this->render('GYGBFrontBundle:TakeAStep:pickAStep.html.twig');
        }
    }

    public function stepPageAction($id, $step)
    {
        $organizationRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Organization');
        $commitmentRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Commitment');
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        $stepSubmissionRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');
        $request = $this->getRequest();
        $session = $request->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $admin = $this->get('gygb.back.admin.organization');

        
        
        $featuredOrgs = $step->getFeaturedOrganizations();

        if(count($featuredOrgs) > 0)
        {
            $organizations = $featuredOrgs;
        }
        else
        {
            $organizations = $organizationRepository->findBy(array('category' => $step->getCategory()));
        }


        $commitmentForm = $this->createFormBuilder()
                ->add('commitment', 'text', array('label' => 'Your Commitment', 'required' => true));

        if(!$this->get('security.context')->isGranted('ROLE_USER'))
        {
            $commitmentForm->add('name', 'text', array('label' => 'Your Name', 'required' => true))
                    ->add('email', 'text', array('label' => 'Your E-mail', 'required' => true));
        }

        $commitmentForm->setData(array('commitment' => $step->getCommitment()));

        $commitmentForm = $commitmentForm->getForm();

        // process commitment form
        if($request->getMethod() == 'POST')
        {
            $commitmentForm->bindRequest($request);

            if($commitmentForm->isValid())
            {
                $data = $commitmentForm->getData();

                $step->setCommitmentCount($step->getCommitmentCount() + 1);

                $this->getRequest()->getSession()->setFlash('page-message', 'Thanks for commiting to take a step to save money and energy!');

                $commitment = new \GYGB\BackBundle\Entity\Commitment();

                if($this->get('security.context')->isGranted('ROLE_USER'))
                {
                    $user = $this->get('security.context')->getToken()->getUser();
                    $commitment->setName($user->getName());
                    $commitment->setEmail($user->getEmail());
                    $commitment->setUser($user);
                }
                else
                {
                    $commitment->setName($data['name']);
                    $commitment->setEmail($data['email']);
                    $session->set('userName', $data['name']);
                    $session->set('userEmail', $data['email']);
                }
                $commitment->setCommitment($data['commitment']);
                $commitment->setDatetimeSubmitted(new \DateTime());
                $commitment->setStep($step);

                $em->persist($commitment);
                $em->flush();

                $step->addCommitment($commitment);

                $em->persist($step);
                $em->flush();


                if($this->get('security.context')->isGranted('ROLE_USER'))
                {
                    return $this->redirect($this->generateUrl('takeAStep', array('id' => $id)));
                }
                else
                {
                    return $this->redirect($this->generateUrl('fos_user_registration_register'));
                }
            }
        }

        $events = $stepRepository->findEventsByStep($step);

        $commited = false;
        $taken = false;

        if($this->get('security.context')->isGranted('ROLE_USER'))
        {

            $user = $this->get('security.context')->getToken()->getUser();

            $userCommitments = $user->getCommitments();
            $userStepSubmissions = $user->getStepSubmissions();

            foreach($userCommitments as $uc)
            {
                if($uc->getStep() == $step)
                {
                    $commited = true;
                    break;
                }
            }
            foreach($userStepSubmissions as $us)
            {
                if($us->getStep() == $step)
                {
                    $taken = true;
                    break;
                }
            }
        }

        return $this->render('GYGBFrontBundle:TakeAStep:takeAStep.html.twig', array(
            'step' => $step,
            'organizations' => $organizations,
            'commitmentForm' => $commitmentForm->createView(),
            'events' => $events,
            'commited' => $commited,
            'taken' => $taken,
            'admin' => $admin
        ));
    }

}