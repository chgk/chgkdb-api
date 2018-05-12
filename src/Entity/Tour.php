<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Tour
 * @ORM\Entity()
 * @ApiResource(
 *     collectionOperations={"get"={"method"="GET"}},
 *     itemOperations={"get"={"method"="GET"}},
 *     attributes = {
 *         "normalization_context" = {"groups" = {"tour"}}
 *     }
 * )
 */
class Tour extends TournamentNode
{

    /**
     * @var int
     *
     * @ORM\Column(name="ParentId", type="integer", nullable=false, options={"unsigned"=true})
     * @Groups({"tour", "package"})
     */
    public $packageId;


    /**
     * @var int|null
     *
     * @ORM\Column(name="Number", type="smallint", nullable=true, options={"unsigned"=true})
     * @Groups({"tour", "package"})
     */
    public $number;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Copyright", type="text", length=65535, nullable=true)
     * @Groups({"tour", "package"})
     */
    public $copyright;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Info", type="text", length=65535, nullable=true)
     * @Groups({"tour", "package"})
     */
    public $info;

    /**
     * @var string|null
     *
     * @ORM\Column(name="URL", type="text", length=255, nullable=true)
     * @Groups({"tour", "package"})
     */
    public $url;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Editors", type="text", length=65535, nullable=true)
     * @Groups({"tour", "package"})
     */
    public $editors;

    /**
     * @var string|null
     *
     * @ORM\Column(name="EnteredBy", type="text", length=65535, nullable=true)
     * @Groups({"tour", "package"})
     */
    public $enteredBy;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="LastUpdated", type="datetime", nullable=true)
     * @Groups({"tour", "package"})
     */
    public $updatedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="PlayedAt", type="date", nullable=true)
     * @Groups({"tour", "package"})
     */
    public $playedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="PlayedAt2", type="date", nullable=true)
     * @Groups({"tour", "package"})
     */
    public $finishedAt;

    /**
     * @var Question[]
     * @ORM\OneToMany(targetEntity="Question", mappedBy="tour")
     * @ORM\JoinColumn(referencedColumnName="QuestionId")
     * @ApiSubresource(maxDepth=1)
     * @Groups({"tour", "package"})
     */
    public $questions;

    /**
     * @var Package
     *
     * @ORM\ManyToOne(targetEntity="Package", inversedBy="tours")
     * @ORM\JoinColumn(name="ParentId", referencedColumnName="Id", unique=false)
     * @ApiSubresource(maxDepth=1)
     * @Groups({"tour"})
     */
    public $package;
}
