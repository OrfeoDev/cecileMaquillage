<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Statut;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture

{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        \Bezhanov\Faker\ProviderCollectionHelper::addAllProvidersTo($faker);

        $user = new User();
        $user->setEmail('user@gmail.com')
            ->setPassword($this->hasher->hashPassword($user, 'password'));

        $manager->persist($user);

        $admin = new User();
        $admin->setEmail('admin@gmail.com')
            ->setPassword($this->hasher->hashPassword($admin, 'password'))
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);


        $status = [
            [
                "libelle" => " Non Traitée",
                "valeur" => "todo "
            ],
            [
                "libelle" => " Taitée",
                "valeur" => "done "
            ],
        ];

        foreach ($status as $arrayStatut) {
            $statut = new Statut();
            $statut->setValeur($arrayStatut["valeur"])
                ->setLibelle($arrayStatut["libelle"])
                ->setContact($this);
            $manager->persist($statut);
        }
        $manager->flush();
    }


}
