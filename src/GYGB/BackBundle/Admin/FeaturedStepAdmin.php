<?php

namespace GYGB\BackBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use GYGB\BackBundle\Entity\FeaturedStep;

class FeaturedStepAdmin extends Admin
{

    protected $entityLabelPlural = "Featured Steps";

    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
                ->add('type', null, array('label' => 'Page'))
                ->add('step', null, array('label' => 'Step'))
        ;

        $showGroups = array(
            'Featured Step' => array(
                'fields' => array(
                    'type',
                    'step',
                )
            ),
        );
        $this->setShowGroups($showGroups);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('type', 'string', array('name' => 'Page'))
                ->add('step', 'string', array('name' => 'Step'))

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
                ->add('type', 'choice', array('choices' => FeaturedStep::getTypes(), 'expanded' => false, 'multiple' => false, 'label' => 'Page'))
                ->add('step', null, array('label' => 'Step'))
                
                ->setHelps(array(
                    'type' => 'the page that the step will be featured on'
                ));

        ;
    }
    

}