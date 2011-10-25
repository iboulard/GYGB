<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CoalitionController extends Controller
{
    public function coalitionAction($id = null)
    {
        return $this->render('GYGBFrontBundle:Coalition:coalition.html.twig', array(
        ));
    }

}