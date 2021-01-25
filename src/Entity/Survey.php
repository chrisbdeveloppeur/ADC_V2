<?php

namespace App\Entity;

use App\Repository\SurveyRepository;
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
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="survey")
     */
    private $User;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hostname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $new_user;

    public function __construct()
    {
        $this->quantity = 1;
        $this->duration = 1;
        $this->asset_type = "Non communiqué";
        $this->proximity = "Non communiqué";
        $this->timestamp = new \DateTime('', new \DateTimeZone('Europe/Paris'));
        $this->date_string = new \DateTime('', new \DateTimeZone('Europe/Paris'));
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

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

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

    public function getNewUser(): ?string
    {
        return $this->new_user;
    }

    public function setNewUser(?string $new_user): self
    {
        $this->new_user = $new_user;

        return $this;
    }

}
