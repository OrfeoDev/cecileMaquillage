<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity('email')]
#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 100)]
    /**
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre nom ne doit pas contenir de chiffre"
     * )
     */
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    /**
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Votre prenom ne doit pas contenir de chiffre"
     * )
     */
    private ?string $prenom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;


    #[ORM\Column(length: 150)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 5)]
    private ?int $postalCode = null;

    #[ORM\Column(length: 15)]
    private ?string $telephone = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\GreaterThan('+3 days', message: "La date du mariage doit etre superieure a 10 jours a compter de ce jour ")]
    private ?\DateTimeInterface $jourMariage = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\OneToMany(mappedBy: 'contact', targetEntity: Statut::class)]
    private Collection $statuts;

    public function __construct()
    {
        $this->statuts = new ArrayCollection();
    }


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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(int $postalCode): self
    {
        $this->postalCode = $postalCode;

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

    public function getJourMariage(): ?\DateTimeInterface
    {
        return $this->jourMariage;
    }

    public function setJourMariage(\DateTimeInterface $jourMariage): self
    {
        $this->jourMariage = $jourMariage;

        return $this;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    /**
     * @return Collection<int, Statut>
     */
    public function getStatuts(): Collection
    {
        return $this->statuts;
    }

    public function addStatut(Statut $statut): self
    {
        if (!$this->statuts->contains($statut)) {
            $this->statuts->add($statut);
            $statut->setContact($this);
        }

        return $this;
    }

    public function removeStatut(Statut $statut): self
    {
        if ($this->statuts->removeElement($statut)) {
            // set the owning side to null (unless already changed)
            if ($statut->getContact() === $this) {
                $statut->setContact(null);
            }
        }

        return $this;
    }


}
