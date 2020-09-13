<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VetRepository")
 */
class Vet
{

    public const DENTISTRY      = 'dentistry';
    public const RADIOLOGY      = 'radiology';
    public const SURGERY        = 'surgery';
    public const DERMATOLOGY    = 'dermatology';
    public const NURSE          = 'nurse';

    public const AVAILABLE_SPECIALITIES = [
        self::DENTISTRY,
        self::RADIOLOGY,
        self::SURGERY,
        self::DERMATOLOGY,
        self::NURSE
    ];

    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     */
    private string $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $Speciality;

    public function __construct(
        $id,
        $firstName,
        $lastName,
        $speciality
    ){
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->Speciality = $speciality;
    }

    public static function buildVet(string $firstName, string $lastName, string $speciality): self
    {
        return new self(
            Uuid::uuid4(),
            $firstName,
            $lastName,
            $speciality
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getSpeciality(): string
    {
        return $this->Speciality;
    }

    public function setSpeciality(string $Speciality): void
    {
        $this->Speciality = $Speciality;
    }
}
