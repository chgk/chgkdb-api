<?php


namespace App\Dto;

use App\Search\ChgkDbSearchInterface;
use DateTimeInterface;

class SearchQuestionFilterDto
{
    /**
     * @var string
     */
    private string $query  = '';

    /**
     * @var string[]
     */
    private array $fields = [];

    /**
     * @var string[]
     */
    private array $questionTypes = [];

    /**
     * @var bool
     */
    private $anyWord = false;

    /**
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $dateFrom = null;

    /**
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $dateTo = null;

    /**
     * @var string|null
     */
    private ?string $orderBy = null;

    /**
     * @var bool
     */
    private $orderDesc = false;

    /**
     * @return string
     */
    public function getQuery() : string
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery(string $query): void
    {
        $this->query = $query;
    }

    /**
     * @return bool
     */
    public function exists()
    {
        if ($this->query || $this->orderBy) {
            return true;
        }

        return false;
    }

    /**
     * @return string[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * @return string[]
     */
    public function getQuestionTypes(): array
    {
        return $this->questionTypes;
    }

    /**
     * @param string[] $questionTypes
     */
    public function setQuestionTypes(array $questionTypes): void
    {
        $this->questionTypes = $questionTypes;
    }

    /**
     * @return bool
     */
    public function isAnyWord(): bool
    {
        return $this->anyWord;
    }

    /**
     * @param bool $anyWord
     */
    public function setAnyWord(bool $anyWord): void
    {
        $this->anyWord = $anyWord;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDateFrom(): ?DateTimeInterface
    {
        return $this->dateFrom;
    }

    /**
     * @param DateTimeInterface $dateFrom
     */
    public function setDateFrom(DateTimeInterface $dateFrom): void
    {
        $this->dateFrom = $dateFrom;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDateTo(): ?DateTimeInterface
    {
        return $this->dateTo;
    }

    /**
     * @param DateTimeInterface|null $dateTo
     */
    public function setDateTo(?DateTimeInterface $dateTo): void
    {
        $this->dateTo = $dateTo;
    }

    /**
     * @return string|null
     */
    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    /**
     * @param string|null $orderBy
     */
    public function setOrderBy(?string $orderBy): void
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @return bool
     */
    public function isOrderDesc(): bool
    {
        return $this->orderDesc;
    }

    /**
     * @param bool $orderDesc
     */
    public function setOrderDesc(bool $orderDesc): void
    {
        $this->orderDesc = $orderDesc;
    }
}