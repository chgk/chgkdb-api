<?php

namespace App\Dto;

use DateTimeInterface;

/**
 * Interface SearchDateFilterDtoInterface
 */
interface SearchDateFilterDtoInterface
{
    /**
     * @return DateTimeInterface
     */
    public function getDateFrom(): ?DateTimeInterface;

    /**
     * @param DateTimeInterface $dateFrom
     */
    public function setDateFrom(DateTimeInterface $dateFrom): void;

    /**
     * @return DateTimeInterface|null
     */
    public function getDateTo(): ?DateTimeInterface;

    /**
     * @param DateTimeInterface|null $dateTo
     */
    public function setDateTo(?DateTimeInterface $dateTo): void;
}