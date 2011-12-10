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
                
                // add custom action links
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'view' => array(),
                        'edit' => array(),
                        'delete' => array(),
                        'approve' => array(),
                        'unapprove' => array()
                    ),
                    'label' => 'Actions'                    
                ))
        ;
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('approve', 'approve/{id}');
        $collection->add('unapprove', 'unapprove/{id}');
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
        
        return $actions;
    }
    

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('name', null, array('label' => 'Name'))
                ->add('step')
                ->add('approved', null, array('label' => 'Approved'))                
                ->add('spam', null, array('label' => 'Spam'))                
        ;
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
        ;
    }

}
