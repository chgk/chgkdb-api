<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Group
 *
 * @ORM\Entity
 * @ApiResource(
 *     collectionOperations={"get"={"method"="GET"}},
 *     itemOperations={"get"={"method"="GET"}}
 * )
 */
class Group extends TournamentNode
{
    /**
     * @ORM\Column(name="ParentId",type="integer", options={"default":"0"})
     */
    public $parentId;

    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"group"})
     */
    public $id;

   /**
    * @var Package[]
    * @ORM\OneToMany(targetEntity="Package", mappedBy="group")
    * @ORM\JoinColumn(referencedColumnName="ParentId")
    * @ApiSubresource(maxDepth=1)
    * @Groups({"group"})
    */

    public $packages;

    /**
     * @var Group
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="subgroups")
     * @ORM\JoinColumn(name="ParentId", referencedColumnName="Id", unique=true)
     * @ApiSubresource(maxDepth=1)
     */
    public $parentGroup;

    /**
     * @var Group[]
     * @ORM\OneToMany(targetEntity="Group", mappedBy="parentGroup")
     * @ORM\JoinColumn(referencedColumnName="ParentId")
     * @ApiSubresource(maxDepth=1)
     * @Groups({"group"})
     */
    public $subgroups;

    /**
     * @var string
     *
     * @ORM\Column(name="Title", type="text", length=255, nullable=false)
     * @Groups({"group"})
     */
    public $title;

    /**
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Package[]
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * @return Group
     */
    public function getParentGroup(): Group
    {
        return $this->parentGroup;
    }

    /**
     * @return Group[]
     */
    public function getSubgroups(): iterable
    {
        return $this->subgroups;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
