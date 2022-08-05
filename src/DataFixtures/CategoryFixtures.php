<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category -> setName('Activation d\'option ');
         $manager->persist($category);
 
        $category = new Category();
        $category -> setName('Désactivation d\'option ');
         $manager->persist($category);

         $category = new Category();
        $category -> setName('Création de compte franchisé ');
         $manager->persist($category);

         $category = new Category();
        $category -> setName('Activation de compte franchisé ');
         $manager->persist($category);
 
         $category = new Category();
        $category -> setName('Désactivation de compte franchisé ');
         $manager->persist($category);

          $category = new Category();
        $category -> setName('Suppression de compte franchisé ');
         $manager->persist($category);

        $category = new Category();
        $category -> setName('Création de compte salle de sport ');
         $manager->persist($category);

         $category = new Category();
        $category -> setName('Activation de compte salle de sport ');
         $manager->persist($category);
 
         $category = new Category();
        $category -> setName('Désactivation de compte salle de sport ');
         $manager->persist($category);

          $category = new Category();
        $category -> setName('Suppression de compte salle de sport ');
         $manager->persist($category);
        

        $manager->flush();
    }
}