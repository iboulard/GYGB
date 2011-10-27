<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{
    public function staticHomeAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $organizationRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Organization');

        return $this->render('GYGBFrontBundle:Home:staticHome.html.twig', array(
            'foundersAndSponsors' => $this->getOrganizationLogoBlocks($organizationRepository->findFoundersAndSponsors($em)),
            'onStaticHome' => 'true'
        ));
    }

    public function homeAction($highlightStep)
    {
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        $organizationRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Organization');
        $featuredResourceRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:FeaturedResource');
        $featuredStepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:FeaturedStep');
        $admin = $this->get('gygb.back.admin.organization');

        $em = $this->getDoctrine()->getEntityManager();
        
        $featuredResources = $featuredResourceRepository->findFeaturedOnHome();
        $featuredSteps = $featuredStepRepository->findFeaturedOnHome();
        
        $request = $this->get('request');

        
        $ua = $_SERVER['HTTP_USER_AGENT'];
	if((!isset($_SESSION['ie6_message']) || $_SESSION['ie6_message'] == true) && preg_match('/\bmsie 6/i', $ua) && !preg_match('/\bopera/i', $ua)) {
          $usingIE6 = true;
        }
        else{
          $usingIE6 = false;
        }

        
        return $this->render('GYGBFrontBundle:Home:home.html.twig', array(
            'highlightStep' => $highlightStep,
            'featuredResources' => $featuredResources,
            'featuredSteps' => $featuredSteps,
            'admin' => $admin,
            'usingIE6' => $usingIE6
        ));
    }
    
    public function stepsTakenCounterAction($extendLayout = false)
    {
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        $stepTotals = $stepRepository->findCategoryStepSubmissionTotals();
        
        $stepCount = (int) $stepTotals['all'];
        $stepCount = (string) $stepCount;
        $stepDigits = array();

        for($i = 0; $i < strlen($stepCount); $i++)
        {
            $stepDigits[] = $stepCount[$i];
        }

        return $this->render('GYGBFrontBundle:Home:_stepsTakenCounter.html.twig', array(
            'stepDigits' => $stepDigits,
        ));
    }
    public function commitmentsCounterAction($extendLayout = false)
    {
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        $stepTotals = $stepRepository->findCategoryCommitmentsTotals();
        
        $stepCount = (int) $stepTotals['all'];
        $stepCount = (string) $stepCount;
        $stepDigits = array();

        for($i = 0; $i < strlen($stepCount); $i++)
        {
            $stepDigits[] = $stepCount[$i];
        }

        return $this->render('GYGBFrontBundle:Home:_commitmentsCounter.html.twig', array(
            'stepDigits' => $stepDigits,
        ));
    }

    public function recentStepListAction()
    {
        $stepSubmissionRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');
        $em = $this->getDoctrine()->getEntityManager();

        
        /*
        $sessionStepCount = 0;
        if($this->getRequest()->getSession()->get('steps'))
        {
            $sessionStepCount = count($this->getRequest()->getSession()->get('steps'));
        }
        
        $numberToRetrieve = 4 - $sessionStepCount;*/
        $numberToRetrieve = 5;

        $recentSteps = $stepSubmissionRepository->getRecentStepSubmissions($numberToRetrieve, $em);

        return $this->render('GYGBFrontBundle:Home:_recentStepList.html.twig', array(
            'recentSteps' => $recentSteps
        ));
    }

    
    /**
     * Take an array of Organization objects, and put their logos into rows,
     * based upon their width, and the width of the page.
     * This is used so that the last (incomplete) row can be centered.
     * 
     * @param arr of Organization objects $organizations
     * @return arr one element for each row of logos, with the options
     *  "width" (width of the row)
     *  "logos" (array of Organization objects) 
     */
    public function getOrganizationLogoBlocks($organizations)
    {
        $curCount = 0;
        $curLogos = array();
        $logoBlocks = array();
        $defaultWidth = 55.0;
        $defaultPadding = 10; //left and right
        $pageWidth = 960;

        foreach($organizations as $l)
        {
            $tempCount = $curCount;

            if($l->getWidth())
            {
                $thisWidth = (int)((double) $l->getWidth() * $defaultWidth);
                $l->setWidth($thisWidth);
                $tempCount += $thisWidth + $defaultPadding;
            }
            else
            {
                $thisWidth = $defaultWidth;
                $tempCount += $thisWidth + $defaultPadding;
            }

            // if this partner makes the block to big
            if($tempCount > $pageWidth)
            {
                $logoBlocks[] = array(
                    'width' => $curCount,
                    'logos' => $curLogos
                );

                // reset and add
                $curLogos = array();
                $curLogos[] = $l;
                $curCount = $thisWidth + $defaultPadding;
            }
            else
            {
                $curCount = $tempCount;
                $curLogos[] = $l;
            }
        }

        if(sizeof($curLogos) > 0)
        {
            $logoBlocks[] = array(
                'width' => $curCount,
                'logos' => $curLogos
            );
        }

        return $logoBlocks;
    }

}
