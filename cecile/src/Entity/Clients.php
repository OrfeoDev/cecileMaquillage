<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientsRepository::class)]
class Clients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\Column(length: 255)]
    /**
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre nom ne doit pas contenir de chiffre"
     * )
     */
    private ?string $nom = null;


    #[ORM\Column(length: 255)]
    /**
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre prenom ne doit pas contenir de chiffre"
     * )
     */
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 5)]
    /**
     * @Assert\Regex ("/^[0-9]{5}/")
     *
     */
    private ?string $codepostal = null;

    #[ORM\Column(length: 20)]
    private ?string $telephone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodepostal(): ?string
    {
        return $this->codepostal;
    }

    public function setCodepostal(string $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
}
