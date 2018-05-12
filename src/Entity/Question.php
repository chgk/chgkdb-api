<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Questions
 *

 * @ORM\Table(name="Questions", uniqueConstraints={@ORM\UniqueConstraint(name="TextId", columns={"TextId"})}, indexes={@ORM\Index(name="QuestionIdKey", columns={"QuestionId"}), @ORM\Index(name="ParentIdKey", columns={"ParentId"}), @ORM\Index(name="NumberKey", columns={"Number"}), @ORM\Index(name="TypeKey", columns={"Type"}), @ORM\Index(name="TypeNumKey", columns={"TypeNum"})})
 * @ORM\Entity
 * @ApiResource(
 *     collectionOperations={"get"={"method"="GET"}},
 *     itemOperations={"get"={"method"="GET"}},
 *     attributes={
 *      "normalization_context"={"groups"={"question"}}
 *     }
 * )
 */
class Question
{
    /**
     * @var int
     *
     * @ORM\Column(name="QuestionId", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"question", "tour", "package"})
     */
    public $questionId;

    /**
     * @var Tour
     *
     * @ORM\ManyToOne(targetEntity="Tour", inversedBy="questions")
     * @ORM\JoinColumn(name="ParentId", referencedColumnName="Id", unique=true)
     * @ApiSubresource(maxDepth=1)
     * @Groups({"question"})
     */
    public $tour;

    /**
     * @var int
     *
     * @ORM\Column(name="Number", type="smallint", nullable=false, options={"unsigned"=true})
     * @Groups({"question", "tour", "package"})
     */
    public $number;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=5, nullable=false, options={"default"="Ч","fixed"=true})
     * @Groups({"question", "tour", "package"})
     */
    public $type = 'Ч';

    /**
     * @var bool
     *
     * @ORM\Column(name="TypeNum", type="boolean", nullable=false)
     * @Groups({"question", "tour", "package"})
     */
    public $typenum = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="TextId", type="string", length=16, nullable=true, options={"fixed"=true})
     * @Groups({"question", "tour", "package"})
     */
    public $textId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Question", type="text", length=65535, nullable=true)
     * @Groups({"question", "tour", "package"})
     */
    public $question;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Answer", type="text", length=65535, nullable=true)
     * @Groups({"question", "tour", "package"})
     */
    public $answer;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PassCriteria", type="text", length=65535, nullable=true)
     * @Groups({"question", "tour", "package"})
     */
    public $passCriteria;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Authors", type="text", length=65535, nullable=true)
     * @Groups({"question", "tour", "package"})
     */
    public $authors;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Sources", type="text", length=65535, nullable=true)
     * @Groups({"question", "tour", "package"})
     */
    public $sources;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Comments", type="text", length=65535, nullable=true)
     * @Groups({"question", "tour", "package"})
     */
    public $comments;

    /**
     * @return Tour
     */
    public function getTour(): Tour
    {
        return $this->tour;
    }
}
