<?php

namespace GYGB\BackBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use GYGB\BackBundle\Entity\Step;
use GYGB\BackBundle\Entity\Organization;

class OrganizationAdmin extends Admin
{

    protected $entityLabelPlural = "Organizations";

    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
                ->add('name', null, array('label' => 'Name'))
                ->add('website', null, array('label' => 'Website'))
                ->add('email', null, array('label' => 'E-mail'))
                ->add('description', null, array('label' => 'Description'))
                ->add('approved', null, array('label' => 'Approved'))
                ->add('featured', null, array('label' => 'Featured'))
                ->add('category', null, array('label' => 'Category'))
                ->add('organization', null, array('label' => 'Organization'))
                ->add('sponsor', null, array('label' => 'Sponsor'))
                ->add('founder', null, array('label' => 'Founding Partner'))
        ;

        $showGroups = array(
            'Organization' => array(
                'fields' => array(
                    'name',
                    'website',
                    'email',
                    'description',
                    'approved',
                    'featured',
                    'category',
                    'organization', 'sponsor', 'founder'
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
                ->add('name', 'string', array('name' => 'Name'))
                ->add('website', 'string', array('name' => 'Website'))
                ->add('email', 'string', array('name' => 'E-mail'))
                ->add('approved', 'boolean', array('name' => 'Approved'))
                ->add('category', 'string', array('name' => 'category'))
                ->add('type', 'string', array('name' => 'type'))

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
                ->add('name', null, array('label' => 'Organization'))
                ->add('approved', null, array('label' => 'Approved'))
                ->add('category', 'doctrine_orm_choice', array('label' => 'Category',
                    'field_options' => array(
                        'required' => false,
                        'choices' => Step::getCategoryChoices()
                    ),
                    'field_type' => 'choice'
                ))
                ->add('organization', null, array('label' => 'Organization'))
                ->add('sponsor', null, array('label' => 'Sponser'))
                ->add('founder', null, array('label' => 'Founding Partner'))
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('name', null, array('label' => 'Organization'))
                ->add('email')
                ->add('website')
                ->add('description')
                ->add('category', 'choice', array('choices' => Step::getCategoryChoices(), 'expanded' => false, 'multiple' => false))
                ->add('founder', null, array('required' => false))
                ->add('organization', null, array('required' => false))
                ->add('sponsor', null, array('required' => false))
                ->add('approved', null, array('required' => false))
                ->add('featured', null, array('required' => false))
                ->add('logo', null, array('required' => false))
                ->add('width', null, array('required' => false))

        ;
    }

}