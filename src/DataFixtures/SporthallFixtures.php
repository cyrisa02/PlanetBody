<?php

namespace App\DataFixtures;

use App\Entity\Sporthall;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class SporthallFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $faker = Faker\Factory::create('fr_FR');
        for($usr = 1; $usr <= 5; $usr++){
            $sporthall = new Sporthall();
            $sporthall->setContact($faker->lastName);            
            $sporthall->setIsEnable(mt_rand(0, 1) == 1 ? true : false);
            $manager->persist($sporthall);  
        }

        $manager->flush();
    }
}