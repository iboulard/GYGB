<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ResourcesController extends Controller
{

    public function resourcesAction($category)
    {
        $organizationRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Organization');
        $featuredResourceRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:FeaturedResource');
        $categories = array('energy', 'food', 'waste', 'transportation', 'general');

        $admin = $this->get('gygb.back.admin.organization');
        
        $categoryOptions = array(
            'food' => array(
                'heading' => 'Local Food',
                'description' => 'Whether you are looking to save money, learn to garden, support local food/farm businesses or just want to know what is happening in Tompkins County, check out the “menu” below.',
                'foot' => 'right'
            ),
            'waste' => array(
                'heading' => 'Waste Reduction',
                'foot' => 'left'
            ),
            'transportation' => array(
                'heading' => 'Transportation Alternatives',
                'description' => 'Whether you are looking to save money, get more exercise, support local transportation initiatives and businesses or just want to know what is happening in Tompkins County, check out the options below.',
                'foot' => 'right'
            ),
            'energy' => array(
                'heading' => 'Heating and Electricity',
                'description' => 'Check out the <a href="http://www.upgradeupstate.org/learn/path" target="_blank">Path to Home Energy Savings</a> and the other resources below for the most cost effective sequence to make upgrades, low / no-cost ways to save, how to get a no-cost or reduced-cost energy assessment, tips on choosing a contractor, and upcoming home energy events.',
                'foot' => 'left'
            ),
            'general' => array(
                'heading' => 'General Resources',
                'foot' => 'right'
            ),
        );

        $resources = array();
        $featuredResources = array();

        if(isset($category))
        {
            $featuredResources = $featuredResourceRepository->findFeaturedOnTakeAStep($category);

            $allResources = $organizationRepository->findBy(array('category' => $category));
            
            foreach($allResources as $r)
            {
                if(!in_array($r, $featuredResources)) $resources[] = $r;
            }
    
            
        }
        else
        {
            $featuredResources = $featuredResourceRepository->findAllFeaturedOnTakeAStep();
        }
        
        return $this->render('GYGBFrontBundle:Resources:resources.html.twig', array(
            'resources' => $resources,
            'featuredResources' => $featuredResources,
            'categories' => $categories,
            'categoryOptions' => $categoryOptions,
            'category' => $category,
            'admin' => $admin
        ));
    }

   
}