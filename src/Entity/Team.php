<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 * @UniqueEntity("Name")
 */
class Team
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Team name must be at least {{ limit }} characters long",
     *      maxMessage = "Team name cannot be longer than {{ limit }} characters"
     * )     * @ORM\Column(type="string", length=50)
     */
    private $Name;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Team strip must be at least {{ limit }} characters
     *   long", maxMessage = "Team strip be longer than {{ limit }} characters"
     * )     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Strip;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getStrip(): ?string
    {
        return $this->Strip;
    }

    public function setStrip(?string $Strip): self
    {
        $this->Strip = $Strip;

        return $this;
    }
}
