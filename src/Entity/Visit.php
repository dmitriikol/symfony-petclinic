<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisitRepository")
 */
class Visit
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pet;

    /**
     * @ORM\Column(type="datetime")
     */
    private $visitDate;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPet(): string
    {
        return $this->pet;
    }

    public function setPet(string $pet)
    {
        $this->pet = $pet;
    }

    public function getVisitDate(): ?\DateTimeInterface
    {
        return $this->visitDate;
    }

    public function setVisitDate(\DateTimeInterface $visitDate)
    {
        $this->visitDate = $visitDate;
    }
}
