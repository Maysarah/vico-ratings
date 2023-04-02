<?php

namespace App\Entity;

use App\Repository\ProjectRatingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProjectRatingRepository::class)]
class ProjectRatings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "project_id", referencedColumnName: 'id' ,nullable: false)]

    private ?Project $project_id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "rating_type_id", referencedColumnName: 'id' ,nullable: false)]
    private ?RatingTypes $rating_type_id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(
        min: 0,
        max: 1000,
        maxMessage: 'The short review cannot be longer than {{ limit }} characters',
    )]
    private ?string $client_note = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\Range(
        notInRangeMessage: 'The rating must be between {{ min }} and {{ max }}.',
        min: 1,
        max: 5
    )]
    private ?int $rating = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjectId(): ?Project
    {
        return $this->project_id;
    }

    public function setProjectId(?Project $project_id): self
    {
        $this->project_id = $project_id;

        return $this;
    }


    public function getRatingTypeId(): ?RatingTypes
    {
        return $this->rating_type_id;
    }

    public function setRatingTypeId(?RatingTypes $rating_type_id): self
    {
        $this->rating_type_id = $rating_type_id;

        return $this;
    }
    public function getClientNote(): ?string
    {
        return $this->client_note;
    }

    public function setClientNote(?string $client_note): self
    {
        $this->client_note = $client_note;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }
}
