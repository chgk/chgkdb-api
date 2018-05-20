<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Table(name="Tournaments")
 * @ORM\Entity
 * @ApiResource(
 *     collectionOperations={
 *      "post"={"method"="POST"},
 *      "get"={"method"="GET", "normalization_context"={"groups"={"tours_output"}}, "order"={"Number": "ASC"}},
 *     },
 *     itemOperations={
 *      "get"={"method"="GET", "normalization_context"={"groups"={"tour_output"}}},
 *      "put"={"method"="PUT", "normalization_context"={"groups"={"tour_input"}}},
 *     },
 *     subresourceOperations={
 *      "questions_get_subresource" = {"method"="GET", "normalization_context"={"groups"={"tour_output"}}},
 *     },
 *     attributes={
 *      "denormalization_context"={"groups"={"tour_input"}},
 *      "order"={"number": "ASC"}
 *     }
 * )
 */
class Tour extends TournamentNode
{

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Question", mappedBy="tour", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(referencedColumnName="ParentTextId")
     * @ApiSubresource(
     *     maxDepth=1,
     * )
     * @Groups({"tour_output", "tour_input", "package_output", "package_input"})
     */
    private $questions;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Number", type="smallint", nullable=true, options={"unsigned"=true})
     * @Groups({"tour_output", "tour_input", "tours_output", "package_output","package_input"})
     */
    private $number;

    /**
     * @var Package
     *
     * @ORM\ManyToOne(targetEntity="Package", cascade={"persist"}, inversedBy="tours")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ParentTextId", referencedColumnName="TextId")
     * }
     * )
     * @ApiSubresource(maxDepth=1)
     * @Groups({"tour_input", "tour_output"})
     */
    private $package;


    /**
     * @var string|null
     *
     * @ORM\Column(name="Copyright", type="text", length=65535, nullable=true)
     * @Groups({"tour_output", "tour_input", "tours_output", "package_output","package_input"})
     */
    private $copyright;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Info", type="text", length=65535, nullable=true)
     * @Groups({"tour_output", "tour_input", "tours_output", "package_output","package_input"})
     */
    private $info;

    /**
     * @var string|null
     *
     * @ORM\Column(name="URL", type="text", length=255, nullable=true)
     * @Groups({"tour_output", "tour_input", "tours_output", "package_output", "package_input"})
     */
    private $url;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Editors", type="text", length=65535, nullable=true)
     * @Groups({"tour_output", "tour_input", "tours_output", "package_output", "package_input"})
     */
    private $editors;

    /**
     * @var string|null
     *
     * @ORM\Column(name="EnteredBy", type="text", length=65535, nullable=true)
     * @Groups({"tour_output", "tour_input", "tours_output", "package_output", "package_input"})
     */
    private $enteredBy;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="LastUpdated", type="datetime", nullable=true)
     * @Groups({"tour_output", "tour_input", "tours_output", "package_output", "package_input"})
     */
    private $updatedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="PlayedAt", type="date", nullable=true)
     * @Groups({"tour_output", "tour_input", "tours_output", "package_output", "package_input"})
     */
    private $playedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="PlayedAt2", type="date", nullable=true)
     * @Groups({"tour_output", "tour_input", "tours_output", "package_output", "package_input"})
     */
    private $finishedAt;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        parent::__construct();
    }

    public function addQuestion(Question $question)
    {
        $question->setTour($this);
        $this->questions->add($question);
        $question->setParentLegacyId($this->getLegacyId());
    }

    public function removeQuestion(Question $question)
    {
        $question->setTour(null);
        $this->questions->removeElement($question);
    }

    /**
     * @return Collection
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    /**
     * @return int|`null`
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * @param int|null $number
     */
    public function setNumber(?int $number): void
    {
        $this->number = $number;
    }

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
     * @return Package
     */
    public function getPackage(): ?Package
    {
        return $this->package;
    }

    /**
     * @param Collection $questions
     */
    public function setQuestions(Collection $questions): void
    {
        $this->questions = $questions;
    }

    /**
     * @param Package $package
     */
    public function setPackage(?Package $package): void
    {
        $this->package = $package;
        $this->setParentLegacyId($package?$package->getLegacyId():0);
    }
    /**
     * @param int $legacyId
     */
    public function setLegacyId(int $legacyId): void
    {
        parent::setLegacyId($legacyId);
        /** @var Question $question */
        foreach ($this->questions as $question) {
            $question->setParentLegacyId($legacyId);
        }
    }
}
