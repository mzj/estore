<?php

namespace eStore\ShopBundle\Form\Extension\ChoiceList;
 
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface;
 
use eStore\ShopBundle\Entity\Category;
 
class CategoryMethodChoiceList implements ChoiceListInterface
{
    private $choices;
    
    public function __construct($choices)
    {
        $this->choices = $choices;
    }
    
    public function getChoices()
    {
        return $this->choices;
    }
}