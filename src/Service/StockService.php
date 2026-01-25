<?php

namespace App\Service;

use App\Entity\Lot;
use Doctrine\ORM\EntityManagerInterface;

class StockService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Calcule le nombre de poulets vivants pour un lot
     */
    public function calculerVivants(Lot $lot): int
    {
        $initial = $lot->getNombreInitial();

        // Total morts
        $morts = 0;
        foreach ($lot->getMortalites() as $mort) {
            $morts += $mort->getNombre();
        }

        // Total vendus
        $vendus = 0;
        foreach ($lot->getVentes() as $vente) {
            $vendus += $vente->getNombre();
        }

        // Stock vivant = initial - morts - vendus
        return max($initial - $morts - $vendus, 0);
    }
}
