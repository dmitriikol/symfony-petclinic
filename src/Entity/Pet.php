<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PetRepository")
 */
class Pet
{

    use CollectionToArrayConvertor;

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
    private string $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $birthDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $type;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Owner", mappedBy="pets", cascade={"persist", "detach", "merge", "refresh"}, fetch="EXTRA_LAZY")
     * @var Owner[]
     */
    private $owners;

    public function __construct(
        $id,
        $name,
        $birthDate,
        $type
    ){
        $this->id = $id;
        $this->name = $name;
        $this->birthDate = $birthDate;
        $this->type = $type;
        $this->owners = new ArrayCollection();
    }

    public static function buildPet(
        $name,
        $birthDate,
        $type
    ): self
    {
        return new self(
            Uuid::uuid4(),
            $name,
            $birthDate,
            $type
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBirthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return Owner[]
     */
    public function getOwners(): array
    {
        return $this->toArrayProperty($this->owners);
    }

    public function addOwner(Owner $owner): void
    {
        if (!$this->owners->contains($owner)) {
            $this->owners[] = $owner;
            $owner->addPet($this);
        }
    }

    public function removeOwner(Owner $owner): void
    {
        if ($this->owners->contains($owner)) {
            $this->owners->removeElement($owner);
            $owner->removePet($this);
        }
    }
}
