<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Tournaments
 *
 * @ORM\Entity
 * @ApiResource(
 *     collectionOperations={
 *          "get" = {
 *              "method"= "GET",
 *              "normalization_context"= {
 *                  "groups"={"packages_output"}
 *              }
 *          },
 *          "post" = {
 *              "method" = "POST",
 *          }
 *     },
 *     itemOperations={
 *          "get" = {
 *              "method"= "GET",
 *              "normalization_context"= {
 *                  "groups"={"package_output"}
 *              }
 *          },
 *          "put" = {
 *              "method"="PUT",
 *              "normalization_context"={"groups"={"package_input"}}
 *          },
 *          "delete" = {"method"="DELETE"}
 *     },
 *     attributes={
 *      "denormalization_context"={"groups"={"package_input"}}
 *     }
 * )
 */
class Package extends TournamentNode
{
    public function __construct()
    {
        $this->tours = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @var Group
     *
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="packages")
     * @ORM\JoinColumn(name="ParentTextId", referencedColumnName="TextId")
     * @Groups({"package_input", "package_output"})
     */
    public $group;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Copyright", type="text", length=65535, nullable=true)
     * @Groups({"package_input", "package_output", "packages_output"})
     */
    private $copyright;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Info", type="text", length=65535, nullable=true)
     * @Groups({"package_input", "package_output", "packages_output"})
     */
    private $info;

    /**
     * @var string|null
     *
     * @ORM\Column(name="URL", type="text", length=255, nullable=true)
     * @Groups({"package_input", "package_output", "packages_output"})
     */
    private $url;

    /**
     * @var string|null
     *
     * @ORM\Column(name="FileName", type="string", length=25, nullable=true, options={"fixed"=true})
     * @Groups({"package_input", "package_output", "packages_output"})
     */
    private $filename;

    /**
     * @var int|null
     *
     * @ORM\Column(name="RatingId", type="integer", nullable=true)
     * @Groups({"package_input", "package_output", "packages_output"})
     */
    private $ratingId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Editors", type="text", length=65535, nullable=true)
     * @Groups({"package_input", "package_output", "packages_output"})
     */
    private $editors;

    /**
     * @var string|null
     *
     * @ORM\Column(name="EnteredBy", type="text", length=65535, nullable=true)
     * @Groups({"package_input", "package_output", "packages_output"})
     */
    private $enteredBy;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="LastUpdated", type="datetime", nullable=true)
     * @Groups({"package_input", "package_output", "packages_output"})
     */
    private $updatedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="PlayedAt", type="date", nullable=true)
     * @Groups({"package_input", "package_output", "packages_output"})
     */
    private $playedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="PlayedAt2", type="date", nullable=true)
     * @Groups({"package_input", "package_output", "packages_output"})
     */
    private $finishedAt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="KandId", type="integer", nullable=true)
     * @Groups({"package_input", "package_output", "packages_output"})
     */
    private $kandId;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Tour", mappedBy="package", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(referencedColumnName="ParentTextId")
     * @ApiSubresource(maxDepth=1)
     * @Groups({"package_input", "package_output"})
     */
    private $tours;

    /**
     * @var int|null
     * @ORM\Column(name="PublishedBy", type="integer", nullable=true)
     * @Groups({"package_input", "package_output", "packages_output"})
     */
    private $publishedBy;

    /**
     * @return null|string
     */
    public function getCopyright(): ?string
    {
        return $this->copyright;
    }

    /**
     * @param null|string $copyright
     */
    public function setCopyright(?string $copyright): void
    {
        $this->copyright = $copyright;
    }

    /**
     * @return null|string
     */
    public function getInfo(): ?string
    {
        return $this->info;
    }

    /**
     * @param null|string $info
     */
    public function setInfo(?string $info): void
    {
        $this->info = $info;
    }

    /**
     * @return null|string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param null|string $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return null|string
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param null|string $filename
     */
    public function setFilename(?string $filename): void
    {
        $this->filename = $filename;
    }

    /**
     * @return int|null
     */
    public function getRatingId(): ?int
    {
        return $this->ratingId;
    }

    /**
     * @param int|null $ratingId
     */
    public function setRatingId(?int $ratingId): void
    {
        $this->ratingId = $ratingId;
    }

    /**
     * @return null|string
     */
    public function getEditors(): ?string
    {
        return $this->editors;
    }

    /**
     * @param null|string $editors
     */
    public function setEditors(?string $editors): void
    {
        $this->editors = $editors;
    }

    /**
     * @return null|string
     */
    public function getEnteredBy(): ?string
    {
        return $this->enteredBy;
    }

    /**
     * @param null|string $enteredBy
     */
    public function setEnteredBy(?string $enteredBy): void
    {
        $this->enteredBy = $enteredBy;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime|null $updatedAt
     */
    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getPlayedAt(): ?\DateTime
    {
        return $this->playedAt;
    }

    /**
     * @param \DateTime|null $playedAt
     */
    public function setPlayedAt(?\DateTime $playedAt): void
    {
        $this->playedAt = $playedAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getFinishedAt(): ?\DateTime
    {
        return $this->finishedAt;
    }

    /**
     * @param \DateTime|null $finishedAt
     */
    public function setFinishedAt(?\DateTime $finishedAt): void
    {
        $this->finishedAt = $finishedAt;
    }

    /**
     * @return int|null
     */
    public function getKandId(): ?int
    {
        return $this->kandId;
    }

    /**
     * @param int|null $kandId
     */
    public function setKandId(?int $kandId): void
    {
        $this->kandId = $kandId;
    }

    /**
     * @return ArrayCollection|Tour[]
     */
    public function getTours(): Collection
    {
        return $this->tours;
    }

    /**
     * @param ArrayCollection $tours
     */
    public function setTours(ArrayCollection $tours): void
    {
        $this->tours = $tours;
    }

    public function addTour(Tour $tour)
    {
        $tour->setPackage($this);
        $this->tours->add($tour);
        $tour->setParentLegacyId($this->getLegacyId());
    }

    public function removeTour(Tour $tour)
    {
        $tour->setPackage(null);
        $this->tours->removeElement($tour);
    }
    /**
     * @param int $legacyId
     */
    public function setLegacyId(int $legacyId): void
    {
        parent::setLegacyId($legacyId);
        /** @var Tour $tour */
        foreach ($this->tours as $tour) {
            $tour->setParentLegacyId($legacyId);
        }
    }

    /**
     * @return int|null
     */
    public function getPublishedBy(): ?int
    {
        return $this->publishedBy;
    }

    /**
     * @param int|null $publishedBy
     */
    public function setPublishedBy(?int $publishedBy): void
    {
        $this->publishedBy = $publishedBy;
    }
}
