<?php

namespace App\Controller;

use App\Entity\Lot;
use App\Entity\Mortalite;
use App\Entity\Vente;
use App\Form\MortaliteType;
use App\Form\VenteType;
use App\Repository\LotRepository;
use App\Service\StockService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(LotRepository $lotRepository, StockService $stockService): Response
    {
        $lots = $lotRepository->findAll();
        $lotsData = [];

        foreach ($lots as $lot) {
            $totalMorts = array_sum(array_map(fn($m) => $m->getNombre(), $lot->getMortalites()->toArray()));
            $totalVendus = array_sum(array_map(fn($v) => $v->getNombre(), $lot->getVentes()->toArray()));

            $lotsData[] = [
                'lot' => $lot,
                'morts' => $totalMorts,
                'vendus' => $totalVendus,
                'stockVivant' => $stockService->calculerVivants($lot),
            ];
        }

        return $this->render('dashboard/index.html.twig', [
            'lotsData' => $lotsData,
        ]);
    }

    #[Route('/lot/{id}/ajouter-mortalite', name: 'ajouter_mortalite')]
    public function ajouterMortalite(Request $request, Lot $lot, EntityManagerInterface $em): Response
    {
        $mortalite = new Mortalite();
        $mortalite->setLot($lot);

        $form = $this->createForm(MortaliteType::class, $mortalite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($mortalite);
            $em->flush();
            $this->addFlash('success', "Mortalité ajoutée pour le lot {$lot->getReference()}");
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('dashboard/form_mortalite.html.twig', [
            'formMortalite' => $form->createView(),
            'lot' => $lot,
        ]);
    }

    #[Route('/lot/{id}/ajouter-vente', name: 'ajouter_vente')]
    public function ajouterVente(Request $request, Lot $lot, EntityManagerInterface $em): Response
    {
        $vente = new Vente();
        $vente->setLot($lot);

        $form = $this->createForm(VenteType::class, $vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($vente);
            $em->flush();
            $this->addFlash('success', "Vente ajoutée pour le lot {$lot->getReference()}");
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('dashboard/form_vente.html.twig', [
            'formVente' => $form->createView(),
            'lot' => $lot,
        ]);
    }
}
