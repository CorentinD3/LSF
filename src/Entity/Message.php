<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{

    public const EMAIL_HIDDEN_INPUT = 'fhjgiz48';
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

     /**
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *       mode="strict"
     * )
     * @Assert\NotBlank()
     */
    private $fhjgiz48;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $objet;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $commentaire;

    /**
     * @ORM\Column(type="date")
     */
    private $date;
    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getFhjgiz48(): ?string
    {
        return $this->fhjgiz48;
    }

    public function setFhjgiz48(string $fhjgiz48): self
    {
         $this->fhjgiz48 = $fhjgiz48;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function __toString()
    {

        return $this->commentaire;
    }
}
