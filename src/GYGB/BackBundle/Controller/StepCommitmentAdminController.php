<?php

namespace GYGB\BackBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class StepCommitmentAdminController extends Controller
{
  public function batchActionFeature($query)
    {
        $em = $this->getDoctrine()->getEntityManager();

        foreach($query->getQuery()->iterate() as $pos => $object) {
            $object[0]->setFeatured(true);
        }

        $em->flush();
        $em->clear();

        $this->getRequest()->getSession()->setFlash('sonata_flash_success', 'The selected items have been marked as featured');

        return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
    }

    public function batchActionUnfeature($query)
    {
        $em = $this->getDoctrine()->getEntityManager();

        foreach($query->getQuery()->iterate() as $pos => $object) {
            $object[0]->setFeatured(false);
        }

        $em->flush();
        $em->clear();

        $this->getRequest()->getSession()->setFlash('sonata_flash_success', 'The selected items have been marked as not featured');

        return new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
    }
    
}