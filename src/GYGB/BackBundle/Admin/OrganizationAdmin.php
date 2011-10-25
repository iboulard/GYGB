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

    protected $entityLabelPlural = "Resources";

    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
                ->add('name', null, array('label' => 'Name'))
                ->add('website', null, array('label' => 'Website'))
                ->add('email', null, array('label' => 'E-mail'))
                ->add('approved', null, array('label' => 'Approved'))
                ->add('featured', null, array('label' => 'Featured'))
                ->add('category', null, array('label' => 'Category'))
        ;

        $showGroups = array(
            'Organization' => array(
                'fields' => array(
                    'name',
                    'website',
                    'email',
                    'approved',
                    'featured',
                    'category',
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
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('name', null, array('label' => 'Title'))
                ->add('email')
                ->add('website')
                ->add('description')
                ->add('category', 'choice', array('choices' => Step::getCategoryChoices(), 'expanded' => false, 'multiple' => false))
                ->add('approved', null, array('required' => false))
                ->add('featured', null, array('required' => false, 'label' => 'Featured'))
                
                ->add('file', 'file', array('required' => false))
                
                ->setHelps(array(
                    'featured' => 'featured resources show up at the top of their category on the resource guide',
                    'approved' => 'only approved resources will appear on the website',
                    'approved' => 'only approved resources will appear on the website',
                ));

        ;
    }
    
    public $formFieldPreHooks = array();
    
    public $formFieldPostHooks = array(
        'file' => 'GYGBBackBundle:Organization:_currentLogo.html.twig'
    );


    public function prePersist($object)
    {
        $this->saveFile($object);
    }

    public function preUpdate($object)
    {
        $this->saveFile($object);
    }

    public function saveFile($object)
    {
        $object->upload();
    }

}