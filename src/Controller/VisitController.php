<?php


namespace App\Controller;

use App\Entity\Pet;
use App\Entity\Visit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\VisitRepository;
use App\Repository\PetRepository;

/**
 * @Route("/visit")
 */
class VisitController extends AbstractController
{

    private VisitRepository $visitRepository;
    private PetRepository $petRepository;

    public function __construct(VisitRepository $visitRepository, PetRepository $petRepository)
    {
        $this->visitRepository = $visitRepository;
        $this->petRepository = $petRepository;
    }

    /**
     * @Route("/add/{petId}", name="visit_add")
     * @param Request $request
     * @param string $petId
     *
     * @return Response
     * @throws \Exception
     */
    public function addVisit(Request $request, string $petId): Response
    {
        $pet = $this->petRepository->get($petId);
        $owner = $pet->getOwners()[0];

        if($request->get('submit') == 1) {
            $settings = $request->get('settings');

            $visit = Visit::buildVisit(
                $petId,
                \DateTime::createFromFormat('Y-d-m', $settings['birth-date']),
                $settings['description']
            );

            $this->visitRepository->update($visit);

            return $this->redirectToRoute('owners_profile', [
                'id' => $owner->getId()
            ]);
        }

        return $this->render(
            'visits/add-visit.html.twig',
            [
                'pet'        => $pet,
                'owner'      => $owner,
                'visits'     => $this->visitRepository->findBy(['pet' => $petId])
            ]
        );
    }
}