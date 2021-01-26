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

//    /**
//     * @ORM\Column(type="string", length=255, nullable=true)
//     */
//    private $current_hostname;
//
//    /**
//     * @ORM\Column(type="string", length=255, nullable=true)
//     */
//    private $new_hostname;
//
//    /**
//     * @ORM\Column(type="string", length=255, nullable=true)
//     */
//    private $type;
//
//    /**
//     * @ORM\ManyToOne(targetEntity=Survey::class, inversedBy="assets")
//     */
//    private $survey;
//
//    /**
//     * @ORM\Column(type="integer", nullable=true)
//     */
//    private $position;

//    public function __toString()
//    {
//        $this->getCurrentHostname();
//    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrentHostname(): ?string
    {
        return $this->current_hostname;
    }

    public function setCurrentHostname(?string $current_hostname): self
    {
        $this->current_hostname = $current_hostname;

        return $this;
    }

    public function getNewHostname(): ?string
    {
        return $this->new_hostname;
    }

    public function setNewHostname(?string $new_hostname): self
    {
        $this->new_hostname = $new_hostname;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSurvey(): ?Survey
    {
        return $this->survey;
    }

    public function setSurvey(?Survey $survey): self
    {
        $this->survey = $survey;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

}
