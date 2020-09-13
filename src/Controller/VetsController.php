<?php


namespace App\Controller;

use App\Entity\Vet;
use App\Repository\VetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vets")
 */
class VetsController extends AbstractController
{

    private VetRepository $vetRepository;

    public function __construct(VetRepository $vetRepository)
    {
        $this->vetRepository = $vetRepository;
    }

    /**
     * @Route("/list", name="vets_list")
     */
    public function list(): Response
    {
        $vets = $this->vetRepository->findAll();

        return $this->render(
            'veterinarians/vets.html.twig',
            [
                'vets' => $vets
            ]
        );
    }

    /**
     * @Route("/add-vet", name="vets_add")
     * @param Request $request
     *
     * @return Response
     */
    function addOwner(Request $request): Response
    {
        if ($request->get('submit') == 1) {
            $settings = $request->get('settings');

            $owner = Vet::buildVet(
                $settings['first-name'],
                $settings['last-name'],
                $settings['type']
            );

            $this->vetRepository->update($owner);

            $this->addFlash('success',"Vet add successfully.");

            return $this->redirectToRoute('vets_list');
        }

        return $this->render('veterinarians/add-vet.html.twig', []);
    }

    /**
     * @Route("/delete/{id}", name="vets_delete")
     * @param string $id
     *
     * @return Response
     */
    public function deleteVet(string $id): Response
    {
        $vet = $this->vetRepository->find($id);
        $this->vetRepository->remove($vet);

        $this->addFlash('success', 'Vet delete successfully.');

        return $this->redirectToRoute('vets_list');
    }
}