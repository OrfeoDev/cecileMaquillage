<?php

namespace App\DataFixtures;

use App\Entity\Clients;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Liior\Faker\Prices;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        $faker->addProvider(new Prices($faker));

        $clients = new Clients();
        for ($i = 0 ; $i < 100 ; $i++) {
            $clients->setNom($faker->firstName)
                ->setPrenom($faker->lastName)
                ->setMail($faker->email)
                ->setAdresse($faker->address)
                ->setCodepostal('34000')
                ->setTelephone($faker->phoneNumber);

            $manager->persist($clients);

        }
        $manager->flush();
        }

    }
