<?php


namespace App\Controller;

use App\Entity\Owner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OwnerRepository;

/**
 * @Route("/owners")
 */
class OwnerController extends AbstractController
{

    private OwnerRepository $ownerRepository;

    public function __construct(OwnerRepository $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }

    /**
     * @Route("/list", name="owners_list")
     */
    public function list(): Response
    {
        $owners = $this->ownerRepository->findAll();

        return $this->render(
            'owners/owners.html.twig',
            [
                'owners' => $owners
            ]
        );
    }

    /**
     * @Route("/add-owner", name="owners_add_owner")
     * @param Request $request
     *
     * @return Response
     */
    function addOwner(Request $request): Response
    {
        if ($request->get('submit') == 1) {
            $settings = $request->get('settings');

            $owner = Owner::buildOwner(
                $settings['first-name'],
                $settings['last-name'],
                $settings['address'],
                $settings['phone']
            );

            $this->ownerRepository->update($owner);

            $this->addFlash('success',"Owner add");

            return $this->redirectToRoute('owners_list');
        }

        return $this->render('owners/add-owner.html.twig', []);
    }
}