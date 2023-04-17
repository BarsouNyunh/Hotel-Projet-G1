<?php

namespace App\Entity;

use App\Entity\Commande;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ChambreRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

#[ORM\Entity(repositoryClass: ChambreRepository::class)]
class Chambre
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionCourte = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionLongue = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\Column(length: 4)]
    private ?string $prixJournalier = null;

    #[ORM\OneToMany(mappedBy: 'chambre', targetEntity: Commande::class)]
    private Collection $chambre;

    public function __construct()
    {
        $this->chambre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescriptionCourte(): ?string
    {
        return $this->descriptionCourte;
    }

    public function setDescriptionCourte(string $descriptionCourte): self
    {
        $this->descriptionCourte = $descriptionCourte;

        return $this;
    }

    public function getDescriptionLongue(): ?string
    {
        return $this->descriptionLongue;
    }

    public function setDescriptionLongue(string $descriptionLongue): self
    {
        $this->descriptionLongue = $descriptionLongue;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPrixJournalier(): ?string
    {
        return $this->prixJournalier;
    }

    public function setPrixJournalier(string $prixJournalier): self
    {
        $this->prixJournalier = $prixJournalier;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getChambre(): Collection
    {
        return $this->chambre;
    }

    public function addChambre(Commande $chambre): self
    {
        if (!$this->chambre->contains($chambre)) {
            $this->chambre->add($chambre);
            $chambre->setChambre($this);
        }

        return $this;
    }

    public function removeChambre(Commande $chambre): self
    {
        if ($this->chambre->removeElement($chambre)) {
            // set the owning se to null (unless already changed)
            if ($chambre->getChambre() === $this) {
                $chambre->setChambre(null);
            }
        }

        return $this;
    }
}
