<?php

namespace GYGB\BackBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use GYGB\BackBundle\Entity\Step;

class StepAdmin extends Admin
{

    protected $entityLabelPlural = "Steps";

    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
                ->add('step', null, array('label' => 'Step'))
                ->add('category', null, array('label' => 'Category'))
                ->add('savings', null, array('label' => 'Savings'))
                ->add('stepCount', null, array('label' => 'Step Count'))
                ->add('commitmentCount', null, array('label' => 'Commitment Count'))
                ->add('approved', null, array('label' => 'Approved'))

        ;

        $showGroups = array(
            'Step' => array(
                'fields' => array(
                    'step',
                    'category',
                    'savings',
                    'stepCount',
                    'commitmentCount',
                    'approved'
                )
            ),
        );
        $this->setShowGroups($showGroups);
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

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('step', 'string', array('name' => 'Watermelon'))
                ->add('category', 'string', array('name' => 'Category'))
                ->add('savings', 'string', array('name' => 'Savings'))
                ->add('approved', 'boolean', array('name' => 'Approved'))
                ->add('stepCount', 'integer', array('name' => 'Step Count'))
                ->add('commitmentCount', 'integer', array('name' => 'Commitment Count'))

                // add custom action links
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'view' => array(),
                        'edit' => array(),
                        'delete' => array(),
                        'approve' => array(),
                        'unapprove' => array()
                    )
                ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('step', null, array('label' => 'Step'))
                ->add('category', 'doctrine_orm_choice', array('label' => 'Category',
                    'field_options' => array(
                        'required' => false,
                        'choices' => Step::getCategoryChoices()
                    ),
                    'field_type' => 'choice'
                ))
                ->add('savings', 'doctrine_orm_choice', array('label' => 'Savings',
                    'field_options' => array(
                        'required' => false,
//                        'choices' => Step::getSavingsChoices()
                    ),
  //                  'field_type' => 'choice'
                ))
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('step')
                ->add('category', 'choice', array('choices' => Step::getCategoryChoices(), 'expanded' => false, 'multiple' => false))
                ->add('savings', 'choice', array('choices' => Step::getSavingsChoices(), 'expanded' => false, 'multiple' => false))
                ->add('approved')
                ->add('stepCount')
                ->add('commitmentCount')
        ;
    }

}
