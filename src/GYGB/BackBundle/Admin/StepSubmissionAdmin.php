<?php

namespace GYGB\BackBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Summary\SummaryMapper;
use Sonata\AdminBundle\Spreadsheet\SpreadsheetMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use GYGB\BackBundle\Entity\StepSubmission;

class StepSubmissionAdmin extends Admin
{

    protected $entityLabelPlural = "Submissions";

    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
                ->add('type', null, array('label' => 'Type'))
                ->add('name', null, array('label' => 'Name'))
                ->add('email', null, array('label' => 'Email'))
                ->add('datetimeSubmitted', null, array('label' => 'Submitted'))
                // doesn't work vvvv
                //->add('step')
                // ^^^^ works as ->add('Step')
                ->add('text', null, array('label' => 'Text'))                
                ->add('approved', null, array('label' => 'Approved'))                
                ->add('spam', null, array('label' => 'Spam'))                                
                ->add('featured', null, array('label' => 'Featured'))                
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('name', 'string', array('label' => 'Submitted By'))
                ->add('type', null, array('label' => 'Type'))
                ->add('text', null, array('label' => 'Text'))
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
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('type', 'doctrine_orm_choice', array(
                        'field_options' => array(
                            'choices' => StepSubmission::getTypeChoices()
                        ),
                        'field_type' => 'choice'
                ))
                ->add('name', null, array('label' => 'Name'))
                ->add('step', null, array('label' => 'Step'))
                ->add('approved', null, array('label' => 'Approved'))                
                ->add('spam', null, array('label' => 'Spam'))                
                ->add('featured', null, array('label' => 'Featured'))                
        ;
        $this->filterDefaults['spam'] = 2;         
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('type', 'choice', array('choices' => StepSubmission::getTypeChoices()))
                ->add('step')
                ->add('name')
                ->add('email')
                ->add('text')
                ->add('datetimeSubmitted', null, array('label' => 'Submitted'))
                ->add('approved', null, array('label' => 'Approved'))                
                ->add('spam', null, array('label' => 'Spam'))                
                ->add('featured', null, array('label' => 'Featured'))                
        ;
    }

}
