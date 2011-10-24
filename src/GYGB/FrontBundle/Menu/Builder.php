<?php

namespace GYGB\FrontBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public $mainMenu;
    public $path;
    
    public function mainMenu(FactoryInterface $factory)
    {
        $this->mainMenu = $factory->createItem('root');
        $this->mainMenu->setCurrentUri($this->container->get('request')->getRequestUri());

        $this->mainMenu->addChild('Home', array('route' => 'home'));
        $this->mainMenu->addChild('Find a Step', array('route' => 'findAStep'));
        $this->mainMenu->addChild('Take a Step', array('route' => 'takeAStep'));
        $this->mainMenu->addChild('Share a Step', array('route' => 'shareAStep'));
        //$this->mainMenu->addChild('About', array('route' => 'about'));
        //$this->mainMenu->addChild('Coalition', array('route' => 'coalition'));
        //$this->mainMenu->addChild('Steps and Resources', array('uri' => '../files/GetYourGreenBack.pdf'));
        
        $this->path = str_replace($this->container->get('request')->getBaseUrl(), '', $this->container->get('request')->getRequestUri());
        $this->path = explode('/', $this->path);

        $this->correctFindAStepCurrent();
        $this->correctTakeAStepCurrent();
        $this->correctShareAStepCurrent();
        
        return $this->mainMenu;
    }
    
    public function correctFindAStepCurrent()
    {
        if(isset($this->path[1]) && $this->path[1] == "find-a-step")
        {
            $this->mainMenu->getChild('Find a Step')->setCurrent(true);            
        }
        
    }
    public function correctTakeAStepCurrent()
    {
        if(isset($this->path[1]) && $this->path[1] == "take-a-step")
        {
            $this->mainMenu->getChild('Take a Step')->setCurrent(true);            
        }
        
    }
     public function correctShareAStepCurrent()
    {
        if(isset($this->path[1]) && $this->path[1] == "share-a-step")
        {
            $this->mainMenu->getChild('Share a Step')->setCurrent(true);            
        }
        
    }
}

?>
