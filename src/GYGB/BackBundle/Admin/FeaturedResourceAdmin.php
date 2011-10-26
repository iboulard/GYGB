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
                ->add('organization', null, array('label' => 'Resource'))
        ;

        $showGroups = array(
            'Featured Resource' => array(
                'fields' => array(
                    'type',
                    'organization',
                )
            ),
        );
        $this->setShowGroups($showGroups);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('type', 'string', array('name' => 'Page'))
                ->add('organization', 'string', array('name' => 'Resource'))

                // add custom action links
                ->add('_action', 'actions', array(
                    'actions' => array(
//                        'view' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    )
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
                ->add('organization', null, array('label' => 'Resource'))
                
                ->setHelps(array(
                    'type' => 'the page that the resource will be featured on'
                ));

        ;
    }
    

}