<?php
// src/Blogger/BlogBundle/DataFixtures/ORM/BlogFixtures.php

namespace eStore\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use eStore\ShopBundle\Entity\Category;

class CategoryFixtures implements FixtureInterface
{
    public function load($manager)
    {
        $category1 = new Category();
        $category1->setName('T-Shirts');
        $category1->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $manager->persist($category1);
      
        $category2 = new Category();
        $category2->setName('Vests');
        $category2->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $manager->persist($category2);
        
        $category3 = new Category();
        $category3->setName('Shirts');
        $category3->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $manager->persist($category3);
        
        $category4 = new Category();
        $category4->setName('Shoes');
        $category4->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $manager->persist($category4);
        
        $category5 = new Category();
        $category5->setName('Pants');
        $category5->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $manager->persist($category5);
        
        $category6 = new Category();
        $category6->setName('Sweatshirts');
        $category6->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $manager->persist($category6);
        
        $category7 = new Category();
        $category7->setName('Hoodies');
        $category7->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $category7->setParent($category6);
        $manager->persist($category7);
        
        $manager->flush();
    }

}