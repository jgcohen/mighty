<?php

namespace App\Entity;

use App\Repository\EventsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventsRepository::class)
 */
class Events
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $illustration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $secondIllustration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thirdIllustration;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getSecondIllustration(): ?string
    {
        return $this->secondIllustration;
    }

    public function setSecondIllustration(?string $secondIllustration): self
    {
        $this->secondIllustration = $secondIllustration;

        return $this;
    }

    public function getThirdIllustration(): ?string
    {
        return $this->thirdIllustration;
    }

    public function setThirdIllustration(string $thirdIllustration): self
    {
        $this->thirdIllustration = $thirdIllustration;

        return $this;
    }
}
