<?php

namespace App\DataFixtures;

use App\Entity\Owner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Output\ConsoleOutput;

class OwnerFixtures extends Fixture
{

    private ConsoleOutput $output;

    public function __construct()
    {
        $this->output = new ConsoleOutput();
    }

    public function load(ObjectManager $manager)
    {
        $this->addOwner('George', 'Franklin', '110 W. Liberty St.', 'Madison', '6085551021', $manager);
        $this->addOwner('Betty', 'Davis', '638 Cardinal Ave.', 'Sun Prairie', '6085551749', $manager);
        $this->addOwner('Jeff', 'Black', '1450 Oak Bldv.', 'Madison', '6085557683', $manager);
        $this->addOwner('David', 'Schroeder', '345 Maple St.', 'Madison', '6085559435', $manager);
        $this->addOwner('Carlos', 'Estaban', '2335 Independence La.', 'Waunakee', '6085555487', $manager);

        $manager->flush();
    }

    private function addOwner(string $firstName, string $lastName, string $address, string $city, string $phone, ObjectManager $manager): void
    {
        $owner = Owner::buildOwner(
            $firstName,
            $lastName,
            $address,
            $city,
            $phone
        );
        $manager->persist($owner);
        $this->getOutput()->writeln(
            sprintf(
                'Added "%s" "%s" Owner.',
                $owner->getFirstName(),
                $owner->getLastName(),
            )
        );
    }

    private function getOutput(): ConsoleOutput
    {
        return $this->output;
    }
}
