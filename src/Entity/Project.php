<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(name: "creator_id", referencedColumnName: 'id' ,nullable: false)]
    private ?Client $creator_id = null;

    #[ORM\ManyToOne(targetEntity: Vico::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(name: "vico_id", referencedColumnName: 'id' ,nullable: false)]
    private ?Vico $vico_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatorId(): ?Client
    {
        return $this->creator_id;
    }

    public function setCreatorId($creator_id): self
    {
        $this->creator_id = $creator_id;

        return $this;
    }

    public function getVicoId(): ?Vico
    {
        return $this->vico_id;
    }

    public function setVicoId($vico_id): self
    {
        $this->vico_id = $vico_id;

        return $this;
    }
    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }
}
