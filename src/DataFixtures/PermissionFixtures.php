<?php

namespace App\DataFixtures;

use App\Entity\Permission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PermissionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');

        $permission = new Permission();
        $permission->setName('Vendre des boissons');
        $permission->setIsEnable(mt_rand(0, 1) == 1 ? true : false);
            $manager->persist($permission);

        $permission = new Permission();
        $permission->setName('Gérer le planning des équipe');
        $permission->setIsEnable(mt_rand(0, 1) == 1 ? true : false);
            $manager->persist($permission);

        $permission = new Permission();
        $permission->setName('Envoyer des newletters');
        $permission->setIsEnable(mt_rand(0, 1) == 1 ? true : false);
            $manager->persist($permission);
            
        $permission = new Permission();
        $permission->setName('Vendre des goodies');
        $permission->setIsEnable(mt_rand(0, 1) == 1 ? true : false);
            $manager->persist($permission);
            
        $permission = new Permission();
        $permission->setName('Vendre des barres énergétiques');
        $permission->setIsEnable(mt_rand(0, 1) == 1 ? true : false);
            $manager->persist($permission);    
        

        $manager->flush();
    }
}