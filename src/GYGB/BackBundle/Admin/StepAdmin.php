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
                ->add('title', null, array('label' => 'Title'))
                ->add('category', null, array('label' => 'Category'))
                ->add('commitment', null, array('label' => 'Default Commitment'))
                ->add('story', null, array('label' => 'Default Story'))
                //->add('savings', null, array('label' => 'Savings'))
                ->add('stepCount', null, array('label' => 'Step Count'))
                ->add('commitmentCount', null, array('label' => 'Commitment Count'))
                ->add('approved', null, array('label' => 'Approved'))
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

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('title', 'string', array('label' => 'Step'))
                ->add('category', 'string', array('label' => 'Category'))
                ->add('approved', 'boolean', array('label' => 'Approved'))
                ->add('stepCount', 'integer', array('label' => 'Step Count'))
                ->add('commitmentCount', 'integer', array('label' => 'Commitment Count'))

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

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('title', null, array('label' => 'Step'))
                ->add('category', 'doctrine_orm_choice', array('label' => 'Category',
                    'field_options' => array(
                        'required' => false,
                        'choices' => Step::getCategoryChoices()
                    ),
                    'field_type' => 'choice'
                ))
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('title')
                ->add('category', 'choice', array('choices' => Step::getCategoryChoices(), 'expanded' => false, 'multiple' => false))
                //->add('savings', 'choice', array('choices' => Step::getSavingsChoices(), 'expanded' => false, 'multiple' => false))
                ->add('commitment', null, array('required' => false, 'label' => 'Default Commitment')) 
                ->add('story', null, array('required' => false, 'label' => 'Default Story')) 
                ->add('description', null, array('attr' => array('class' => 'tinymce')))
                ->add('approved')
                //->add('stepCount', null, array('required' => false, 'label' => 'Step Count'))
                //->add('commitmentCount', null, array('required' => false, 'label' => 'Commitment Count'))
                ->add('featuredResources', 'sonata_type_model', array('label' => 'Related Resources', 'required' => false))
                ->setHelps(array(
                    'featuredResources' => 'CTRL + click to select mutliple resources',
                    'commitment' => 'ex: "I will join carshare."',
                    'story' => 'ex: "I joined carshare."',
                    'approved' => 'only approved steps will appear on the site'
                ));

        ;
        
        
    }

}
