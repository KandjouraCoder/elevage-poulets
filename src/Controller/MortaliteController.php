<?php

namespace App\Controller;

use App\Entity\Mortalite;
use App\Entity\Lot;
use App\Form\MortaliteType;
use App\Repository\MortaliteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mortalite')]
final class MortaliteController extends AbstractController
{
    #[Route(name: 'app_mortalite_index', methods: ['GET'])]
    public function index(MortaliteRepository $mortaliteRepository): Response
    {
        return $this->render('mortalite/index.html.twig', [
            'mortalites' => $mortaliteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mortalite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mortalite = new Mortalite();
        $form = $this->createForm(MortaliteType::class, $mortalite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mortalite);
            $entityManager->flush();

            return $this->redirectToRoute('app_mortalite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mortalite/new.html.twig', [
            'mortalite' => $mortalite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mortalite_show', methods: ['GET'])]
    public function show(Mortalite $mortalite): Response
    {
        return $this->render('mortalite/show.html.twig', [
            'mortalite' => $mortalite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mortalite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mortalite $mortalite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MortaliteType::class, $mortalite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mortalite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mortalite/edit.html.twig', [
            'mortalite' => $mortalite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mortalite_delete', methods: ['POST'])]
    public function delete(Request $request, Mortalite $mortalite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mortalite->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($mortalite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mortalite_index', [], Response::HTTP_SEE_OTHER);
    }

    // ================================
    // 🔥 NOUVELLE ROUTE : HISTORIQUE PAR LOT
    // ================================
    #[Route('/lot/{id}/historique', name: 'historique_mortalites', methods: ['GET'])]
    public function historiqueParLot(Lot $lot): Response
    {
        $mortalites = $lot->getMortalites();

        $totalMorts = 0;
        foreach ($mortalites as $m) {
            $totalMorts += $m->getNombre();
        }

        return $this->render('mortalite/historique.html.twig', [
            'lot' => $lot,
            'mortalites' => $mortalites,
            'totalMorts' => $totalMorts,
        ]);
    }
}
