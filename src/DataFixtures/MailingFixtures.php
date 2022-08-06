<?php

namespace App\DataFixtures;

use App\Entity\Mailing;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class MailingFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');

        $mailing = new Mailing();
        $mailing->setTitle('Désactivation de votre option N°???');
        $mailing->setContent($faker->text(15)); 
           
        $manager->persist($mailing);

        $mailing = new Mailing();
        $mailing->setTitle('Activation de votre option N°???');
        $mailing->setContent($faker->text(15));       
        $manager->persist($mailing);

        $mailing = new Mailing();
        $mailing->setTitle('Activation de votre compte N°???');
        $mailing->setContent($faker->text(25));       
        $manager->persist($mailing);

        $mailing = new Mailing();
        $mailing->setTitle('Suppression de votre compte N°???');
        $mailing->setContent($faker->text(25));       
        $manager->persist($mailing);

        $mailing = new Mailing();
        $mailing->setTitle('Activation de votre compte N°???');
        $mailing->setContent($faker->text(25));       
        $manager->persist($mailing);

        $manager->flush();
    }
}