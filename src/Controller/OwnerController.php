<?php


namespace App\Controller;

use App\Entity\Owner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OwnerRepository;
use App\Repository\VisitRepository;

/**
 * @Route("/owners")
 */
class OwnerController extends AbstractController
{

    private OwnerRepository $ownerRepository;
    private VisitRepository $visitRepository;

    public function __construct(OwnerRepository $ownerRepository, VisitRepository $visitRepository)
    {
        $this->ownerRepository = $ownerRepository;
        $this->visitRepository = $visitRepository;
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
            'owner'  => $owner,
            'visits' => $this->visitRepository->findAll()
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

    /**
     * @Route("/update/{id}", name="owners_update")
     * @param Request $request
     * @param string $id
     *
     * @return Response
     */
    public function updateOwner(Request $request, string $id): Response
    {

        $owner = $this->ownerRepository->get($id);

        if ($request->get('submit') == 1) {
            $settings = $request->get('settings');

            $owner->setFirstName($settings['first-name']);
            $owner->setLastName($settings['last-name']);
            $owner->setAddress($settings['address']);
            $owner->setCity($settings['city']);
            $owner->setPhone($settings['phone']);

            $this->ownerRepository->update($owner);

            $this->addFlash('success',"Owner update successfully.");

            return $this->redirectToRoute('owners_list');
        }

        return $this->render('owners/update-owner.html.twig', [
            'owner' => $owner
        ]);
    }
}