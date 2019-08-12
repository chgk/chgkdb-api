<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Group
 *
 * @ORM\Entity
 * @ApiResource(
 *     attributes={ "normalization_context"= {"groups"={"group"} }}
 * )
 * )
 */
class Group extends TournamentNode
{
   /**
    * @var Package[]
    * @ORM\OneToMany(targetEntity="Package", mappedBy="group")
    * @ORM\JoinColumn(referencedColumnName="ParentTextId")
    * ApiSubresource(maxDepth=1)
    * @Groups({"group", "groups"})
    */
    private $packages;


    /**
     * @var Group[]
     * @ORM\OneToMany(targetEntity="Group", mappedBy="parentGroup")
     * @ORM\JoinColumn(referencedColumnName="ParentTextId")
     */
    private $subgroups;

    /**
     * @var Group
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="subgroups")
     * @ORM\JoinColumn(name="ParentTextId", referencedColumnName="TextId")
     */
    public $parentGroup;


    public function __construct()
    {
        parent::__construct();
        $this->packages = new ArrayCollection();
        $this->subgroups = new ArrayCollection();
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
    public function getParentGroup(): ?Group
    {
        return $this->parentGroup;
    }

    /**
     * @return Group[]|iterable
     * @Groups({"group"})
     */
    public function getSubgroups(): iterable
    {
        return $this->subgroups;
    }


    public function addPackage(Package $package)
    {
        $this->packages->add($package);
    }

    public function removePackage(Package $package)
    {
        $this->packages->removeElement($package);
    }
}
