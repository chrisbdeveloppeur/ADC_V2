<?php

namespace App\Entity;

use App\Repository\OtherAppRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OtherAppRepository::class)
 */
class OtherApp
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $action;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rsdp;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tpx;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $asset;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $balise;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity=Survey::class, inversedBy="otherApps")
     */
    private $survey;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->setAsset('N/A');
        $this->setAction('N/A');
        $this->setRsdp('N/A');
        $this->setName('OtherApp');
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(?string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getRsdp(): ?string
    {
        return $this->rsdp;
    }

    public function setRsdp(?string $rsdp): self
    {
        $this->rsdp = $rsdp;

        return $this;
    }

    public function getTpx(): ?int
    {
        return $this->tpx;
    }

    public function setTpx(?int $tpx): self
    {
        $this->tpx = $tpx;

        return $this;
    }

    public function getAsset(): ?string
    {
        return $this->asset;
    }

    public function setAsset(?string $asset): self
    {
        $this->asset = $asset;

        return $this;
    }

    public function getBalise(): ?string
    {
        return $this->balise;
    }

    public function setBalise(?string $balise): self
    {
        $this->balise = $balise;

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

    public function getSurvey(): ?Survey
    {
        return $this->survey;
    }

    public function setSurvey(?Survey $survey): self
    {
        $this->survey = $survey;

        return $this;
    }
}
