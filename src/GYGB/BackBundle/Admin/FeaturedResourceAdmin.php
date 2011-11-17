<?php

namespace GYGB\BackBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use GYGB\BackBundle\Entity\FeaturedResource;

class FeaturedResourceAdmin extends Admin
{

    protected $entityLabelPlural = "Featured Resources";

    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
                ->add('type', null, array('label' => 'Page'))
                ->add('resource')
        ;

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('type', 'string', array('label' => 'Page'))
                ->add('resource', 'string', array('label' => 'Resource'))

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

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('type', 'choice', array('choices' => FeaturedResource::getTypes(), 'expanded' => false, 'multiple' => false, 'label' => 'Page'))
                ->add('resource', null, array('label' => 'Resource'))
                
                ->setHelps(array(
                    'type' => 'the page that the resource will be featured on'
                ));

        ;
    }
    

}