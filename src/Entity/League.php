<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LeagueRepository")
 * @UniqueEntity("Name")
 */
class League
{

  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
    private $id;

    /**
     * @Assert\NotBlank()
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "League name must be at least {{ limit }} characters
     *   long", maxMessage = "league name cannot be longer than {{ limit }}
     *   characters"
     * )
     *
     * @ORM\Column(type="string", length=50)
     */
    private $Name;

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
}
