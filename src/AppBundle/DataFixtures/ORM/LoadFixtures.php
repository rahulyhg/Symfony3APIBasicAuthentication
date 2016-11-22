<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Book;
use AppBundle\Entity\User;

class LoadFixtures extends AbstractFixture implements ContainerAwareInterface
{
	private $container;

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    	$this->loadBooks($manager);
	}

    private function loadBooks(ObjectManager $manager)
    {
        for ($i=0;$i<20;$i++) {
            $book = new Book();
            $book->setName('Foo Bar');
            $book->setPrice('19.99');
            $manager->persist($book);
        }

        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager)
    {
        $passwordEncoder = $this->container->get('security.password_encoder');
        $userAdmin = new User();
        $userAdmin->setUsername('tony_admin');
        $userAdmin->setEmail('tony_admin@symfony.com');
        $userAdmin->setRoles(['ROLE_API']);
        $encodedPassword = $passwordEncoder->encodePassword($userAdmin, 'admin');
        $userAdmin->setPassword($encodedPassword);
        $manager->persist($userAdmin);
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
