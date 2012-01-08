<?php

namespace eStore\ShopBundle\Form\Extension\Type;
 
use Symfony\Component\Form\AbstractType;
 
use eStore\ShopBundle\Form\Extension\ChoiceList\CategoryMethodChoiceList;
 
class CategoryMethodType extends AbstractType
{
    private $em;
    
    public function __construct($em) 
    {
        $this->em = $em;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions(array $options)
    {
        $repo = $this->em->getRepository('eStoreShopBundle:Category');
        $categories = $repo->childrenQuery()->getArrayResult();
        unset($categories[0]);
        
        return array(
            'choice_list' => new CategoryMethodChoiceList($categories),
        );
    }
 
    /**
     * {@inheritdoc}
     */
    public function getParent(array $options)
    {
        return 'choice';
    }
 
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'categorymethod';
    }
 
}
