<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        
    ){}

    public function load(ObjectManager $manager): void
    {
       $admin = new User();
        $admin->setEmail('cyrisa02.test@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'admin')
        );
        $admin->setName('BodyPlanet');
        $admin->setAddress('2, allée des Anges');
        $admin->setZipcode('02200');
        $admin->setCity('Soissons');
        $admin->setContact('Gourdon');  
        $manager->persist($admin);  

        $faker = Faker\Factory::create('fr_FR');
        for($usr = 1; $usr <= 5; $usr++){
            $user = new User();
                $user->setEmail($faker->email);
                $user->setRoles(['PARTNER']);
                $user->setPassword(
            $this->passwordEncoder->hashPassword($user, 'secret')
        );
            $user->setName($faker->lastName);
            $user->setAddress($faker->streetAddress);
        $user->setZipcode(str_replace(' ', '', $faker->postcode));
        $user->setCity($faker->city); 
         $user->setContact($faker->lastName); 
        $manager->persist($user);  
    }

    for($usr = 1; $usr <= 5; $usr++){
            $user = new User();
                $user->setEmail($faker->email);
                $user->setRoles(['SPORTHALL']);
                $user->setPassword(
            $this->passwordEncoder->hashPassword($user, 'secret')
        );
            $user->setName($faker->lastName);
            $user->setAddress($faker->streetAddress);
        $user->setZipcode(str_replace(' ', '', $faker->postcode));
        $user->setCity($faker->city);  
        $user->setContact($faker->lastName); 
        $manager->persist($user);  
    }
        $manager->flush();
    }
}