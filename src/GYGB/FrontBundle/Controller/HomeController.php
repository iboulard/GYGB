<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{
    public function homeAction()
    {
        $resourceAdmin = $this->get('gygb.back.admin.resource');        
        
        $featuredResourceRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:FeaturedResource');
        $featuredResources = $featuredResourceRepository->findFeaturedOnHome();
        
        $ua = $_SERVER['HTTP_USER_AGENT'];
	if((!isset($_SESSION['ie6_message']) || $_SESSION['ie6_message'] == true) && preg_match('/\bmsie 6/i', $ua) && !preg_match('/\bopera/i', $ua)) {
          $usingIE6 = true;
        }
        else{
          $usingIE6 = false;
        }

        return $this->render('GYGBFrontBundle:Home:home.html.twig', array(
            'featuredResources' => $featuredResources,
            'resourceAdmin' => $resourceAdmin,
            'usingIE6' => $usingIE6
        ));
    }

}
