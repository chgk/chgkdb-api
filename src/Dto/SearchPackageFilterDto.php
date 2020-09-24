<?php

namespace App\Dto;

use DateTimeInterface;

/**
 * Class SearchPackageFilterDto
 */
class SearchPackageFilterDto implements SearchDateFilterDtoInterface, SearchOrderFilterDtoInterface, SearchQueryDtoInterface
{
    /**
     * @var string
     */
    private string $query  = '';

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
    public function getQuery(): string
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
     * @return DateTimeInterface|null
     */
    public function getDateFrom(): ?DateTimeInterface
    {
        return $this->dateFrom;
    }

    /**
     * @param DateTimeInterface|null $dateFrom
     */
    public function setDateFrom(?DateTimeInterface $dateFrom): void
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

    public function exists()
    {
        return !empty($this->query) || !empty($this->dateFrom) ||!empty($this->dateTo);
    }
}