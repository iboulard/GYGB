<?php

namespace GYGB\BackBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use GYGB\FrontBundle\Entity\StepSubmission;

class StepCommitmentAdmin extends Admin
{

    protected $entityLabelPlural = "Step Commitments";

    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
                ->add('name', null, array('label' => 'Name'))
                ->add('email', null, array('label' => 'Email'))
                ->add('datetimeSubmitted', null, array('label' => 'Submitted'))
                ->add('step', null, array('label' => 'Step'))
                ->add('commitment', null, array('label' => 'Commitment'))                
                ->add('approved', null, array('label' => 'Approved'))                
                ->add('spam', null, array('label' => 'Spam'))                
                ->add('featured', null, array('label' => 'Featured'))                
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('name', 'string', array('label' => 'Submitted By'))
                ->add('commitment', null, array('label' => 'Commitment'))                
                ->add('datetimeSubmitted', 'datetime', array('label' => 'Date Submitted'))
                ->add('step', null, array('label' => 'Step'))
                ->add('approved', null, array('label' => 'Approved'))                
                ->add('spam', null, array('label' => 'Spam'))                
                ->add('featured', null, array('label' => 'Featured'))                
                
                // add custom action links
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'view' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    ),
                    'label' => 'Actions'                    
                ))
        ;
    }

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        $actions['approve'] = array(
            'label' => 'Approve Selected',
            'ask_confirmation' => false
        );

        $actions['unapprove'] = array(
            'label' => 'Un-Approve Selected',
            'ask_confirmation' => false
        );
        
        $actions['spam'] = array(
            'label' => 'Mark Selected as Spam',
            'ask_confirmation' => false
        );

        $actions['unspam'] = array(
            'label' => 'Mark Selected as Not Spam',
            'ask_confirmation' => false
        );
        
        $actions['feature'] = array(
            'label' => 'Mark Selected as Featured',
            'ask_confirmation' => false
        );

        $actions['unfeature'] = array(
            'label' => 'Mark Selected as Not Featured',
            'ask_confirmation' => false
        );
        
        return $actions;
    }
    
    public function batchFeature($query)
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

    public function batchUnfeature($query)
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
    

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('name', null, array('label' => 'Name'))
                ->add('step')
                ->add('approved', null, array('label' => 'Approved'))                
                ->add('spam', null, array('label' => 'Spam'))                
                ->add('featured', null, array('label' => 'Featured'))                
        ;
        
        $this->filterDefaults['spam'] = 2; 
    }
    
   

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('step')
                ->add('name')
                ->add('email')
                ->add('commitment')
                ->add('datetimeSubmitted', null, array('label' => 'Submitted'))
                ->add('approved', null, array('label' => 'Approved'))                
                ->add('spam', null, array('label' => 'Spam'))                
                ->add('featured', null, array('label' => 'Featured'))                
        ;
    }

}
