<?php
/**
 * User fixtures - For testing purposes
 * 
 * Author: markozjovanovic@gmail.com
 */
namespace eStore\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager,
    Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface,
    eStore\ShopBundle\Entity\User;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * Dependency injection container - DIC
     *  
     * @var ContainerInterface 
     */
    private $container;

    /**
     * 
     * @param ContainerInterface $container 
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    /**
     * Main method for loading fixtures
     * 
     * @param ObjectManager $manager 
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();
        
        $user->setUsername('okram666');
        $user->setEmail('markozjovanovic@gmail.com');
        $user->setPlainPassword('password');
        $user->setEnabled(true);
        $user->addRole(User::ROLE_SUPER_ADMIN);
        
        $userManager->updateUser($user);
        $this->addReference('user-1', $user);
    }
    
    /**
     * OrderedFixtureInterface method
     * Specifies in what order fixtures should be loaded
     * 
     * @return int 
     */
    public function getOrder()
    {
        return 1;
    }
}
