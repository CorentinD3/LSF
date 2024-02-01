<?php

namespace App\Entity;

use App\Repository\PateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PateRepository::class)
 */
class Pate
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
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Fromage::class, mappedBy="Pate", cascade={"remove"} )
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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
            $fromage->setPate($this);
        }

        return $this;
    }

    public function removeFromage(Fromage $fromage): self
    {
        if ($this->fromages->removeElement($fromage)) {
            $fromage->removePate($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }
}
