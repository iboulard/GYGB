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
  protected function configureShowField(ShowMapper $showMapper)
  {
    $showMapper
            ->add('name')
            ->add('datetimeSubmitted')
    ;
  }
  
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
            ->add('name', 'string', array('name' => 'Submitted By'))
            ->add('datetimeSubmitted', 'datetime', array('name' => 'Date Submitted'))
            ->add('Step', null, array('name' => 'Step'))
            
            // add custom action links
            ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array(),
                    'edit' => array(),
                    'delete' => array()
                )
            ))
    ;
  }
  
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
            ->add('step')
            ->add('name')
            ->add('datetimeSubmitted')
    ;
  }

}
