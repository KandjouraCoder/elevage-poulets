<?php

namespace App\Entity;

use App\Repository\LotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LotRepository::class)]
class Lot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateEntree = null;

    #[ORM\Column]
    private ?int $nombreInitial = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'lot', targetEntity: Mortalite::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $mortalites;

    #[ORM\OneToMany(mappedBy: 'lot', targetEntity: Vente::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $ventes;

    public function __construct()
    {
        $this->mortalites = new ArrayCollection();
        $this->ventes = new ArrayCollection();
    }

    // ========== Getters / Setters ==========

    public function getId(): ?int { return $this->id; }
    public function getReference(): ?string { return $this->reference; }
    public function setReference(string $reference): self { $this->reference = $reference; return $this; }
    public function getDateEntree(): ?\DateTimeInterface { return $this->dateEntree; }
    public function setDateEntree(\DateTimeInterface $dateEntree): self { $this->dateEntree = $dateEntree; return $this; }
    public function getNombreInitial(): ?int { return $this->nombreInitial; }
    public function setNombreInitial(int $nombreInitial): self { $this->nombreInitial = $nombreInitial; return $this; }
    public function getCreatedAt(): ?\DateTimeInterface { return $this->createdAt; }
    public function setCreatedAt(\DateTimeInterface $createdAt): self { $this->createdAt = $createdAt; return $this; }

    // ========== Mortalite ==========

    public function getMortalites(): Collection { return $this->mortalites; }
    public function addMortalite(Mortalite $mortalite): self
    {
        if (!$this->mortalites->contains($mortalite)) {
            $this->mortalites->add($mortalite);
            $mortalite->setLot($this);
        }
        return $this;
    }
    public function removeMortalite(Mortalite $mortalite): self
    {
        if ($this->mortalites->removeElement($mortalite)) {
            if ($mortalite->getLot() === $this) {
                $mortalite->setLot(null);
            }
        }
        return $this;
    }

    // ========== Vente ==========

    public function getVentes(): Collection { return $this->ventes; }
    public function addVente(Vente $vente): self
    {
        if (!$this->ventes->contains($vente)) {
            $this->ventes->add($vente);
            $vente->setLot($this);
        }
        return $this;
    }
    public function removeVente(Vente $vente): self
    {
        if ($this->ventes->removeElement($vente)) {
            if ($vente->getLot() === $this) {
                $vente->setLot(null);
            }
        }
        return $this;
    }

    // ========== Méthodes utiles ==========

    public function getTotalVendus(): int
    {
        $total = 0;
        foreach ($this->ventes as $vente) {
            $total += $vente->getNombre();
        }
        return $total;
    }

    public function getSommeVentes(): float
    {
        $total = 0;
        foreach ($this->ventes as $vente) {
            $total += $vente->getNombre() * $vente->getPrixUnitaire();
        }
        return $total;
    }
}
