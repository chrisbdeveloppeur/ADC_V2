<?php

namespace App\Entity;

use App\Repository\AssetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AssetRepository::class)
 * @
 */
class Asset
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hostname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identifiant;

    public function __toString()
    {
        return $this->getHostname();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHostname(): ?string
    {
        return $this->hostname;
    }

    public function setHostname(?string $hostname): self
    {
        $this->hostname = $hostname;

        return $this;
    }

    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    public function setIdentifiant(?string $identifiant): self
    {
        $this->identifiant = $identifiant;

        return $this;
    }
}
