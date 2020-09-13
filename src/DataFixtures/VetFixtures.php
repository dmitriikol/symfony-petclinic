<?php

namespace App\DataFixtures;

use App\Entity\Vet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Output\ConsoleOutput;

class VetFixtures extends Fixture
{

    private ConsoleOutput $output;

    public function __construct()
    {
        $this->output = new ConsoleOutput();
    }

    public function load(ObjectManager $manager)
    {
        $this->addVet('James', 'Carter', 'radiology', $manager);
        $this->addVet('Helen', 'Leary', 'surgery', $manager);
        $this->addVet('Linda', 'Douglas', 'none', $manager);
        $this->addVet('Rafael', 'Ortega', 'surgery', $manager);
        $this->addVet('Henry', 'Stevens', 'dentistry ', $manager);

        $manager->flush();
    }

    private function addVet(string $firstName, string $lastName, string $speciality, ObjectManager $manager): void
    {
        $vet = Vet::buildVet(
            $firstName,
            $lastName,
            $speciality
        );
        $manager->persist($vet);
        $this->getOutput()->writeln(
            sprintf(
                'Added "%s" "%s" Vet.',
                $vet->getFirstName(),
                $vet->getLastName(),
            )
        );
    }

    private function getOutput(): ConsoleOutput
    {
        return $this->output;
    }
}
