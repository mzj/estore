<?php
// src/Blogger/BlogBundle/DataFixtures/ORM/BlogFixtures.php

namespace eStore\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use eStore\ShopBundle\Entity\Category;

class CategoryFixtures implements FixtureInterface
{
    public function load($manager)
    {
        $tshirts = new Category();
        $tshirts->setName('T-Shirts');
        $tshirts->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $manager->persist($tshirts);
        
      
        $vests = new Category();
        $vests->setName('Vests');
        $vests->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $manager->persist($vests);
        
        
        $shirts = new Category();
        $shirts->setName('Shirts');
        $shirts->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $manager->persist($shirts);
        
        $longSleeves = new Category();
        $longSleeves->setName('Long sleeves');
        $longSleeves->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $longSleeves->setParent($shirts);
        $manager->persist($longSleeves);
        
        $elasticBanded = new Category();
        $elasticBanded->setName('Elastic Banded');
        $elasticBanded->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $elasticBanded->setParent($longSleeves);
        $manager->persist($elasticBanded);
        
        $shortSleeves = new Category();
        $shortSleeves->setName('Short sleeves');
        $shortSleeves->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $shortSleeves->setParent($shirts);
        $manager->persist($shortSleeves);
        
        
        $shoes = new Category();
        $shoes->setName('Shoes');
        $shoes->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $manager->persist($shoes);
        
        
        $pants = new Category();
        $pants->setName('Pants');
        $pants->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $manager->persist($pants);
        
        
        $sweatshirts = new Category();
        $sweatshirts->setName('Sweatshirts');
        $sweatshirts->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $manager->persist($sweatshirts);
        
        $hoodies = new Category();
        $hoodies->setName('Hoodies');
        $hoodies->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $hoodies->setParent($sweatshirts);
        $manager->persist($hoodies);
        
        $manager->flush();
    }

}