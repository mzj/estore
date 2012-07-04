<?php
// src/Blogger/BlogBundle/DataFixtures/ORM/BlogFixtures.php

namespace eStore\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager,
    eStore\ShopBundle\Entity\Product;

class ProductFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $product1 = new Product();
        $product1->setName('Lime T-Shirt');
        $product1->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis, justo mauris lacinia libero, non facilisis purus ipsum non mi. Aliquam sollicitudin, augue id vestibulum iaculis, sem lectus convallis nunc, vel scelerisque lorem tortor ac nunc. Donec pharetra eleifend enim vel porta.');
        $product1->setPrice(100.22);
        $product1->setGender(Product::GENDER_M);
        $product1->setCreated(new \DateTime());
        $product1->setUpdated($product1->getCreated());
        $product1->addCategory($manager->merge($this->getReference('tshirts')));
        $product1->setBrand($manager->merge($this->getReference('brand3')));
        $manager->persist($product1);
        
        $product2 = new Product();
        $product2->setName('Lionweight');
        $product2->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis, justo mauris lacinia libero, non facilisis purus ipsum non mi. Aliquam sollicitudin, augue id vestibulum iaculis, sem lectus convallis nunc, vel scelerisque lorem tortor ac nunc. Donec pharetra eleifend enim vel porta.');
        $product2->setPrice(100.22);
        $product2->setGender(Product::GENDER_M);
        $product2->setCreated(new \DateTime());
        $product2->setUpdated($product2->getCreated());
        $product2->addCategory($manager->merge($this->getReference('tshirts')));
        $product2->setBrand($manager->merge($this->getReference('brand5')));
        $manager->persist($product2);
        
        $product3 = new Product();
        $product3->setName('King of the Night');
        $product3->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis, justo mauris lacinia libero, non facilisis purus ipsum non mi. Aliquam sollicitudin, augue id vestibulum iaculis, sem lectus convallis nunc, vel scelerisque lorem tortor ac nunc. Donec pharetra eleifend enim vel porta.');
        $product3->setPrice(100.22);
        $product3->setGender(Product::GENDER_W);
        $product3->setCreated(new \DateTime());
        $product3->setUpdated($product3->getCreated());
        $product3->addCategory($manager->merge($this->getReference('vests')));
        $product3->setBrand($manager->merge($this->getReference('brand1')));
        $manager->persist($product3);
        
        $product4 = new Product();
        $product4->setName('Have The Abyss Stare');
        $product4->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis, justo mauris lacinia libero, non facilisis purus ipsum non mi. Aliquam sollicitudin, augue id vestibulum iaculis, sem lectus convallis nunc, vel scelerisque lorem tortor ac nunc. Donec pharetra eleifend enim vel porta.');
        $product4->setPrice(100.22);
        $product4->setGender(Product::GENDER_U);
        $product4->setCreated(new \DateTime());
        $product4->setUpdated($product4->getCreated());
        $product4->addCategory($manager->merge($this->getReference('pants')));
        $product4->setBrand($manager->merge($this->getReference('brand3')));
        $manager->persist($product4);
        
        $product5 = new Product();
        $product5->setName('The Witching Hour');
        $product5->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing eletra electrify denim vel ports.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi ut velocity magna. Etiam vehicula nunc non leo hendrerit commodo. Vestibulum vulputate mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras el mauris eget erat congue dapibus imperdiet justo scelerisque. Nulla consectetur tempus nisl vitae viverra. Cras elementum molestie vestibulum. Morbi id quam nisl. Praesent hendrerit, orci sed elementum lobortis, justo mauris lacinia libero, non facilisis purus ipsum non mi. Aliquam sollicitudin, augue id vestibulum iaculis, sem lectus convallis nunc, vel scelerisque lorem tortor ac nunc. Donec pharetra eleifend enim vel porta.');
        $product5->setPrice(100.22);
        $product5->setGender(Product::GENDER_U);
        $product5->setCreated(new \DateTime());
        $product5->setUpdated($product5->getCreated());
        $product5->addCategory($manager->merge($this->getReference('elasticBanded')));
        $product5->setBrand($manager->merge($this->getReference('brand4')));
        $manager->persist($product5);

        $manager->flush();
        
        $this->addReference('product1', $product1);
        $this->addReference('product2', $product2);
        $this->addReference('product3', $product3);
        $this->addReference('product4', $product4);
        $this->addReference('product5', $product5);
    }
    
    /**
     * OrderedFixtureInterface method
     * Specifies in what order fixtures should be loaded
     * 
     * @return int 
     */
    public function getOrder()
    {
        return 5;
    }

}