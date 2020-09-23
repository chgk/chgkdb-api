<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use App\Filter\ChgkDbSearchFilter;

/**
 * Questions
 *
 * @ORM\Table(name="Questions")
 * @ORM\Entity
 * @ApiResource(
 *     collectionOperations={
 *      "get"={"method"="GET", "requirements"={"_format"="\w+"}},
 *      "post"={"method"="POST"},
 *     },
 *     itemOperations={
 *      "get"={"method"="GET"},
 *      "put"={"method"="PUT"},
 *     },
 *     attributes={
 *      "normalization_context"={"groups"={"question", "package"}},
 *      "order"={"number": "ASC"}
 *     }
 * )
 * @ApiFilter(ChgkDbSearchFilter::class)
 */

class Question
{
    /**
     * @var string
     *
     * @ORM\Column(name="TextId", type="chgkdb_text_id", length=32, nullable=false, options={"fixed"=true})
     * @ORM\Id
     * @Groups({"tour_output", "tour_input", "package_output", "package_input", "question"})
     */
    private $id;

    /**
     * @var Tour
     *
     * @ORM\ManyToOne(targetEntity="Tour", cascade={"persist"}, inversedBy="questions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ParentTextId", referencedColumnName="TextId")
     * }
     * )
     * @ApiSubresource(maxDepth=1)
     * @Groups({"question"})
     */
    private $tour;

    /**
     * @var int
     *
     * @ORM\Column(name="Number", type="smallint", nullable=false, options={"unsigned"=true})
     * @Groups({"question", "tour_output", "tour_input", "package_output", "package_input"})
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="chgkdb_question_type", length=5, nullable=false, options={"default"="Ч","fixed"=true})
     * @Groups({"question", "tour_output", "tour_input", "package_output", "package_input"})
     */
    private $type = 'Ч';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Question", type="text", length=65535, nullable=true)
     * @Groups({"question", "tour_output", "tour_input", "package_output", "package_input"})
     */
    private $question;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Answer", type="text", length=65535, nullable=true)
     * @Groups({"question", "tour_output", "tour_input", "package_output", "package_input"})
     */
    private $answer;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PassCriteria", type="text", length=65535, nullable=true)
     * @Groups({"question", "tour_output", "tour_input", "package_output", "package_input"})
     */
    private $passCriteria;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Authors", type="text", length=65535, nullable=true)
     * @Groups({"question", "tour_output", "tour_input", "package_output", "package_input"})
     */
    private $authors;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Sources", type="text", length=65535, nullable=true)
     * @Groups({"question", "tour_output", "tour_input", "package_output", "package_input"})
     */
    private $sources;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Comments", type="text", length=65535, nullable=true)
     * @Groups({"question", "tour_output", "tour_input", "package_output", "package_input"})
     */
    private $comments;

    /**
     * @var int
     *
     * @ORM\Column(name="ParentId", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $parentLegacyId = 0;

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
     * @return Tour
     */
    public function getTour(): Tour
    {
        return $this->tour;
    }

    /**
     * @param Tour $tour
     */
    public function setTour(?Tour $tour): void
    {
        $this->tour = $tour;
        $this->setParentLegacyId($tour?$tour->getLegacyId():null);
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return null|string
     */
    public function getQuestion(): ?string
    {
        return $this->question;
    }

    /**
     * @param null|string $question
     */
    public function setQuestion(?string $question): void
    {
        $this->question = $question;
    }

    /**
     * @return null|string
     */
    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    /**
     * @param null|string $answer
     */
    public function setAnswer(?string $answer): void
    {
        $this->answer = $answer;
    }

    /**
     * @return null|string
     */
    public function getPassCriteria(): ?string
    {
        return $this->passCriteria;
    }

    /**
     * @param null|string $passCriteria
     */
    public function setPassCriteria(?string $passCriteria): void
    {
        $this->passCriteria = $passCriteria;
    }

    /**
     * @return null|string
     */
    public function getAuthors(): ?string
    {
        return $this->authors;
    }

    /**
     * @param null|string $authors
     */
    public function setAuthors(?string $authors): void
    {
        $this->authors = $authors;
    }

    /**
     * @return null|string
     */
    public function getSources(): ?string
    {
        return $this->sources;
    }

    /**
     * @param null|string $sources
     */
    public function setSources(?string $sources): void
    {
        $this->sources = $sources;
    }

    /**
     * @return null|string
     */
    public function getComments(): ?string
    {
        return $this->comments;
    }

    /**
     * @param null|string $comments
     */
    public function setComments(?string $comments): void
    {
        $this->comments = $comments;
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
}
