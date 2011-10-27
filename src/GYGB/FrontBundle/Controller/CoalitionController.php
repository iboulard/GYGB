<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CoalitionController extends Controller
{
    public function coalitionAction($id = null)
    {
        $coalitionMemberRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:CoalitionMember');
        $coalitionMembers = $coalitionMemberRepository->findAll();
        
        $middle =  ceil(count($coalitionMembers) / 2);
        
        $coalitionMembersA = array_slice($coalitionMembers, 0, $middle);
        $coalitionMembersB = array_slice($coalitionMembers, $middle);
        
        return $this->render('GYGBFrontBundle:Coalition:coalition.html.twig', array(
            'coalitionMembersA' => $coalitionMembersA,
            'coalitionMembersB' => $coalitionMembersB
        ));
    }

}