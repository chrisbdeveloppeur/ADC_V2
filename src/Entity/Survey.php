<?php

namespace App\Entity;

use App\Repository\SurveyRepository;
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
     * @ORM\Column(type="string", length=255)
     */
    private $type;

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
    private $asset_type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $new_asset;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $old_asset;

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

    public function __construct()
    {
        $this->quantity = 1;
        $this->duration = 1;
        $this->asset_type = "Non communiqué";
        $this->proximity = "Non communiqué";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
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

    public function getAssetType(): ?string
    {
        return $this->asset_type;
    }

    public function setAssetType(string $asset_type): self
    {
        $this->asset_type = $asset_type;

        return $this;
    }

    public function getNewAsset(): ?string
    {
        return $this->new_asset;
    }

    public function setNewAsset(string $new_asset): self
    {
        $this->new_asset = $new_asset;

        return $this;
    }

    public function getOldAsset(): ?string
    {
        return $this->old_asset;
    }

    public function setOldAsset(?string $old_asset): self
    {
        $this->old_asset = $old_asset;

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
}
