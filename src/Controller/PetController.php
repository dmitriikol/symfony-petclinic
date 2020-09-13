<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pet;
use App\Repository\OwnerRepository;
use App\Repository\PetRepository;

/**
 * @Route("/pet")
 */
class PetController extends AbstractController
{

    private OwnerRepository $ownerRepository;
    private PetRepository $petRepository;

    public function __construct(OwnerRepository $ownerRepository, PetRepository $petRepository)
    {
        $this->ownerRepository = $ownerRepository;
        $this->petRepository = $petRepository;
    }

    /**
     * @Route("/add-pet/{ownerId}", name="pet_add")
     * @param Request $request
     * @param string $ownerId
     *
     * @return Response
     * @throws \Exception
     */
    public function addPet(Request $request, string $ownerId): Response
    {
        $owner = $this->ownerRepository->get($ownerId);

        if ($request->get('submit') == 1) {
            $settings = $request->get('settings');

            $pet = Pet::buildPet(
                $settings['name'],
                \DateTime::createFromFormat('Y-d-m', $settings['birthDate']),
                $settings['type']
            );

            $pet->addOwner($owner);
            $owner->addPet($pet);
            $this->petRepository->update($pet);
            $this->ownerRepository->update($owner);

            return $this->redirectToRoute('owners_profile', [
                'id' => $ownerId
            ]);
        }

        return $this->render(
            'pets/add-pet.html.twig',
            [
                'owner' => $owner
            ]
        );
    }

    /**
     * @Route("/update-pet/{ownerId}/{petId}", name="pet_update")
     * @param Request $request
     * @param string $ownerId
     * @param string $petId
     *
     * @return Response
     * @throws \Exception
     */
    public function updatePet(Request $request, string $ownerId, string $petId): Response
    {
        $owner = $this->ownerRepository->get($ownerId);
        $pet = $this->petRepository->get($petId);

        if ($request->get('submit') == 1) {
            $settings = $request->get('settings');

            $pet->setName($settings['name']);
            $pet->setBirthDate(\DateTime::createFromFormat('Y-d-m', $settings['birthDate']));
            $pet->setType($settings['type']);

            $this->petRepository->update($pet);

            return $this->redirectToRoute('owners_profile', [
                'id' => $ownerId
            ]);
        }

        return $this->render(
            'pets/update-pet.html.twig',
            [
                'owner' => $owner,
                'pet'   => $pet
            ]
        );
    }
}