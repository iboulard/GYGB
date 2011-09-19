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
        $em = $this->getDoctrine()->getEntityManager();
        $categoryNames = array('food', 'transportation', 'energy', 'waste', 'general');
        $categoryIcons = array('food' => 'apple', 'transportation' => 'bicycle', 'energy' => 'battery', 'waste' => 'recycle-bin', 'general' => 'globe');
        $request = $this->get('request');

        $orgForm = $this->createFormBuilder()
                ->add('name', 'text', array('label' => 'Organization', 'required' => true))
                ->add('email', 'text', array('label' => 'E-mail', 'required' => true))
                ->add('logo', 'file', array('label' => 'Logo', 'required' => false))
                ->add('category', 'hidden', array('required' => false))
                ->add('website', 'text', array('label' => 'Website', 'required' => false))                
                ->getForm();

        // process step form
        if($request->getMethod() == 'POST')
        {
            $orgForm->bindRequest($request);

            if($orgForm->isValid())
            {
                $session = $this->getRequest()->getSession();
                $data = $orgForm->getData();

                $org = new \GYGB\BackBundle\Entity\Organization();
                $org->setApproved(false);
                $org->setName($data['name']);
                $org->setWebsite($data['website']);
                $org->setEmail($data['email']);
                if($data['category'] == "") $cat = 'general';
                else $cat = $data['category'];
                $org->setCategory($cat);
                $org->setType('organization');
                //$org->setLogo($data['logo']);


                $em->persist($org);
                $em->flush();

                $data = array();
                $data['name'] = '';
                $data['website'] = '';
                $data['email'] = '';
                $data['category'] = '';
                $orgForm->setData($data);

                $this->getRequest()->getSession()->setFlash('message', 'Thanks for committing to our campaign! Your organization will appear once our team confirms you.');
                return $this->redirect($this->generateUrl('home'));
            }
        }
                         
        return $this->render('GYGBFrontBundle:Organization:organization.html.twig', array(
            'orgForm' => $orgForm->createView(),
            'categoryNames' => $categoryNames,
            'categoryIcons' => $categoryIcons,
        ));
    }

}
