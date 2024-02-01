<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnimalRepository::class)
 */
class Animal
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
    private $Nom;

    /**
     * @ORM\ManyToMany(targetEntity=Fromage::class, mappedBy="Animal")
     * @ORM\JoinColumn(onDelete="CASCADE")
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
        return $this->Nom;
    }

    public function setNom(string $nom): self
    {
        $this->Nom = $nom;

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
            $fromage->addAnimal($this);
        }

        return $this;
    }

    public function removeFromage(Fromage $fromage): self
    {
        if ($this->fromages->removeElement($fromage)) {
            $fromage->removeAnimal($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }

}
