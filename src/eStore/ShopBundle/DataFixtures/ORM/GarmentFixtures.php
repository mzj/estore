<?php
// src/Blogger/BlogBundle/DataFixtures/ORM/BlogFixtures.php

namespace eStore\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager,
    eStore\ShopBundle\Entity\Garment;

class GarmentFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $garment1 = new Garment();
        $garment1->setProduct($manager->merge($this->getReference('product1')));
        $garment1->setQuantity(10);
        $garment1->setSize(Garment::SIZE_SMALL);
        $garment1->addColour($manager->merge($this->getReference('colour2')));
        $garment1->addColour($manager->merge($this->getReference('colour4')));
        $manager->persist($garment1);

        $manager->flush();
    }
    
    /**
     * OrderedFixtureInterface method
     * Specifies in what order fixtures should be loaded
     * 
     * @return int 
     */
    public function getOrder()
    {
        return 6;
    }

}