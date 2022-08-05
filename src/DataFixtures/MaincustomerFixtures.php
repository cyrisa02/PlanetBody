<?php

namespace App\DataFixtures;

use App\Entity\Maincustomer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MaincustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $maincustomer = new Maincustomer();
        $maincustomer->setContact('MarketingTeam');
        $manager->persist($maincustomer);

        $manager->flush();
    }
}