<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TakeAStepController extends Controller
{
    public function takeAStepAction($id = null)
    {
        if(isset($id))
        {
            $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
            $step = $stepRepository->findOneBy(array('id' => $id));
        
            if(!$step)
            {
                 throw new NotFoundHttpException("This step could not be found");
            }
            else if(!$step->getApproved())
            {
                return $this->render('GYGBFrontBundle:TakeAStep:unapprovedStep.html.twig', array('id' => $id, 'step' => $step));                                
            }
            else
            {
                return $this->forward('GYGBFrontBundle:TakeAStep:stepPage', array('id' => $id, 'step' => $step));                
            }
        }
        else
        {
            return $this->render('GYGBFrontBundle:TakeAStep:pickAStep.html.twig');
        }
    }

    public function stepPageAction($id, $step)
    {
        $resourceRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Resource');
        $commitmentRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Commitment');
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        $stepSubmissionRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');
        $request = $this->getRequest();
        $session = $request->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        $resourceAdmin = $this->get('gygb.back.admin.resource');
        $stepAdmin = $this->get('gygb.back.admin.step');
        
        $featuredResources = $step->getFeaturedResources();

        if(count($featuredResources) > 0)
        {
            $resources = $featuredResources;
        }
        else
        {
            $resources = $resourceRepository->findBy(array('category' => $step->getCategory()));
        }


        $commitmentForm = $this->createFormBuilder()
                ->add('commitment', 'text', array('label' => 'Your Commitment', 'required' => true));

        if(!$this->get('security.context')->isGranted('ROLE_USER'))
        {
            $commitmentForm->add('name', 'text', array('label' => 'Your Name', 'required' => true))
                    ->add('email', 'text', array('label' => 'Your E-mail', 'required' => true));
        }

        $commitmentForm = $commitmentForm->getForm();

        // process commitment form
        if($request->getMethod() == 'POST')
        {
            $commitmentForm->bindRequest($request);

            if($commitmentForm->isValid())
            {
                $data = $commitmentForm->getData();

                $step->setCommitmentCount($step->getCommitmentCount() + 1);

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
                $commitment->setSpam(false);
                $commitment->setApproved(false);

                
                $em->persist($commitment);
                $em->flush();

                $step->addCommitment($commitment);

                $em->persist($step);
                $em->flush();
           
                $this->getRequest()->getSession()->setFlash('template-flash', '::_thanksNeedsApproval.html.twig');                             

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

        $events = $stepRepository->findEventsByStep($step, $stepSubmissionRepository, $commitmentRepository, $em);

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
            'resources' => $resources,
            'commitmentForm' => $commitmentForm->createView(),
            'events' => $events,
            'commited' => $commited,
            'taken' => $taken,
            'resourceAdmin' => $resourceAdmin,
            'stepAdmin' => $stepAdmin,
        ));
    }

}