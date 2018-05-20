<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 *
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="Type", type="string")
 * @ORM\DiscriminatorMap({"Т" = "Tour", "Ч" = "Package", "Г" = "Group"})
 * @ORM\Table(
 *     name="Tournaments",
 * )
 */
abstract class TournamentNode
{
    /**
     * @var string
     *
     * @ORM\Column(name="TextId", type="chgkdb_text_id", length=32, nullable=false, options={"fixed"=true})
     * @ORM\Id
     * @Groups({"tour_output", "tour_input", "tours_output", "package_input", "packages_output", "package_output", "group", "groups"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Title", type="text", length=255, nullable=false)
     * @Groups({"tour_output", "tour_input", "tours_output","package_input", "package_output", "packages_output", "group", "groups"})
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CreatedAt", type="date", nullable=false)
     * @Groups({"tour_output", "tour_input", "tours_output", "group", "groups"})
     */
    private $createdAt;

    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $legacyId = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="ParentId", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $parentLegacyId = 0;

    /**
     * @var string
     * @ORM\Column(name="ParentTextId", type="string", length=32, nullable=true, options={"fixed"=true})
     */
    private $parentTextId;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getParentLegacyId(): ?int
    {
        return $this->parentLegacyId;
    }

    /**
     * @param int $parentLegacyId
     */
    public function setParentLegacyId(?int $parentLegacyId): void
    {
        $this->parentLegacyId = $parentLegacyId;
    }

    /**
     * @return int
     */
    public function getLegacyId(): ?int
    {
        return $this->legacyId;
    }

    /**
     * @param int $legacyId
     */
    public function setLegacyId(int $legacyId): void
    {
        $this->legacyId = $legacyId;
    }
}
