<?php
// src/eStore/ShopBundle/DataFixtures/ORM/BrandFixtures.php

namespace eStore\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\Persistence\ObjectManager,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    eStore\ShopBundle\Entity\Brand;

class BrandFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $brand1 = new Brand();
        $brand1->setName('Diesel');
        $manager->persist($brand1);
        
        $brand2 = new Brand();
        $brand2->setName('Gucci');
        $manager->persist($brand2);
        
        $brand3 = new Brand();
        $brand3->setName('Alfani');
        $manager->persist($brand3);
        
        $brand4 = new Brand();
        $brand4->setName('Aquashift');
        $manager->persist($brand4);
        
        $brand5 = new Brand();
        $brand5->setName('FUBU');
        $manager->persist($brand5);   
        
        $manager->flush();
        
        $this->addReference('brand1', $brand1);
        $this->addReference('brand2', $brand2);
        $this->addReference('brand3', $brand3);
        $this->addReference('brand4', $brand4);
        $this->addReference('brand5', $brand5);
    }
    
    /**
     * OrderedFixtureInterface method
     * Specifies in what order fixtures should be loaded
     * 
     * @return int 
     */
    public function getOrder()
    {
        return 4;
    }
}