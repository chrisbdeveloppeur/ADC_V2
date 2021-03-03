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
    private $resolve_method;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $user_cmdb_dif;

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
    private $other_apps;

    /**
     * @ORM\OneToMany(targetEntity=OtherAction::class, mappedBy="survey")
     */
    private $other_actions;

    /**
     * @ORM\OneToMany(targetEntity=Phone::class, mappedBy="survey")
     */
    private $phones;

    /**
     * @ORM\OneToMany(targetEntity=Cmdb::class, mappedBy="survey")
     */
    private $cmdbs;

    /**
     * @ORM\OneToMany(targetEntity=Rdv::class, mappedBy="survey")
     */
    private $rdvs;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $chemin = [];

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $canceled;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rsdp;


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
        $this->setCanceled(false);
        $this->setResolveMethod('AUTRE');

//        $this->timestamp = new \DateTime('', new \DateTimeZone('Europe/Paris'));
        $this->date_string = new \DateTime('', new \DateTimeZone('Europe/Paris'));
        $this->assets = new ArrayCollection();
        $this->other_assets = new ArrayCollection();
        $this->apps = new ArrayCollection();
        $this->other_apps = new ArrayCollection();
        $this->other_actions = new ArrayCollection();
        $this->phones = new ArrayCollection();
        $this->cmdbs = new ArrayCollection();
        $this->rdvs = new ArrayCollection();
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

    public function addOtherAsset(OtherAsset $other_assets): self
    {
        if (!$this->other_assets->contains($other_assets)) {
            $this->other_assets[] = $other_assets;
            $other_assets->setSurvey($this);
        }

        return $this;
    }

    public function removeOtherAsset(OtherAsset $other_assets): self
    {
        if ($this->other_assets->removeElement($other_assets)) {
            // set the owning side to null (unless already changed)
            if ($other_assets->getSurvey() === $this) {
                $other_assets->setSurvey(null);
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
        return $this->other_apps;
    }

    public function addOtherApp(OtherApp $other_apps): self
    {
        if (!$this->other_apps->contains($other_apps)) {
            $this->other_apps[] = $other_apps;
            $other_apps->setSurvey($this);
        }

        return $this;
    }

    public function removeOtherApp(OtherApp $other_apps): self
    {
        if ($this->other_apps->removeElement($other_apps)) {
            // set the owning side to null (unless already changed)
            if ($other_apps->getSurvey() === $this) {
                $other_apps->setSurvey(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OtherAction[]
     */
    public function getOtherActions(): Collection
    {
        return $this->other_actions;
    }

    public function addOtherAction(OtherAction $other_actions): self
    {
        if (!$this->other_actions->contains($other_actions)) {
            $this->other_actions[] = $other_actions;
            $other_actions->setSurvey($this);
        }

        return $this;
    }

    public function removeOtherAction(OtherAction $other_actions): self
    {
        if ($this->other_actions->removeElement($other_actions)) {
            // set the owning side to null (unless already changed)
            if ($other_actions->getSurvey() === $this) {
                $other_actions->setSurvey(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Phone[]
     */
    public function getPhones(): Collection
    {
        return $this->phones;
    }

    public function addPhone(Phone $phone): self
    {
        if (!$this->phones->contains($phone)) {
            $this->phones[] = $phone;
            $phone->setSurvey($this);
        }

        return $this;
    }

    public function removePhone(Phone $phone): self
    {
        if ($this->phones->removeElement($phone)) {
            // set the owning side to null (unless already changed)
            if ($phone->getSurvey() === $this) {
                $phone->setSurvey(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cmdb[]
     */
    public function getCmdbs(): Collection
    {
        return $this->cmdbs;
    }

    public function addCmdb(Cmdb $cmdb): self
    {
        if (!$this->cmdbs->contains($cmdb)) {
            $this->cmdbs[] = $cmdb;
            $cmdb->setSurvey($this);
        }

        return $this;
    }

    public function removeCmdb(Cmdb $cmdb): self
    {
        if ($this->cmdbs->removeElement($cmdb)) {
            // set the owning side to null (unless already changed)
            if ($cmdb->getSurvey() === $this) {
                $cmdb->setSurvey(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rdv[]
     */
    public function getRdvs(): Collection
    {
        return $this->rdvs;
    }

    public function addRdv(Rdv $rdv): self
    {
        if (!$this->rdvs->contains($rdv)) {
            $this->rdvs[] = $rdv;
            $rdv->setSurvey($this);
        }

        return $this;
    }

    public function removeRdv(Rdv $rdv): self
    {
        if ($this->rdvs->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getSurvey() === $this) {
                $rdv->setSurvey(null);
            }
        }

        return $this;
    }

    public function getChemin(): ?array
    {
        return $this->chemin;
    }

    public function setChemin(?array $chemin): self
    {
        $this->chemin = $chemin;

        return $this;
    }

    public function addUrl($url)
    {
        $this->chemin[] = $url;

        return $this;
    }

    public function searchUrl($url)
    {
        $response = in_array($url, $this->chemin);

        return $response;
    }

    public function getCanceled(): ?bool
    {
        return $this->canceled;
    }

    public function setCanceled(?bool $canceled): self
    {
        $this->canceled = $canceled;

        return $this;
    }

    public function getResolveMethod(): ?string
    {
        return $this->resolve_method;
    }

    public function setResolveMethod(?string $resolve_method): self
    {
        $this->resolve_method = $resolve_method;

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

    public function getUserCmdbDif(): ?string
    {
        return $this->user_cmdb_dif;
    }

    public function setUserCmdbDif(?string $user_cmdb_dif): self
    {
        $this->user_cmdb_dif = $user_cmdb_dif;

        return $this;
    }

}
