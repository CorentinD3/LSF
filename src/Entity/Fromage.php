<?php

namespace App\Entity;

use App\Repository\FromageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\HttpFoundation\File\File as File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=FromageRepository::class)
 * @Vich\Uploadable()
 */
class Fromage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Cette valeur ne doit pas être vide.")
     */
    private $nom;


    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Cette valeur ne doit pas être vide.")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="fromage_images", fileNameProperty="image")
     * @var Image
     * @Assert\Image(
     *     minWidth = "500",
     *     minWidthMessage = "La largeur de l'image est trop petite, ({{ width }}px). largeur minimum attendu : {{ min_width }}px",  
     *     minHeight = "350",
     *     minHeightMessage = "La hauteur de l'image est trop petite, ({{ height }}px). Hauteur minimum attendu : {{ min_height }}px",
     *     mimeTypes = {"image/jpeg", "image/png","image/jpg","image/webp"},
     *     mimeTypesMessage = "Seulement .jpeg .png .jpg"
     * )
     */
    private $imageFile;

    /**
     * @ORM\ManyToMany(targetEntity=Animal::class, inversedBy="fromages")
     */
    private $Animal;

    /**
     * @ORM\Column(type="boolean")
     */
    private $display;

    /**
     * @ORM\ManyToMany(targetEntity=Label::class, inversedBy="fromages")
     */
    private $label;

    /**
     * @ORM\ManyToOne(targetEntity=Pate::class, inversedBy="fromages")
     * @ORM\JoinColumn(nullable=true)
     */
    private $Pate;

    /**
     * @ORM\ManyToOne(targetEntity=Provenance::class, inversedBy="fromages")
     * @ORM\JoinColumn(nullable=true)
     */
    private $Provenance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $matieregrasse;

    /**
     * @ORM\ManyToOne(targetEntity=Lait::class, inversedBy="fromages")
     * @ORM\JoinColumn(nullable=true)
     */
    private $lait;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Slug;


    public function __construct()
    {
        $this->Animal = new ArrayCollection();
        $this->label = new ArrayCollection();

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


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setImageFile(File $file = null)
    {
        $this->imageFile = $file;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($file) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updateAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimal(): Collection
    {
        return $this->Animal;
    }

    public function addAnimal(Animal $animal): self
    {
        if (!$this->Animal->contains($animal)) {
            $this->Animal[] = $animal;
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): self
    {
        $this->Animal->removeElement($animal);

        return $this;
    }

    public function isDisplay(): ?bool
    {
        return $this->display;
    }

    public function setDisplay(bool $display): self
    {
        $this->display = $display;

        return $this;
    }

    /**
     * @return Collection<int, Label>
     */
    public function getLabel(): Collection
    {
        return $this->label;
    }

    public function addLabel(Label $label): self
    {
        if (!$this->label->contains($label)) {
            $this->label[] = $label;
        }

        return $this;
    }

    public function removeLabel(Label $label): self
    {
        $this->label->removeElement($label);

        return $this;
    }


    public function getPate(): ?Pate
    {
        return $this->Pate;
    }

    public function setPate(?Pate $Pate): self
    {
        $this->Pate = $Pate;

        return $this;
    }

    public function removePate(pate $pate): self
    {
        $this->Pate->removeElement($pate);

        return $this;
    }

    public function getProvenance(): ?Provenance
    {
        return $this->Provenance;
    }

    public function setProvenance(?Provenance $Provenance): self
    {
        $this->Provenance = $Provenance;

        return $this;
    }

    public function __toString()
    {

        return $this->nom;
    }

    public function getMatieregrasse(): ?int
    {
        return $this->matieregrasse;
    }

    public function setMatieregrasse(?int $matieregrasse): self
    {
        $this->matieregrasse = $matieregrasse;

        return $this;
    }


    public function getLait(): ?Lait
    {
        return $this->lait;
    }

    public function setLait(?Lait $lait): self
    {
        $this->lait = $lait;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->Slug;
    }

    public function setSlug(?string $Slug): self
    {
        $this->Slug = $Slug;

        return $this;
    }



}
