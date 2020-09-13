<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisitRepository")
 */
class Visit
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     */
    private string $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $pet;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $visitDate;

    /**
     * @ORM\Column(type="text")
     */
    private string $description;

    private function __construct(
        $id,
        $pet,
        $visitDate,
        $description
    ){
        $this->id = $id;
        $this->pet = $pet;
        $this->visitDate = $visitDate;
        $this->description = $description;
    }

    public static function buildVisit($pet, $visitDate, $description): self
    {
        return new self(
            Uuid::uuid4(),
            $pet,
            $visitDate,
            $description
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPet(): string
    {
        return $this->pet;
    }

    public function setPet(string $pet): void
    {
        $this->pet = $pet;
    }

    public function getVisitDate(): \DateTimeInterface
    {
        return $this->visitDate;
    }

    public function setVisitDate(\DateTimeInterface $visitDate): void
    {
        $this->visitDate = $visitDate;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
