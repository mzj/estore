<?php
// src/eStore/ShopBundle/DataFixtures/ORM/CategoryFixtures.php

namespace eStore\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager,
    eStore\ShopBundle\Entity\Category;

class CategoryFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cat = new Category();
        $cat->setName('root');
        $cat->setDescription('lorem');
            
        $tshirts = new Category();
        $tshirts->setName('T-Shirts');
        $tshirts->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $tshirts->setParent($cat);
        
      
        $vests = new Category();
        $vests->setName('Vests');
        $vests->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $vests->setParent($cat);
        
        
        $shirts = new Category();
        $shirts->setName('Shirts');
        $shirts->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $shirts->setParent($cat);
        
        $longSleeves = new Category();
        $longSleeves->setName('Long sleeves');
        $longSleeves->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $longSleeves->setParent($shirts);
        
        
        $shortSleeves = new Category();
        $shortSleeves->setName('Short sleeves');
        $shortSleeves->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $shortSleeves->setParent($shirts);
        
        
        $elasticBanded = new Category();
        $elasticBanded->setName('Elastic Banded');
        $elasticBanded->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $elasticBanded->setParent($longSleeves);
        
               
        $shoes = new Category();
        $shoes->setName('Shoes');
        $shoes->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $shoes->setParent($cat);
        
        
        $pants = new Category();
        $pants->setName('Pants');
        $pants->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $pants->setParent($cat);
        
        
        $sweatshirts = new Category();
        $sweatshirts->setName('Sweatshirts');
        $sweatshirts->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $sweatshirts->setParent($cat);
        
        $hoodies = new Category();
        $hoodies->setName('Hoodies');
        $hoodies->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. ');
        $hoodies->setParent($sweatshirts);
        
        
        
        $manager->persist($cat);
        $manager->persist($tshirts);
        $manager->persist($vests);
        $manager->persist($shirts);
        $manager->persist($longSleeves);
        $manager->persist($elasticBanded);
        $manager->persist($shortSleeves);
        $manager->persist($shoes);
        $manager->persist($pants);
        $manager->persist($sweatshirts);
        $manager->persist($hoodies);
        
        $manager->flush();
        
        $this->addReference('tshirts',   $tshirts);
        $this->addReference('vests', $vests);
        $this->addReference('shirts', $shirts);
        $this->addReference('longSleeves', $longSleeves);
        $this->addReference('elasticBanded', $elasticBanded);
        $this->addReference('shortSleeves', $shortSleeves);
        $this->addReference('shoes', $shoes);
        $this->addReference('pants', $pants);
        $this->addReference('sweatshirts', $sweatshirts);
        $this->addReference('hoodies', $hoodies);
    }
    
    /**
     * OrderedFixtureInterface method
     * Specifies in what order fixtures should be loaded
     * 
     * @return int 
     */
    public function getOrder()
    {
        return 2;
    }
}