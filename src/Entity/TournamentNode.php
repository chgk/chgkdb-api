<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="Type", type="string")
 * @ORM\DiscriminatorMap({"Т" = "Tour", "Ч" = "Package", "Г" = "Group"})
 * @ORM\Table(name="Tournaments", uniqueConstraints={@ORM\UniqueConstraint(name="TournamentTextId", columns={"TextId"})}, indexes={@ORM\Index(name="TournamentIdKey", columns={"Id"}), @ORM\Index(name="TournamentsParentIdKey", columns={"ParentId"}), @ORM\Index(name="FileNameKey", columns={"FileName"})})
 */
abstract class TournamentNode
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"group","groups","package","packages"})
     */
    public $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Title", type="text", length=255, nullable=false)
     * @Groups({"group","groups","package","packages"})
     */
    public $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TextId", type="string", length=16, nullable=true, options={"fixed"=true})
     * @Groups({"group","groups","package","packages"})
     */
    public $textId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CreatedAt", type="date", nullable=false)
     * @Groups({"group","groups","package","packages"})
     */
    public $createdAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return null|string
     */
    public function getTextId(): ?string
    {
        return $this->textId;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}
