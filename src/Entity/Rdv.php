<?php

namespace App\Entity;

use App\Repository\RdvRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RdvRepository::class)
 */
class Rdv
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rdv_total;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rdv_ko_scc;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rdv_ko_safran;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $balise;

    /**
     * @ORM\ManyToOne(targetEntity=Survey::class, inversedBy="rdvs")
     */
    private $survey;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->setRdvTotal(0);
        $this->setRdvKoScc(0);
        $this->setRdvKoSafran(0);
        $this->setName('Rdv');
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

    public function getRdvTotal(): ?int
    {
        return $this->rdv_total;
    }

    public function setRdvTotal(?int $rdv_total): self
    {
        $this->rdv_total = $rdv_total;

        return $this;
    }

    public function getRdvKoScc(): ?int
    {
        return $this->rdv_ko_scc;
    }

    public function setRdvKoScc(?int $rdv_ko_scc): self
    {
        $this->rdv_ko_scc = $rdv_ko_scc;

        return $this;
    }

    public function getRdvKoSafran(): ?int
    {
        return $this->rdv_ko_safran;
    }

    public function setRdvKoSafran(?int $rdv_ko_safran): self
    {
        $this->rdv_ko_safran = $rdv_ko_safran;

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
