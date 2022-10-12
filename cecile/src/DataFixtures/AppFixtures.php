<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Status;
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

        for ($c = 0; $c < 10; $c++) {

            $contact = new Contact();
            $contact->setNom($faker->name)
                ->setPrenom($faker->lastName)
                ->setEmail($faker->email)
                ->setAdresse($faker->address)
                ->setPostalCode('34000')
                ->setVille($faker->country)
                ->setTelephone('0467896554')
                ->setDescription($faker->paragraph)
                ->setJourMariage(new \DateTimeImmutable());
            $manager->persist($contact);
        }
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
            $status = new Status();
            $status->setLibelle($arrayStatut["libelle"])
                ->setValeur($arrayStatut["valeur"])
                ->setContact($contact);

            $manager->persist($status);
        }
        $manager->flush();
    }


}
