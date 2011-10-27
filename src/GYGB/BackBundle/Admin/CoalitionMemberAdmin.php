<?php

namespace GYGB\BackBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use GYGB\BackBundle\Entity\CoalitionMember;

class CoalitionMemberAdmin extends Admin
{

    protected $entityLabelPlural = "Coalition Members";

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, $class, $baseControllerName);

        if (!$this->hasRequest()) {
            $this->datagridValues = array(
                '_page' => 1,
                '_sort_order' => 'ASC', // sort direction
                '_sort_by' => 'name' // field name
            );
        }
    }
    
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
                ->add('name', null, array('label' => 'Name'))
                ->add('url', null, array('label' => 'Website'))
        ;

        $showGroups = array(
            'Coalition Member' => array(
                'fields' => array(
                    'name',
                    'url',
                )
            ),
        );
        $this->setShowGroups($showGroups);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->add('name', 'string', array('name' => 'Name'))
                ->add('url', 'string', array('name' => 'Website'))

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
                ->add('name', null, array('label' => 'Name'))
                ->add('url', null, array('label' => 'Website', 'required' => false))
                
                ->setHelps(array(
                ));

        ;
    }
    

}