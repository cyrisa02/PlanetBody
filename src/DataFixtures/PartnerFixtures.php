<?php

namespace App\DataFixtures;

use App\Entity\Partner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PartnerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for($usr = 1; $usr <= 5; $usr++){
            $partner = new Partner();
            $partner->setContact($faker->lastName);
            $partner->setContract($faker->lastName);
            $partner->setIsEnable(mt_rand(0, 1) == 1 ? true : false);
            $manager->persist($partner);  
        }
        $manager->flush();
    }
}