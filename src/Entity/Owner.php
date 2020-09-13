<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OwnerRepository")
 */
class Owner
{

    use CollectionToArrayConvertor;

    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Pet", inversedBy="owners", fetch="EXTRA_LAZY", cascade={"all"})
     * @var Pet[]
     */
    private $pets;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, options={"default":"null"})
     */
    private $city;

    public function __construct(
        string $id,
        string $firstName,
        string $lastName,
        string $address,
        string $city,
        string $phone
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
        $this->city = $city;
        $this->phone = $phone;
        $this->pets = new ArrayCollection();
    }

    public static function buildOwner(
        string $firstName,
        string $lastName,
        string $address,
        string $city,
        string $phone
    ): self
    {
        return new self(
            Uuid::uuid4(),
            $firstName,
            $lastName,
            $address,
            $city,
            $phone
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Pet[]
     */
    public function getPets(): array
    {
        return $this->toArrayProperty($this->pets);
    }

    public function addPet(Pet $pet)
    {
        if (!$this->pets->contains($pet)) {
            $this->pets[] = $pet;
        }
    }

    public function removePet(Pet $pet)
    {
        if ($this->pets->contains($pet)) {
            $this->pets->removeElement($pet);
        }
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }
}
