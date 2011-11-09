<?php

namespace GYGB\BackBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use GYGB\FrontBundle\Entity\StepSubmission;

class StepSubmissionAdmin extends Admin
{

    protected $entityLabelPlural = "Step Submissions";

    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
                ->add('name', null, array('label' => 'Name'))
                ->add('email', null, array('label' => 'Email'))
                ->add('datetimeSubmitted', null, array('label' => 'Submitted'))
                ->add('step', null, array('label' => 'Step'))
                ->add('story', null, array('label' => 'Story'))                
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('name', 'string', array('label' => 'Submitted By'))
                ->add('datetimeSubmitted', 'datetime', array('label' => 'Date Submitted'))
                ->add('step', null, array('label' => 'Step'))

                // add custom action links
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'view' => array(),
                        'edit' => array(),
                        'delete' => array()
                    ),
                    'label' => 'Actions'
                    
                ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('name', null, array('label' => 'Name'))
                ->add('step')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('step')
                ->add('name')
                ->add('email')
                ->add('story')
                ->add('datetimeSubmitted', null, array('label' => 'Submitted'))
        ;
    }

}
