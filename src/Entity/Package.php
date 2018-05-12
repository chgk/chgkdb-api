<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
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
 *                  "groups"={"packages"}
 *              }
 *          }
 *     },
 *     itemOperations={
 *          "get" = {
 *              "method"= "GET",
 *              "normalization_context"= {
 *                  "groups"={"package"}
 *              }
 *          }
 *     }
 * )
 */
class Package extends TournamentNode
{
    /**
     * @var Group
     *
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="packages")
     * @ORM\JoinColumn(name="ParentId", referencedColumnName="Id", unique=true)
     * @ApiSubresource(maxDepth=1)
     * @Groups({"package"})
     */
    public $group;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Copyright", type="text", length=65535, nullable=true)
     * @Groups({"package"})
     */
    public $copyright;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Info", type="text", length=65535, nullable=true)
     * @Groups({"package"})
     */
    public $info;

    /**
     * @var string|null
     *
     * @ORM\Column(name="URL", type="text", length=255, nullable=true)
     * @Groups({"package"})
     */
    public $url;

    /**
     * @var string|null
     *
     * @ORM\Column(name="FileName", type="string", length=25, nullable=true, options={"fixed"=true})
     * @Groups({"package"})
     */
    public $filename;

    /**
     * @var int|null
     *
     * @ORM\Column(name="RatingId", type="integer", nullable=true)
     * @Groups({"package"})
     */
    public $ratingId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Editors", type="text", length=65535, nullable=true)
     * @Groups({"package"})
     */
    public $editors;

    /**
     * @var string|null
     *
     * @ORM\Column(name="EnteredBy", type="text", length=65535, nullable=true)
     * @Groups({"package"})
     */
    public $enteredBy;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="LastUpdated", type="datetime", nullable=true)
     * @Groups({"package"})
     */
    public $updatedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="PlayedAt", type="date", nullable=true)
     * @Groups({"package"})
     */
    public $playedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="PlayedAt2", type="date", nullable=true)
     * @Groups({"package"})
     */
    public $finishedAt;

    /**
     * @var int|null
     *
     * @ORM\Column(name="KandId", type="integer", nullable=true)
     * @Groups({"package"})
     */
    public $kandId;

    /**
     * @var Question[]
     * @ORM\OneToMany(targetEntity="Tour", mappedBy="package")
     * @ORM\JoinColumn(referencedColumnName="Id")
     * @ApiSubresource(maxDepth=1)
     * @Groups({"package"})
     */
    public $tours;
}
