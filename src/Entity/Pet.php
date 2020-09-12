<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PetRepository")
 */
class Pet
{

    public const TYPE_DOG      = 'dog';
    public const TYPE_CAT      = 'cat';
    public const TYPE_HAMSTER  = 'hamster';
    public const TYPE_BIRD     = 'bird';
    public const TYPE_SNAKE    = 'snake';

    public const AVAILABLE_TYPES = [
        self::TYPE_BIRD,
        self::TYPE_DOG,
        self::TYPE_CAT,
        self::TYPE_HAMSTER,
        self::TYPE_SNAKE
    ];

    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity=Owner::class, mappedBy="pets")
     */
    private $owners;

    public function __construct()
    {
        $this->owners = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate)
    {
        $this->birthDate = $birthDate;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return Collection|Owner[]
     */
    public function getOwners(): Collection
    {
        return $this->owners;
    }

    public function addOwner(Owner $owner)
    {
        if (!$this->owners->contains($owner)) {
            $this->owners[] = $owner;
            $owner->addPet($this);
        }
    }

    public function removeOwner(Owner $owner)
    {
        if ($this->owners->contains($owner)) {
            $this->owners->removeElement($owner);
            $owner->removePet($this);
        }
    }
}
