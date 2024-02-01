<?php

namespace App\Entity;

use App\Repository\ProvenanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProvenanceRepository::class)
 */
class Provenance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $departement;

    /**
     * @ORM\OneToMany(targetEntity=Fromage::class, mappedBy="Provenance", cascade={"remove"})
     */
    private $fromages;

    public function __construct()
    {
        $this->fromages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * @return Collection<int, Fromage>
     */
    public function getFromages(): Collection
    {
        return $this->fromages;
    }

    public function addFromage(Fromage $fromage): self
    {
        if (!$this->fromages->contains($fromage)) {
            $this->fromages[] = $fromage;
            $fromage->setProvenance($this);
        }

        return $this;
    }

    public function removeFromage(Fromage $fromage): self
    {
        if ($this->fromages->removeElement($fromage)) {
            // set the owning side to null (unless already changed)
            if ($fromage->getProvenance() === $this) {
                $fromage->setProvenance(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getDepartement();
    }
}
