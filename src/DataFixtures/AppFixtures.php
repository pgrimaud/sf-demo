<?php

namespace App\DataFixtures;

use App\Entity\PetCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // générer 50 catégories dans la base
        // "Dog n" (n = 1 à 50)

        $petCategory = new PetCategory();
        $petCategory->setName('Doggo');

        $manager->persist($petCategory);

        $manager->flush();
    }
}
