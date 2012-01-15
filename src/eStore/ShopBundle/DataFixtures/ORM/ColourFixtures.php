<?php
// src/Blogger/BlogBundle/DataFixtures/ORM/BlogFixtures.php

namespace eStore\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use eStore\ShopBundle\Entity\Product;
use eStore\ShopBundle\Entity\Category;
use eStore\ShopBundle\Entity\Colour;

class ColourFixtures extends AbstractFixture
{
    public function load($manager)
    {
        
        $red = new Colour();
        $red->setName('Red');
        $manager->persist($red);
        
        $green = new Colour();
        $green->setName('Green');
        $manager->persist($green);
        
        $blue = new Colour();
        $blue->setName('Blue');
        $manager->persist($blue);
        
        $white = new Colour();
        $white->setName('White');
        $manager->persist($white);
        
        $black = new Colour();
        $black->setName('Black');
        $manager->persist($black);   
        
        $manager->flush();
    }
}