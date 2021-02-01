<?php

namespace App\Entity;

use App\Repository\SurveyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\DateType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SurveyRepository::class)
 */
class Survey
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
    private $service;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cas_taskt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cas_inct;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cas;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $meeting_respected;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $final_string;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hashed_string;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_string;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $from_inct;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type_inter;

    /**
     * @ORM\OneToMany(targetEntity=Asset::class, mappedBy="survey")
     */
    private $assets;

    /**
     * @ORM\OneToMany(targetEntity=OtherAsset::class, mappedBy="survey")
     */
    private $other_assets;

    /**
     * @ORM\OneToMany(targetEntity=App::class, mappedBy="survey")
     */
    private $apps;

    /**
     * @ORM\OneToMany(targetEntity=OtherApp::class, mappedBy="survey")
     */
    private $otherApps;

    /**
     * @ORM\OneToMany(targetEntity=OtherAction::class, mappedBy="survey")
     */
    private $otherActions;

    public function __construct()
    {
        $this->cas = 'N/A';
        $this->service = 'N/A';
        $this->type = 'N/A';
        $this->type_inter = "N/A";
        $this->cas_inct = 'N/A';
        $this->cas_taskt = 'N/A';
        $this->commentaire = 'N/A';
        $this->setName('Survey');

//        $this->timestamp = new \DateTime('', new \DateTimeZone('Europe/Paris'));
        $this->date_string = new \DateTime('', new \DateTimeZone('Europe/Paris'));
        $this->assets = new ArrayCollection();
        $this->other_assets = new ArrayCollection();
        $this->apps = new ArrayCollection();
        $this->otherApps = new ArrayCollection();
        $this->otherActions = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getTimeStamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimeStamp(): self
    {
        $timestamp = new \DateTime('', new \DateTimeZone('Europe/Paris'));
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getFinalString(): ?string
    {
        return $this->final_string;
    }

    public function setFinalString(?string $final_string): self
    {
        $this->final_string = $final_string;

        return $this;
    }

    public function getHashedString(): ?string
    {
        return $this->hashed_string;
    }

    public function setHashedString(string $hashed_string): self
    {
        $this->hashed_string = hash('crc32', $hashed_string);

        return $this;
    }

    public function getDateString(): ?\DateTimeInterface
    {
        return $this->date_string;
    }

    public function setDateString(\DateTimeInterface $date_string): self
    {
        $this->date_string = $date_string;

        return $this;
    }

    public function getFromInct(): ?string
    {
        return $this->from_inct;
    }

    public function setFromInct(?string $from_inct): self
    {
        $this->from_inct = $from_inct;

        return $this;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(?string $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getTypeInter(): ?string
    {
        return $this->type_inter;
    }

    public function setTypeInter(?string $type_inter): self
    {
        $this->type_inter = $type_inter;

        return $this;
    }

    /**
     * @return Collection|Asset[]
     */
    public function getAssets(): Collection
    {
        return $this->assets;
    }

    public function addAsset(Asset $asset): self
    {
        if (!$this->assets->contains($asset)) {
            $this->assets[] = $asset;
            $asset->setSurvey($this);
        }

        return $this;
    }

    public function removeAsset(Asset $asset): self
    {
        if ($this->assets->removeElement($asset)) {
            // set the owning side to null (unless already changed)
            if ($asset->getSurvey() === $this) {
                $asset->setSurvey(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OtherAsset[]
     */
    public function getOtherAssets(): Collection
    {
        return $this->other_assets;
    }

    public function addOtherAsset(OtherAsset $otherAsset): self
    {
        if (!$this->other_assets->contains($otherAsset)) {
            $this->other_assets[] = $otherAsset;
            $otherAsset->setSurvey($this);
        }

        return $this;
    }

    public function removeOtherAsset(OtherAsset $otherAsset): self
    {
        if ($this->other_assets->removeElement($otherAsset)) {
            // set the owning side to null (unless already changed)
            if ($otherAsset->getSurvey() === $this) {
                $otherAsset->setSurvey(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|App[]
     */
    public function getApps(): Collection
    {
        return $this->apps;
    }

    public function addApp(App $app): self
    {
        if (!$this->apps->contains($app)) {
            $this->apps[] = $app;
            $app->setSurvey($this);
        }

        return $this;
    }

    public function removeApp(App $app): self
    {
        if ($this->apps->removeElement($app)) {
            // set the owning side to null (unless already changed)
            if ($app->getSurvey() === $this) {
                $app->setSurvey(null);
            }
        }

        return $this;
    }

    public function getCas(): ?string
    {
        return $this->cas;
    }

    public function setCas(?string $cas): self
    {
        $this->cas = $cas;

        return $this;
    }

    public function getCasInct(): ?string
    {
        return $this->cas_inct;
    }

    public function setCasInct(?string $cas_inct): self
    {
        $this->cas_inct = $cas_inct;

        return $this;
    }

    public function getCasTaskt(): ?string
    {
        return $this->cas_taskt;
    }

    public function setCasTaskt(?string $cas_taskt): self
    {
        $this->cas_taskt = $cas_taskt;

        return $this;
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

    /**
     * @return Collection|OtherApp[]
     */
    public function getOtherApps(): Collection
    {
        return $this->otherApps;
    }

    public function addOtherApp(OtherApp $otherApp): self
    {
        if (!$this->otherApps->contains($otherApp)) {
            $this->otherApps[] = $otherApp;
            $otherApp->setSurvey($this);
        }

        return $this;
    }

    public function removeOtherApp(OtherApp $otherApp): self
    {
        if ($this->otherApps->removeElement($otherApp)) {
            // set the owning side to null (unless already changed)
            if ($otherApp->getSurvey() === $this) {
                $otherApp->setSurvey(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OtherAction[]
     */
    public function getOtherActions(): Collection
    {
        return $this->otherActions;
    }

    public function addOtherAction(OtherAction $otherAction): self
    {
        if (!$this->otherActions->contains($otherAction)) {
            $this->otherActions[] = $otherAction;
            $otherAction->setSurvey($this);
        }

        return $this;
    }

    public function removeOtherAction(OtherAction $otherAction): self
    {
        if ($this->otherActions->removeElement($otherAction)) {
            // set the owning side to null (unless already changed)
            if ($otherAction->getSurvey() === $this) {
                $otherAction->setSurvey(null);
            }
        }

        return $this;
    }

}
