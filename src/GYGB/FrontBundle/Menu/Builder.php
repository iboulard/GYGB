<?php

namespace GYGB\FrontBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public $mainMenu;
    public $takeAStepMenu;
    
    public $path;
    
    public function takeAStepMenu(FactoryInterface $factory)
    {
        $this->takeAStepMenu = $factory->createItem('root');
        $this->takeAStepMenu->setCurrentUri($this->container->get('request')->getRequestUri());

        $this->takeAStepMenu->addChild('findAStep', array('route' => 'findAStep', 'label' => '1. Find a step', 'attributes' => array('class' => 'findAStep')));
        $this->takeAStepMenu->addChild('takeAStep', array('route' => 'takeAStep', 'label' => '2. Take a step and save', 'attributes' => array('class' => 'takeAStep')));
        $this->takeAStepMenu->addChild('shareAStep', array('route' => 'shareAStep', 'label' => '3. Share a step and win', 'attributes' => array('class' => 'shareAStep')));
        
        $this->correctTakeAStepCurrent();
        $this->correctShareAStepCurrent();
        
        return $this->takeAStepMenu;
    }
    
     public function correctTakeAStepCurrent()
     {
        if(isset($this->path[1]) && $this->path[1] == "take-a-step")
        {
            $this->takeAStepMenu->getChild('takeAStep')->setCurrent(true);            
        }        
    }
     public function correctShareAStepCurrent()
     {
        if(isset($this->path[1]) && $this->path[1] == "share-a-step")
        {
            $this->takeAStepMenu->getChild('shareAStep')->setCurrent(true);            
        }        
    }
    
    public function mainMenu(FactoryInterface $factory)
    {
        $this->mainMenu = $factory->createItem('root');
        $this->mainMenu->setCurrentUri($this->container->get('request')->getRequestUri());

        $this->mainMenu->addChild('Home', array('route' => 'home'));
        $this->mainMenu->addChild('Find a Step', array('route' => 'findAStep'));
        $this->mainMenu->addChild('Community', array('route' => 'communitySteps'));
        $this->mainMenu->addChild('Resources', array('route' => 'resources'));
        
        $this->path = str_replace($this->container->get('request')->getBaseUrl(), '', $this->container->get('request')->getRequestUri());
        $this->path = explode('/', $this->path);

        $this->correctStepCurrent();
        $this->correctHomeCurrent();
        $this->correctResourcesCurrent();
        
        return $this->mainMenu;
    }
    
    
    public function correctStepCurrent()
    {
        if(isset($this->path[1]) && $this->path[1] == "take-a-step")
        {
            $this->mainMenu->getChild('Find a Step')->setCurrent(true);            
        }
        else if(isset($this->path[1]) && $this->path[1] == "find-a-step")
        {
            $this->mainMenu->getChild('Find a Step')->setCurrent(true);            
        }
        else if(isset($this->path[1]) && $this->path[1] == "share-a-step")
        {
            $this->mainMenu->getChild('Find a Step')->setCurrent(true);            
        }
        
    }
     public function correctHomeCurrent()
    {
        if(!isset($this->path[1]))
        {
            $this->mainMenu->getChild('Home')->setCurrent(true);            
        }
        
    }
     public function correctResourcesCurrent()
    {
        if(isset($this->path[1]) && $this->path[1] == "resources")
        {
            $this->mainMenu->getChild('Resources')->setCurrent(true);            
        }
    }
   
}
