<?php

namespace App\DataFixtures;

use App\Entity\Pet;
use App\Entity\PetCategory;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // générer 50 catégories dans la base
        // "Dog n" (n = 1 à 50)
        for ($i = 1; $i <= 50; $i++) {
            $petCategory = new PetCategory();
            $petCategory->setName('Cat ' . $i);

            $manager->persist($petCategory);
        }
        $manager->flush();

        // générer 50 pets et les enregistrer dans la base
        // pour chaque pet, prendre une catégorie aléatoire existante

        $petCategoryRepository = $manager->getRepository(PetCategory::class);
        $petCategories = $petCategoryRepository->findAll();

        $userRepository = $manager->getRepository(User::class);
        $users = $userRepository->findAll();

        for ($i = 1; $i <= 50; $i++) {
            // définir un integer aléatoire
            $randNumberPetCategory = rand(0, count($petCategories) - 1);
            $randNumberUser = rand(0, count($users) - 1);

            $pet = new Pet();
            $pet->setName('Freya ' . $i);
            $pet->setAge(rand(1, 10));
            $pet->setPetCategory($petCategories[$randNumberPetCategory]);
            $pet->setUser($users[$randNumberUser]);

            $manager->persist($pet);
        }

        $manager->flush();
    }
}
