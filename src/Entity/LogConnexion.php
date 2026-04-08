<?php

namespace App\Entity;

use App\Repository\LogConnexionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogConnexionRepository::class)]
class LogConnexion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'logConnexions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\Column]
    private ?\DateTime $TimeConnexion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getTimeConnexion(): ?\DateTime
    {
        return $this->TimeConnexion;
    }

    public function setTimeConnexion(\DateTime $TimeConnexion): static
    {
        $this->TimeConnexion = $TimeConnexion;

        return $this;
    }
}
