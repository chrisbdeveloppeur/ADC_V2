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
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $proximity;

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
    private $hostname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $new_user;

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


    public function __construct()
    {
        $this->quantity = 1;
        $this->duration = 1;
        $this->asset_type = "Non communiqué";
        $this->proximity = "Non communiqué";
        $this->timestamp = new \DateTime('', new \DateTimeZone('Europe/Paris'));
        $this->date_string = new \DateTime('', new \DateTimeZone('Europe/Paris'));
        $this->assets = new ArrayCollection();
        $this->other_assets = new ArrayCollection();
        $this->apps = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getProximity(): ?string
    {
        return $this->proximity;
    }

    public function setProximity(string $proximity): self
    {
        $this->proximity = $proximity;

        return $this;
    }

    public function getMeetingRespected(): ?bool
    {
        return $this->meeting_respected;
    }

    public function setMeetingRespected(bool $meeting_respected): self
    {
        $this->meeting_respected = $meeting_respected;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
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

    public function getHostname(): ?string
    {
        return $this->hostname;
    }

    public function setHostname(?string $hostname): self
    {
        $this->hostname = $hostname;

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

}
