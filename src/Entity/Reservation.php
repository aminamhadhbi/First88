<?php

namespace App\Entity;

use App\Repository\ReservationRepository;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",nullable=false)
     */
    private $id;


    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("today")
     */

    private $date_reseration;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_personne;

    /**
     * @ORM\Column(type="string", length=255 )
     * @Assert\Length(
     * min=4,
     * max=50,
     * minMessage = "nom du produit doit etre au minimum {{ limit }} characters long",
     * maxMessage = "nom du produit doit etre au maximum {{ limit }} characters long")
     *
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurant::class, inversedBy="reservations")
     */
    private $Restaurant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdRestaurant(): ?int
    {
        return $this->id_restaurant;
    }

    public function setIdRestaurant(int $id_restaurant): self
    {
        $this->id_restaurant = $id_restaurant;

        return $this;
    }

    public function getDateReseration(): ?\DateTimeInterface
    {
        return $this->date_reseration;
    }

    public function setDateReseration(\DateTimeInterface $date_reseration): self
    {
        $this->date_reseration = $date_reseration;

        return $this;
    }

    public function getNbPersonne(): ?int
    {
        return $this->nb_personne;
    }

    public function setNbPersonne(int $nb_personne): self
    {
        $this->nb_personne = $nb_personne;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->Restaurant;
    }

    public function setRestaurant(?Restaurant $Restaurant): self
    {
        $this->Restaurant = $Restaurant;

        return $this;
    }



}
