<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $dateCreation;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $etat;


    #[ORM\Column(type: 'date', nullable: true)]
    private $dateModification;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: DetailCommande::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private $details;

    public function __construct()
    {
        $this->details = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }

    public function setDateModification(?\DateTimeInterface $dateModification): self
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * @return Collection<int, DetailCommande>
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }


    // si le détail existe déjà, on doit incrementer la quantité.
    // la méthode equals compare deux détails (méthode dans DetailCommande)
    public function addDetail(DetailCommande $detailRajouter): self
    {
        // if (!$this->details->contains($detailRajouter)) {
        //     $this->details[] = $detailRajouter;
        //     $detailRajouter->setCommande($this);
        // }
        foreach ($this->getDetails() as $detailExistant) {
            if ($detailRajouter->equals($detailExistant)) {
                $detailExistant->setQuantite($detailExistant->getQuantite() + $detailRajouter->getQuantite());
                return $this;
            }    
        }
        $this->details[] = $detailRajouter;
        $detailRajouter->setCommande($this);

        return $this;
    }

    public function removeDetail(DetailCommande $detail): self
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getCommande() === $this) {
                $detail->setCommande(null);
            }
        }

        return $this;
    }

    // pour effacer tous les détails
    public function removeDetails(): self
    {
        foreach ($this->getDetails() as $detail) {
            $this->removeDetail($detail);
        }
        return ($this);
    }

    // obtenir le prix de la commande
    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->getDetails() as $detail){
            $total = $total + $detail->getTotal();
        }
        return $total;
    }
}
