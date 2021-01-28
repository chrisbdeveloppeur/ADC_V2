<?php

namespace App\Entity;

use App\Repository\AppRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AppRepository::class)
 */
class App
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
     * @ORM\ManyToOne(targetEntity=Survey::class, inversedBy="apps")
     */
    private $survey;

    public function getId(): ?int
    {
        return $this->id;
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
