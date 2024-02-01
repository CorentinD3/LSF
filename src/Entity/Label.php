<?php

namespace App\Entity;

use App\Repository\LabelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LabelRepository::class)
 */
class Label
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
     * @ORM\ManyToMany(targetEntity=Fromage::class, mappedBy="label")
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
            $fromage->addLabel($this);
        }

        return $this;
    }

    public function removeFromage(Fromage $fromage): self
    {
        if ($this->fromages->removeElement($fromage)) {
            $fromage->removeLabel($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }
}
