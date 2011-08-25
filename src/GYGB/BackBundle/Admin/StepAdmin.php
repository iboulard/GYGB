<?php

namespace GYGB\BackBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use GYGB\BackBundle\Entity\Step;

class StepAdmin extends Admin
{

  protected function configureShowField(ShowMapper $showMapper)
  {
    $showMapper
            ->add('category')
            ->add('step')
            ->add('savings')
            ->add('count')
    ;
  }

  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
            ->add('step', 'string', array('name' => 'Step'))
            ->add('category', 'string', array('name' => 'Category'))
            ->add('savings', 'string', array('name' => 'Savings'))
            ->add('count', 'integer', array('name' => 'Count'))

            // add custom action links
            ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
    ;
  }

  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
            ->add('step', 'text', array('name' => 'Step'))
            ->add('category', 'callback', array(
                'name' => 'Category',
                'template' => 'SonataAdminBundle:CRUD:filter_callback.html.twig',
                'filter_options' => array(
                    'filter' => array($this, 'handleCategoryFilter'),
                    'type' => 'choice'
                ),
                'filter_field_options' => array(
                    'required' => false,
                    'choices' => Step::getCategoryChoices()
                )
            ))
            ->add('savings', 'callback', array(
                'name' => 'Savings',
                'template' => 'SonataAdminBundle:CRUD:filter_callback.html.twig',
                'filter_options' => array(
                    'filter' => array($this, 'handleSavingsFilter'),
                    'type' => 'choice'
                ),
                'filter_field_options' => array(
                    'required' => false,
                    'choices' => Step::getSavingsChoices()
                )
            ))
    ;
  }

  public function handleCategoryFilter($queryBuilder, $alias, $field, $value)
  {
    if(!$value)
    {
      return;
    }

    $queryBuilder->andWhere($alias . '.category = :category');
    $queryBuilder->setParameter('category', $value);
  }

  public function handleSavingsFilter($queryBuilder, $alias, $field, $value)
  {
    if(!$value)
    {
      return;
    }

    $queryBuilder->andWhere($alias . '.savings = :savings');
    $queryBuilder->setParameter('savings', $value);
  }

  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
            ->add('step')
            ->add('category', 'choice', array('choices' => Step::getCategoryChoices(), 'expanded' => false, 'multiple' => false))
            ->add('savings', 'choice', array('choices' => Step::getSavingsChoices(), 'expanded' => false, 'multiple' => false))
            ->add('count')
    ;
  }

}
