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
     * @Route("/profile/{id}", name="owners_profile")
     * @param string $id
     *
     * @return Response
     */
    public function profileOwner(string $id): Response
    {
        $owner = $this->ownerRepository->get($id);

        return $this->render('owners/profile.html.twig', [
            'owner' => $owner
        ]);
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
                $settings['city'],
                $settings['phone']
            );

            $this->ownerRepository->update($owner);

            $this->addFlash('success',"Owner add successfully.");

            return $this->redirectToRoute('owners_list');
        }

        return $this->render('owners/add-owner.html.twig', []);
    }

    /**
     * @Route("/delete/{id}", name="owners_delete")
     * @param string $id
     *
     * @return Response
     */
    public function deleteOwner(string $id): Response
    {
        $owner = $this->ownerRepository->find($id);
        $this->ownerRepository->remove($owner);

        $this->addFlash('success', 'Owner delete successfully.');

        return $this->redirectToRoute('owners_list');
    }
}