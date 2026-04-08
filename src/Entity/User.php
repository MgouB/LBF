<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Il existe déjà un compte avec cette email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: "Veuillez saisir un email.")]
    #[Assert\Email(message: "Adresse email non valide.")]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez saisir votre nom.")]
    #[Assert\Regex(
        pattern: "/^[A-Za-zÀ-ÖØ-öø-ÿ\s'-]+$/u",
        message: "Le nom ne doit contenir que des lettres, espaces ou tirets."
    )]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez saisir votre prénom.")]
    #[Assert\Regex(
        pattern: "/^[A-Za-zÀ-ÖØ-öø-ÿ\s'-]+$/u",
        message: "Le prénom ne doit contenir que des lettres, espaces ou tirets."
    )]
    private ?string $Prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateInscription = null;

    #[ORM\Column(length : 255)]
    private ?string $Status = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez saisir votre adresse.")]
    #[Assert\Regex(
        pattern: "/^[0-9A-Za-zÀ-ÖØ-öø-ÿ\s,'\-]+$/u",
        message: "L'adresse ne doit contenir que des lettres, chiffres, espaces, virgules ou tirets."
    )]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez saisir votre ville.")]
    #[Assert\Regex(
        pattern: "/^[A-Za-zÀ-ÖØ-öø-ÿ\s'-]+$/u",
        message: "La ville ne doit contenir que des lettres, espaces ou tirets."
    )]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez saisir votre code postal.")]
    #[Assert\Length(
        min: 5,
        max: 6,
        minMessage: "Le code postal doit contenir au moins {{ limit }} chiffres.",
        maxMessage: "Le code postal ne peut pas dépasser {{ limit }} chiffres."
    )]
    #[Assert\Regex(
        pattern: "/^[A-Z0-9]+$/",
        message: "Le code postal ne doit contenir que des chiffres et des lettres majuscules."
    )]
    private ?string $codePostal = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "Veuillez saisir votre numéro de téléphone.")]
    #[Assert\Regex(
        pattern: "/^[0-9\s\+]+$/",
        message: "Le numéro de téléphone ne doit contenir que des chiffres, des espaces ou le signe '+'."
    )]
    private ?string $Telephone = null;

    #[Assert\NotBlank(message: "Le mot de passe est obligatoire.")]
    #[Assert\Length(
        min: 12,
        max: 64,
        minMessage: "Le mot de passe doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le mot de passe ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(pattern: "/[A-Z]/", message: "Le mot de passe doit contenir au moins une lettre majuscule.")]
    #[Assert\Regex(pattern: "/[a-z]/", message: "Le mot de passe doit contenir au moins une lettre minuscule.")]
    #[Assert\Regex(pattern: "/[0-9]/", message: "Le mot de passe doit contenir au moins un chiffre.")]
    #[Assert\Regex(pattern: "/[\W_]/", message: "Le mot de passe doit contenir au moins un caractère spécial (ex : !, ?, @, #, $, %, &...).")]
    #[Assert\NotCompromisedPassword(message: "Ce mot de passe est connu dans des fuites de données. Veuillez en choisir un autre.")]
    private ?string $plainPassword = null;

    #[Assert\NotBlank(message: "Veuillez confirmer votre mot de passe.")]
    #[Assert\Length(
        min: 12,
        max: 64,
        minMessage: "Le mot de passe doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le mot de passe ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(pattern: "/[A-Z]/", message: "Le mot de passe doit contenir au moins une lettre majuscule.")]
    #[Assert\Regex(pattern: "/[a-z]/", message: "Le mot de passe doit contenir au moins une lettre minuscule.")]
    #[Assert\Regex(pattern: "/[0-9]/", message: "Le mot de passe doit contenir au moins un chiffre.")]
    #[Assert\Regex(pattern: "/[\W_]/", message: "Le mot de passe doit contenir au moins un caractère spécial (ex : !, ?, @, #, $, %, &...).")]
    #[Assert\NotCompromisedPassword(message: "Ce mot de passe est connu dans des fuites de données. Veuillez en choisir un autre.")]
    private ?string $plainPassword2 = null;

    #[ORM\OneToMany(targetEntity: Passwords::class, mappedBy: 'User', orphanRemoval: true)]
    private Collection $UserPassword;

    #[ORM\OneToMany(targetEntity: LogConnexion::class, mappedBy: 'User', orphanRemoval: true)]
    private Collection $logConnexions;

    public function __construct()
    {
        $this->UserPassword = new ArrayCollection();
        $this->logConnexions = new ArrayCollection();
    }

    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(string $Telephone): static
    {
        $this->Telephone = $Telephone;
        return $this;
    }

    public function getId(): ?int
    
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
         $this->email = $email;
         return $this
         ;}

    public function getUserIdentifier(): string
    {return (string) $this->email;}

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    { $this->roles = $roles;return $this;}

    public function getPassword(): ?string
    {return $this->password;}

    public function setPassword(string $password): static
    { $this->password = $password;return $this;}

    #[\Deprecated]
    public function eraseCredentials(): void
    {}

    public function getNom(): ?string
    {return $this->Nom;}

    public function setNom(string $Nom): static
    { $this->Nom = $Nom;return $this;}

    public function getPrenom(): ?string
    {return $this->Prenom;}

    public function setPrenom(string $Prenom): static
    { $this->Prenom = $Prenom;return $this;}

    public function getDateInscription(): ?\DateTime
    {return $this->dateInscription;}

    public function setDateInscription(\DateTime $dateInscription): static
    { $this->dateInscription = $dateInscription;return $this;}

    public function getStatus(): ?string
    {return $this->Status;}

    public function setStatus(string $Status): static
    { $this->Status = $Status;return $this;}

    public function getAdresse(): ?string
    {return $this->adresse;}

    public function setAdresse(string $adresse): static
    { $this->adresse = $adresse;return $this;}

    public function getVille(): ?string
    {return $this->ville;}

    public function setVille(string $ville): static
    { $this->ville = $ville;return $this;}

    public function getCodePostal(): ?string
    {return $this->codePostal;}

    public function setCodePostal(string $codePostal): static
    { $this->codePostal = $codePostal;return $this;}

    public function getPlainPassword(): ?string
    {return $this->plainPassword;}

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    public function getPlainPassword2(): ?string
    {return $this->plainPassword2;}

    public function setPlainPassword2(?string $plainPassword2): self
    {
        $this->plainPassword2 = $plainPassword2;
        return $this;
    }

    public function getUserPassword(): Collection
    {return $this->UserPassword;}

    public function addUserPassword(Passwords $userPassword): static
    {
        if (!$this->UserPassword->contains($userPassword)) {
            $this->UserPassword->add($userPassword);
            $userPassword->setUser($this);
        }
        return $this;
    }

    public function removeUserPassword(Passwords $userPassword): static
    {
        if ($this->UserPassword->removeElement($userPassword)) {
            if ($userPassword->getUser() === $this) {
                $userPassword->setUser(null);
            }
        }
        return $this;
    }

    public function getLogConnexions(): Collection
    {return $this->logConnexions;}

    public function addLogConnexion(LogConnexion $logConnexion): static
    {
        if (!$this->logConnexions->contains($logConnexion)) {
            $this->logConnexions->add($logConnexion);
            $logConnexion->setUser($this);
        }
        return $this;
    }

    public function removeLogConnexion(LogConnexion $logConnexion): static
    {
        if ($this->logConnexions->removeElement($logConnexion)) {
            if ($logConnexion->getUser() === $this) {
                $logConnexion->setUser(null);
            }
        }
        return $this;
    }
}
