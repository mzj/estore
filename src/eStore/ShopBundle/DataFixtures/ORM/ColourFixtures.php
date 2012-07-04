<?php
// src/eStore/ShopBundle/DataFixtures/ORM/ColorFixtures.php

namespace eStore\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\Persistence\ObjectManager,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    eStore\ShopBundle\Entity\Colour;

class ColourFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $colour1 = new Colour();
        $colour1->setName('Red');
        $manager->persist($colour1);
        
        $colour2 = new Colour();
        $colour2->setName('Green');
        $manager->persist($colour2);
        
        $colour3 = new Colour();
        $colour3->setName('Blue');
        $manager->persist($colour3);
        
        $colour4 = new Colour();
        $colour4->setName('White');
        $manager->persist($colour4);
        
        $colour5 = new Colour();
        $colour5->setName('Black');
        $manager->persist($colour5);   
        
        $manager->flush();
        
        $this->addReference('colour1', $colour1);
        $this->addReference('colour2', $colour2);
        $this->addReference('colour3', $colour3);
        $this->addReference('colour4', $colour4);
        $this->addReference('colour5', $colour5);
    }
        
    /**
     * OrderedFixtureInterface method
     * Specifies in what order fixtures should be loaded
     * 
     * @return int 
     */
    public function getOrder()
    {
        return 3;
    }

}